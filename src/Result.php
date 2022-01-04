<?php

declare(strict_types=1);

namespace Yiisoft\Validator;

final class Result
{
    /**
     * @psalm-var list<ErrorInterface>
     */
    private array $errors = [];

    public function isValid(): bool
    {
        return $this->errors === [];
    }

    public function addError(ErrorInterface $error): void
    {
        $this->errors[] = $error;
    }

    /**
     * @psalm-return list<ErrorInterface>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
