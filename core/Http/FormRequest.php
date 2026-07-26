<?php

namespace Core\Http;

use Core\Validator;

abstract class FormRequest extends Request
{
    protected ?Validator $validator = null;

    public function __construct(array $get = [], array $post = [], array $files = [], array $server = [])
    {
        parent::__construct($get, $post, $files, $server);

        $this->validate();
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    abstract public function rules(): array;

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [];
    }

    /**
     * Execute request authorization and validation.
     */
    public function validate(array $rules = [], array $messages = []): Validator
    {
        if (! $this->authorize()) {
            http_response_code(403);
            die('403 Forbidden: Unauthorized request.');
        }

        $effectiveRules = !empty($rules) ? $rules : $this->rules();
        $effectiveMessages = !empty($messages) ? $messages : $this->messages();

        $this->validator = Validator::make(
            $this->all(),
            $effectiveRules,
            $effectiveMessages
        );

        return $this->validator;
    }

    /**
     * Determine if validation passed.
     */
    public function passes(): bool
    {
        return $this->validator ? $this->validator->passes() : true;
    }

    /**
     * Determine if validation failed.
     */
    public function fails(): bool
    {
        return ! $this->passes();
    }

    /**
     * Get error messages array.
     */
    public function errors(): array
    {
        return $this->validator ? $this->validator->errors() : [];
    }

    /**
     * Get only the validated fields.
     */
    public function validated(): array
    {
        $validatedKeys = array_keys($this->rules());
        $all = $this->all();

        return array_intersect_key($all, array_flip($validatedKeys));
    }
}
