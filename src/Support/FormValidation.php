<?php

namespace App\Support;

use Respect\Validation\Exceptions\NestedValidationException;

class FormValidation
{
    public static function validate(array $data, array $rules): array
    {
        $errors = [];

        foreach ($rules as $key => $rule) {
            try {
                $rule->assert($data["$key"] ?? null);
            } catch (NestedValidationException $e) {
                $errors[$key] = $e->getMessages();
            }
        }

        return $errors;
    }
}