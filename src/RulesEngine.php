<?php declare(strict_types=1);

namespace RobbertStevens;

class RulesEngine
{
    private array $rules;

    public function __construct(array $rules = [])
    {
        $this->rules = $rules;
    }

    /**
     * @param mixed $fact
     * @param callable(mixed):bool $rule
     * @return bool
     */
    public function evaluate($fact, callable $rule): bool
    {
        return $rule($fact);
    }

    /**
     * @param mixed $fact
     * @return bool
     */
    public function validateAll($fact): bool
    {
        /** @var callable(mixed):bool $rule */
        foreach ($this->rules as $rule) {
            if (!$this->evaluate($fact, $rule)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param mixed $fact
     * @return bool
     */
    public function validateAny($fact): bool
    {
        /** @var callable(mixed):bool $rule */
        foreach ($this->rules as $rule) {
            if ($this->evaluate($fact, $rule)) {
                return true;
            }
        }

        return false;
    }

    public function addRule(callable $rule): void
    {
        $this->rules[] = $rule;
    }

    public function addRules(array $rules): void
    {
        $this->rules = array_merge($this->rules, $rules);
    }
}
