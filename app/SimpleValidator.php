<?php

namespace App;

class SimpleValidator
{
    private mixed $value;
    private string $name = '';
    private array $errors = [];

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setValue(mixed $value): self
    {
        $this->value = $value;
        return $this;
    }

    public function required(): self
    {
        if ($this->value === null || $this->value === '') {
            $this->addError(sprintf('The %s field is required.', $this->name));
        }
    }

    public function email(): self
    {
        $regex = '/^([a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+[.]+[a-z-A-Z]+)$/u';
        if ($this->value != '' && !preg_match($regex, $this->value)) {
            $this->addError(sprintf('The %s must be a valid email address.', $this->name));
        }
        return $this;
    }

    public function min(int $length): self
    {
        $value = is_string($this->value) ? strlen($this->value) : $this->value;
        if ($value < $length) {
            $this->addError(sprintf('The %s must be at least %d characters.', $this->name, $length));
        }
        return $this;
    }

    public function max(int $length): self
    {
        $value = is_string($this->value) ? strlen($this->value) : $this->value;
        if ($value > $length) {
            $this->addError(sprintf('The %s must not be greater than %d characters.', $this->name, $length));
        }
        return $this;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function isValid(): bool
    {
        return empty($this->errors);
    }

    private function addError(string $error_message): void
    {
        $this->errors[$this->name][] = $error_message;
    }
}
