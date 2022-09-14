<?php

namespace App\Validator;

use Illuminate\Support\MessageBag;
use Illuminate\Validation\Validator;

class CustomValidator extends Validator
{
    public function addFailure($attribute, $rule, $parameters = [])
    {
        if (!$this->messages) {
            $this->passes();
        }

        $attribute = str_replace(
            [$this->dotPlaceholder, '__asterisk__'],
            ['.', '*'],
            $attribute
        );

        if (in_array($rule, $this->excludeRules)) {
            return $this->exclude(($attribute));
        }

        $message = $this->getMessage($attribute, $rule);

        $message = $this->makeReplacements($message, $attribute, $rule, $parameters);

        $customMessage = new MessageBag();

        $customMessage->merge(['code' => strtolower($rule . '_rule_error')]);

        if ($rule !== 'Unique') {
            $parts = explode(':', $this->currentRule);

            if (count($parts) >= 2) {
                $boundaries = explode(',', $parts[1]);
                $boundaries_count = count($boundaries);

                if ($boundaries_count == 1) {
                    $customMessage->merge(['value' => $boundaries[0]]);
                }

                if ($boundaries_count > 1) {
                    $customMessage->merge(['lower' => $boundaries[0]]);
                }

                if ($boundaries_count >= 2) {
                    $customMessage->merge(['upper' => $boundaries[1]]);
                }
            }
        }

        $this->messages->add($attribute, $customMessage);
    }
}