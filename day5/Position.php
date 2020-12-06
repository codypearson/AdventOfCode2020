<?php

class Position
{
    const UPPER = 0;
    const LOWER = 1;
    const ROW_MIN = 0;
    const ROW_MAX = 127;
    const COL_MIN = 0;
    const COL_MAX = 7;

    public $rowIndex;
    public $columnIndex;
    
    public function setRowAndColumnFromPartition(string $partitionDefinition)
    {
        if (!preg_match('/([BF]{7})([LR]{3})/', $partitionDefinition, $matches))
        {
            throw new \Exception('Invalid partition');
        }
        [,$rowDefiniton,$columnDefintion] = $matches;
        $this->rowIndex = $this->calculateRowFromPartition($rowDefiniton, static::ROW_MIN, static::ROW_MAX, 'F', 'B');
        $this->columnIndex = $this->calculateRowFromPartition($columnDefintion, static::COL_MIN, static::COL_MAX, 'L', 'R');
    }

    private function calculateRowFromPartition(string $rowPartition, int $indexMin, int $indexMax, string $lowerCharacter, string $upperCharacter)
    {
        foreach(str_split($rowPartition) as $character)
        {
            if ($character == $lowerCharacter)
            {
                $upperOrLower = static::LOWER;
            } elseif ($character == $upperCharacter)
            {
                $upperOrLower = static::UPPER;
            }
            $newRange = $this->splitRange($upperOrLower, $indexMin, $indexMax);
            if (is_array($newRange))
            {
                [$indexMin, $indexMax] = $newRange;
            }
        }
        return $newRange;
    }

    private function splitRange(int $upperOrLower, int $rangeMin, int $rangeMax): int|array
    {
        $midpoint = (($rangeMax - $rangeMin) / 2) + $rangeMin;
        if ($upperOrLower == static::UPPER)
        {
            $rangeMin = (int) ceil($midpoint);
        } elseif ($upperOrLower == static::LOWER)
        {
            $rangeMax = (int) floor($midpoint);
        }

        return ($rangeMin == $rangeMax) ? $rangeMax : [$rangeMin, $rangeMax];
    }

    public function getSeatId(): int
    {
        return ($this->rowIndex * 8) + $this->columnIndex;
    }
}