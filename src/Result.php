<?php

declare(strict_types=1);

namespace Yiisoft\Validator;

final class Result
{
    /**
     * @psalm-var list<string>
     */
    private array $errors = [];

    private ?string $attribute = null;

    public function isValid(): bool
    {
        return $this->errors === [];
    }

    public function addError(string $message): void
    {
        $this->errors[] = $message;
    }

    /**
     * @psalm-return list<string>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function setAttribute(string $attribute): void
    {
        $this->attribute = $attribute;
    }

    public function getAttribute(): ?string
    {
        return $this->attribute;
    }
}
