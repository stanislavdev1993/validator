<?php

declare(strict_types=1);

namespace Yiisoft\Validator;

final class Error implements ErrorInterface
{
    private string $message;
    private ?string $attribute = null;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function getAttribute(): ?string
    {
        return $this->attribute;
    }

    public function withAttribute(string $attribute): self
    {
        if ($this->attribute) {
            $this->attribute = "$attribute.{$this->attribute}";
        } else {
            $this->attribute = $attribute;
        }

        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
