<?php
class Rule
{
    protected $color;
    protected $canContain = [];

    public function __construct(string $color)
    {
        $this->color = $color;
    }

    public static function buildFromString(string $definition)
    {
        if (preg_match('/(.*) bags contain (.*)/', $definition, $matches))
        {
            [,$color,$containsDefinition] = $matches;
            $rule = new static($color);
            $allDefinitions = explode(',', $containsDefinition);
            foreach ($allDefinitions as $containsColorDefinition)
            {
                if (preg_match('/([0-9]+) (.*) bag/', $containsColorDefinition, $containsMatches))
                {
                    [,$quantity,$containsColor] = $containsMatches;
                    $rule->setCanContain($containsColor, $quantity);
                }
            }
            return $rule;
        }
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function getAllContainedColors(): array
    {
        return array_keys($this->canContain);
    }

    public function setCanContain(string $color, int $quantity)
    {
        $this->canContain[$color] = $quantity;
    }

    public function checkCanContain(string $color, int $quantity): bool
    {
        return isset($this->canContain[$color]) && $this->canContain[$color] >= $quantity;
    }
}