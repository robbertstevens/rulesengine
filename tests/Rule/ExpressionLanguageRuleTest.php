<?php

namespace RobbertStevens\Tests\Rule;

use RobbertStevens\Exception\UnexpectedExpressionResult;
use RobbertStevens\Rule\ExpressionLanguageRule;
use PHPUnit\Framework\TestCase;
use stdClass;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

/**
 * @coversDefaultClass \RobbertStevens\Rule\ExpressionLanguageRule
 */
class ExpressionLanguageRuleTest extends TestCase
{
    /**
     * @test
     * @covers ::__invoke
     */
    public function it_evaluates_the_expression(): void
    {
        $rule = new ExpressionLanguageRule("1 + 2 == fact" );

        $this->assertTrue($rule(3));
    }

    /**
     * @test
     * @covers ::__invoke
     */
    public function it_evaluates_to_an_exception_when_expression_does_not_result_in_boolean(): void
    {
        $this->expectException(UnexpectedExpressionResult::class);

        $rule = new ExpressionLanguageRule("1 + 2" );

        $rule(10);
    }

    /**
     * @test
     * @covers ::__invoke
     */
    public function it_evaluates_a_complex_expression()
    {
        $rule = new ExpressionLanguageRule("fact.name == 'john'");

        $fact = new stdClass();
        $fact->name = 'john';

        $this->assertTrue($rule($fact));
    }
}
