<?php declare(strict_types=1);

namespace RobbertStevens\Exception;

use RuntimeException;

final class UnexpectedExpressionResult extends RuntimeException
{
    /**
     * @param string $expression
     * @param mixed $fact
     * @return static
     */
    public static function fromExpression(string $expression, $fact): self
    {
        $message = "The given expression '{$expression}' didn't give a boolean result";
        return new self($message);
    }
}
