<?php

namespace Domain\Auth\Actions;

use Exception;
use App\Models\Setting;
use Domain\Users\Models\User;
use Illuminate\Support\Facades\Http;

class SendSmsISProviderAction
{
    public TrackSmsLogAction $trackSmsLogAction;

    public function __construct(TrackSmsLogAction $trackSmsLogAction)
    {
        $this->trackSmsLogAction = $trackSmsLogAction;
    }

    /**
     * @param User $auth
     */
    public function __invoke($auth, $message = null, $code = null)
    {
        $code = $code ?? $auth->verification_code;
        $mobile = $auth->getVerificationMobile();
        $il_api = 'http://send.triple-core.com/sendbulksms.php?api_token=:token:&sender=:sender:&mobile=:phone:&type=0&text=:msg:';

        try {
            $body = $message ?? $auth->smsText();
            $token = Setting::value(Setting::IS_SMS_TOKEN);
            $sender = Setting::value(Setting::IS_SMS_SENDER);
            $url = str_replace(':token:', $token, $il_api);
            $url = str_replace(':sender:', $sender, $url);
            $url = str_replace(':phone:', $mobile, $url);
            $url = str_replace(':msg:', $body, $url);

            $request = Http::get($url);
            $response = $request->getBody()->getContents();

            ($this->trackSmsLogAction)( true, $response, $mobile, $code);
        } catch (Exception $exception) {

            ($this->trackSmsLogAction)(false, $exception->getMessage(), $mobile, $code);
        }
    }
}