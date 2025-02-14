<?php

declare(strict_types=1);

namespace Yiisoft\Validator;

use ArrayIterator;
use InvalidArgumentException;
use IteratorAggregate;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\VarDumper\VarDumper;

/**
 * ResultSet stores validation result of each attribute from {@link DataSetInterface}.
 * It is typically obtained by validating data set with {@link Validator}.
 */
final class ResultSet implements IteratorAggregate
{
    /**
     * @var Result[]
     * @psalm-var array<string, Result>
     */
    private array $results = [];
    private bool $isValid = true;

    public function addResult(string $attribute, Result $result): void
    {
        if (!$result->isValid()) {
            $this->isValid = false;
        }

        if (!isset($this->results[$attribute])) {
            $this->results[$attribute] = $result;
            return;
        }

        if ($result->isValid()) {
            return;
        }

        foreach ($result->getErrors() as $error) {
            $this->results[$attribute]->addError($error);
        }
    }

    public function getResult(string $attribute): Result
    {
        if (!isset($this->results[$attribute])) {
            throw new InvalidArgumentException("There is no result for attribute \"$attribute\"");
        }

        return $this->results[$attribute];
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->results);
    }

    /**
     * @return string[][]
     * @psalm-return array<string, list<string>>
     */
    public function getErrors(): array
    {
        $errors = [];
        foreach ($this->results as $attribute => $result) {
            if (!$result->isValid()) {
                foreach ($result->getErrors() as $error) {
                    if ($error->getAttribute()) {
                        if (strpos($error->getAttribute(), '.') === false) {
                            $errors[$attribute][$error->getAttribute()][] = $error->getMessage();
                        } else {
                            $path = "$attribute.{$error->getAttribute()}";
                            $value = ArrayHelper::getValueByPath($errors, $path) ?? [];
                            $value[] = $error->getMessage();

                            ArrayHelper::setValueByPath(
                                $errors,
                                "$attribute.{$error->getAttribute()}",
                                $value
                            );
                        }
                    } else {
                        $errors[$attribute][] = $error->getMessage();
                    }
                }
            }
        }

        return $errors;
    }

    public function isValid(): bool
    {
        return $this->isValid;
    }
}
