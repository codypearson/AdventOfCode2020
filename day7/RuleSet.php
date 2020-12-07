<?php
require_once 'Rule.php';

class RuleSet
{
    protected $ruleIndex = [];

    public static function buildFromStream($stream): static
    {
        $set = new static;
        while ($line = fgets($stream))
        {
            $rule = Rule::buildFromString($line);
            if ($rule instanceof Rule)
            {
                $set->addRule($rule);
            }
        }

        return $set;
    }

    public function addRule(Rule $rule)
    {
        $this->ruleIndex[$rule->getColor()] = $rule;
    }

    public function canContain(string $color, int $quantity): array
    {
        $canContain = [];
        foreach (array_keys($this->ruleIndex) as $containerColor)
        {
            if ($this->canContainRecursive($containerColor, $color, $quantity))
            {
                $canContain[] = $containerColor;
            }
        }
        return $canContain;
    }

    public function canContainRecursive(string $colorOfContainer, string $colorToContain, int $quantity): bool
    {
        $parentRule = $this->ruleIndex[$colorOfContainer] ?? null;
        if (is_null($parentRule))
        {
            return false;
        } elseif ($parentRule->checkCanContain($colorToContain, $quantity))
        {
            return true;
        } else
        {
            $allContainedColors = $parentRule->getAllContainedColors();
            foreach ($allContainedColors as $color)
            {
                if ($this->canContainRecursive($color, $colorToContain, $quantity))
                {
                    return true;
                }
            }
        }
        return false;
    }

    public function getBagsContained(string $color): int
    {
        $bagsContained = 0;
        if (isset($this->ruleIndex[$color]))
        {
            $parentRule = $this->ruleIndex[$color];
            $canContain = $parentRule->getCanContain();
            foreach ($canContain as $containColor => $quantity)
            {
                $bagsContained += $quantity + ($this->getBagsContained($containColor) * $quantity);
            }
        }

        return $bagsContained;
    }
}