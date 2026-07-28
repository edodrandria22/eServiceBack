<?php

namespace App\Dto\utils;

class FieldsCriteria
{
    private string $field;
    private string $value;

    public function __construct(string $field, ?string $value = null)
    {
        $this->field = $field;
        $this->value = $value ?? $field;
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function setField(string $field): self
    {
        $this->field = $field;
        return $this;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;
        return $this;
    }


}