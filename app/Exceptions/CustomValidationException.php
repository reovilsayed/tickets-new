<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;

class CustomValidationException extends ValidationException
{
    public static function withMessages(array $messages)
    {
        $validator = \Validator::make([], []);
        foreach ($messages as $key => $message) {
            $validator->errors()->add($key, $message);
        }

        return new static($validator);
    }
}
