<?php

class Gap
{
    public $gapStart;
    public $gapEnd;

    public function getGapSize(): int
    {
        return ($this->gapEnd - $this->gapStart) + 1;
    }

    public static function findGapsInArrayOfNumbers(array $numbers, int $desiredGapSize = null): array
    {
        $gaps = [];
        $numbersKeyed = array_flip($numbers);
        $max = max($numbers);
        $min = min($numbers);

        $gap = null;
        for ($i = $min; $i <= $max; $i++)
        {
            if (!isset($numbersKeyed[$i]) && is_null($gap))
            {
                $gap = new static;
                $gaps[] = $gap;
                $gap->gapStart = $i;
            } elseif (isset($numbersKeyed[$i]) && !is_null($gap))
            {
                $gap->gapEnd = $i - 1;
                $gap = null;
            }
        }

        if (!is_null($desiredGapSize))
        {
            $gaps = array_filter($gaps, function (Gap $gap) use ($desiredGapSize) {
                return $gap->getGapSize() == $desiredGapSize;
            });
        }

        return $gaps;
    }
}