<?php

declare(strict_types=1);

namespace Yiisoft\Validator;

interface ErrorInterface
{
    public function withAttribute(string $attribute): self;
    public function getAttribute(): ?string;
    public function getMessage(): string;
}
