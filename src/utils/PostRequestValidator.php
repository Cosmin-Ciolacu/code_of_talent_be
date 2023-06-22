<?php

namespace Src\utils;

class PostRequestValidator
{
    private array $invalidFields = [];

    public function __construct(private array $validationRules) {}

    /**
     * @throws \Exception
     */
    public function validate(): array
    {
        $_POST = json_decode(file_get_contents('php://input'), true);


        foreach ($this->validationRules as $field => $fieldRules) {
            $rules = explode('|', $fieldRules);
            $rulesParam = count($rules) > 1 ? $rules : $rules[0];
            $this->validateField($field, $rulesParam);
        }
        if (!empty($this->invalidFields)) {
            throw new \Exception('Validation failed for the following fields: ' . implode(', ', $this->invalidFields));
        }

        return $_POST;
    }

    private function validateField($field, $rules)
    {
        $value = $_POST[$field];

        if (is_array($rules)) {
            foreach ($rules as $rule) {
                if (!$this->checkRule($rule, $value)) {
                    $this->invalidFields[] = $field;
                    return;
                }
            }
        } else {
            if (!$this->checkRule($rules, $value)) {
                $this->invalidFields[] = $field;
                return;
            }
        };
    }

    private function checkRule($rule, $value): bool
    {

        return match ($rule) {
            'required' => !empty($value),
            'numeric' => is_numeric($value),
            'email' => filter_var($value, FILTER_VALIDATE_EMAIL) !== false,
            default => false,
        };
    }
}