<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Domain\Users\Models\User;
use Domain\Users\Events\LoggedOut;
use App\Http\Resources\UserResource;
use Domain\Users\Requests\LoginRequest;
use Domain\Users\Requests\VerifyRequest;
use Domain\Users\Requests\ResendRequest;
use Illuminate\Validation\ValidationException;
use Domain\Auth\Actions\CreateOrUpdateDeviceTokensAction;

class LoginController extends Controller
{
    public function __construct(
        private CreateOrUpdateDeviceTokensAction $createOrUpdateDeviceTokensAction
    )
    {
    }

    public function login(
        LoginRequest $request,
    )
    {
        /** @var User $user */
        $user = User::query()->firstOrCreate(['mobile' => $request->mobile]);

        if ($user_id = $request->user_id) {
            User::query()->anonymous()->find($user_id)->forceDelete();
        }

        ($this->createOrUpdateDeviceTokensAction)($request, $user);

        $user->send();

        return new UserResource($user);
    }

    public function verify(
        VerifyRequest $request,
    )
    {
        /** @var User $user */
        $user = User::byMobile($request->mobile);

        if (!$user->isCodeValid($request->code)) {
            throw ValidationException::withMessages([
                'code' => trans('incorrect_code'),
            ]);
        }

        $device = ($this->createOrUpdateDeviceTokensAction)($request, $user);

        $token = $user->verify($device);

        return (new UserResource($user))->additionalMeta([
            'token' => $token,
        ]);
    }

    public function resend(ResendRequest $request)
    {
        $user = $request->user() ?? $request->getUserByMobile();

        abort_unless($user->canResendCode(), 403, 'cant_generate_code');

        $user->send();

        return $this->success(trans('validation.sms_in_sending'));
    }

    public function logout(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        $user->update([
            'is_verified' => false
        ]);

        event(new LoggedOut($user, $request->all));

        return $this->success(trans('validation.success'));
    }

    /*
     * when firebase token expired or invalid
     */
    public function updateDeviceToken(Request $request)
    {
        $user = $request->user();

        ($this->createOrUpdateDeviceTokensAction)($request, $user);

        return $this->success();
    }
}
