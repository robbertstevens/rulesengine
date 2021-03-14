<?php declare(strict_types=1);

namespace App\Rule;

use App\Exception\UnexpectedExpressionResult;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

final class ExpressionLanguageRule
{
    private ExpressionLanguage $expressionLanguage;
    private string $expression;

    public function __construct(string $expression)
    {
        $this->expressionLanguage = new ExpressionLanguage();
        $this->expression = $expression;
    }

    /**
     * @param mixed $fact
     * @return bool
     */
    public function __invoke($fact): bool
    {
        /** @var mixed $result */
        $result = $this->expressionLanguage->evaluate($this->expression, ['fact' => $fact]);

        if (is_bool($result)) {
            return $result;
        }

        throw UnexpectedExpressionResult::fromExpression($this->expression, $fact);
    }
}
