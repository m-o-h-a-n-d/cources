<?php

namespace Core;

class Validator
{
    protected array $data = [];
    protected array $rules = [];
    protected array $messages = [];
    protected array $errors = [];

    public function __construct(array $data = [], array $rules = [], array $messages = [])
    {
        $this->data = $data;
        $this->rules = $rules;
        $this->messages = $messages;
    }

    /**
     * Create and execute a validator instance.
     */
    public static function make(array $data, array $rules, array $messages = []): static
    {
        $validator = new static($data, $rules, $messages);
        $validator->validate();
        return $validator;
    }

    /**
     * Determine if validation passed.
     */
    public function passes(): bool
    {
        return empty($this->errors);
    }

    /**
     * Determine if validation failed.
     */
    public function fails(): bool
    {
        return ! $this->passes();
    }

    /**
     * Get error messages.
     */
    public function errors(): array
    {
        return $this->errors;
    }

    /**
     * Run validation rules.
     */
    public function validate(): bool
    {
        $this->errors = [];

        foreach ($this->rules as $field => $ruleset) {
            $rulesArray = is_string($ruleset) ? explode('|', $ruleset) : $ruleset;
            $value = $this->data[$field] ?? null;

            foreach ($rulesArray as $rule) {
                $ruleName = $rule;
                $parameter = null;

                if (str_contains($rule, ':')) {
                    [$ruleName, $parameter] = explode(':', $rule, 2);
                }

                $ruleName = trim($ruleName);

                if ($ruleName === 'required') {
                    if (! static::required($value)) {
                        $this->addError($field, 'required', "The {$field} field is required.");
                        break;
                    }
                } elseif (static::isEmpty($value)) {
                    continue;
                } elseif ($ruleName === 'email') {
                    if (! static::email($value)) {
                        $this->addError($field, 'email', "The {$field} must be a valid real email address.");
                    }
                } elseif ($ruleName === 'egyptian_phone' || $ruleName === 'egypt_phone') {
                    if (! static::egyptianPhone($value)) {
                        $this->addError($field, 'egyptian_phone', "The {$field} must be a valid Egyptian mobile phone number.");
                    }
                } elseif ($ruleName === 'min' && $parameter !== null) {
                    if (! static::min($value, (int)$parameter)) {
                        $this->addError($field, 'min', "The {$field} must be at least {$parameter} characters.");
                    }
                } elseif ($ruleName === 'max' && $parameter !== null) {
                    if (! static::max($value, (int)$parameter)) {
                        $this->addError($field, 'max', "The {$field} must not exceed {$parameter} characters.");
                    }
                } elseif ($ruleName === 'numeric') {
                    if (! static::numeric($value)) {
                        $this->addError($field, 'numeric', "The {$field} must be a number.");
                    }
                } elseif ($ruleName === 'string') {
                    if (! is_string($value)) {
                        $this->addError($field, 'string', "The {$field} must be a string.");
                    }
                } elseif ($ruleName === 'in' && $parameter !== null) {
                    $allowed = explode(',', $parameter);
                    if (! in_array((string)$value, $allowed, true)) {
                        $this->addError($field, 'in', "The selected {$field} is invalid.");
                    }
                }
            }
        }

        return $this->passes();
    }

    protected function addError(string $field, string $rule, string $defaultMessage): void
    {
        $customKey = "{$field}.{$rule}";
        $message = $this->messages[$customKey] ?? $this->messages[$field] ?? $defaultMessage;
        $this->errors[$field][] = $message;
    }

    protected static function isEmpty(mixed $value): bool
    {
        return $value === null || $value === '' || (is_array($value) && empty($value));
    }

    // Static Rule Helpers
    public static function required(mixed $value): bool
    {
        if (is_null($value)) {
            return false;
        }
        if (is_string($value)) {
            return trim($value) !== '';
        }
        if (is_array($value)) {
            return ! empty($value);
        }
        return true;
    }

    /**
     * Validate real email format and domain MX DNS records.
     */
    public static function email(mixed $value): bool
    {
        if (! is_string($value)) {
            return false;
        }

        $email = trim($value);

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            return false;
        }

        $domain = substr(strrchr($email, "@"), 1);

        if (empty($domain)) {
            return false;
        }

        // Verify domain MX or A DNS records
        if (function_exists('checkdnsrr')) {
            return checkdnsrr($domain, 'MX') || checkdnsrr($domain, 'A');
        }

        return true;
    }

    /**
     * Validate Egyptian mobile phone numbers (010, 011, 012, 015 or international +20).
     */
    public static function egyptianPhone(mixed $value): bool
    {
        if (! is_string($value) && ! is_numeric($value)) {
            return false;
        }

        $phone = trim((string)$value);

        // Matches 01012345678, 01112345678, 01212345678, 01512345678, +201012345678, 00201012345678
        $pattern = '/^(?:\+20|0020|0)?1[0125]\d{8}$/';

        return (bool) preg_match($pattern, $phone);
    }

    public static function min(mixed $value, int $length): bool
    {
        if (is_numeric($value)) {
            return $value >= $length;
        }
        return strlen((string)$value) >= $length;
    }

    public static function max(mixed $value, int $length): bool
    {
        if (is_numeric($value)) {
            return $value <= $length;
        }
        return strlen((string)$value) <= $length;
    }

    public static function numeric(mixed $value): bool
    {
        return is_numeric($value);
    }
}