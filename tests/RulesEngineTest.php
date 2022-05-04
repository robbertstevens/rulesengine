<?php declare(strict_types=1);

namespace RobbertStevens\Tests;

use RobbertStevens\RulesEngine;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass RulesEngine
 */
class RulesEngineTest extends TestCase
{
    /**
     * @test
     * @covers ::evaluate
     */
    public function it_evaluates_a_rule_with_an_arrow_function(): void
    {
        $ruleEngine = new RulesEngine();

        $this->assertTrue($ruleEngine->evaluate(10, fn($fact) => $fact > 5));
    }

    /**
     * @test
     * @covers ::validateAll
     */
    public function it_validates_all_the_rules(): void
    {
        $ruleEngine = new RulesEngine([
            fn($fact) => $fact > 5,
            fn($fact) => $fact % 2 === 0,
        ]);

        $this->assertTrue($ruleEngine->validateAll(10));
    }

    /**
     * @test
     * @covers ::validateAny
     */
    public function it_validates_any_of_the_rules(): void
    {
        $ruleEngine = new RulesEngine([
            fn($fact) => $fact > 5,
            fn($fact) => $fact % 2 !== 0,
        ]);

        $this->assertTrue($ruleEngine->validateAny(10));
    }

    /**
     * @test
     * @covers ::addRule
     * @uses ::validateAll
     */
    public function it_validates_a_rule_after_its_been_added(): void
    {
        $ruleEngine = new RulesEngine();

        $this->assertTrue($ruleEngine->validateAll(10));

        $ruleEngine->addRule(fn($fact) => $fact > 20);

        $this->assertFalse($ruleEngine->validateAll(10));
    }

    /**
     * @test
     * @covers ::addRules
     * @uses ::validateAll
     */
    public function it_validates_all_the_rules_after_adding_multiple_rules(): void
    {
        $ruleEngine = new RulesEngine();

        $this->assertTrue($ruleEngine->validateAll(10));

        $ruleEngine->addRules([
            fn($fact) => $fact > 5,
            fn($fact) => $fact % 2 !== 1,
        ]);

        $this->assertTrue($ruleEngine->validateAny(10));
    }
}
