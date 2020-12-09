<?php
class NumberList
{
    const PREAMBLE_SIZE = 25;
    const LOOKBACK = 25;
    public $numberList = [];

    public function __construct($input)
    {
        if (is_resource($input))
        {
            $this->fromStream($input);
        }
    }

    public function fromStream($stream)
    {
        $this->numberList = [];
        while ($line = fgets($stream))
        {
            if (is_numeric($line))
            {
                $this->numberList[] = (int) $line;
            }
        }
    }

    public function sumPairs(array $numbers): array
    {
        $sums = [];

        $length = count($numbers);
        foreach ($numbers as $index => $x)
        {
            for ($i = ($index + 1); $i < $length; $i++)
            {
                $sums[] = $x + $numbers[$i];
            }
        }

        return $sums;
    }

    public function checkNumberAtPosition(int $index): bool
    {
        $numbersToSum = array_slice($this->numberList, ($index - static::LOOKBACK), static::LOOKBACK);
        $sums = $this->sumPairs($numbersToSum);

        return in_array($this->numberList[$index], $sums);
    }

    public function checkAllNumbersAfterPreamble(): array
    {
        $numbers = [];
        $listSize = count($this->numberList);
        for ($i = static::PREAMBLE_SIZE; $i < $listSize; $i++)
        {
            $numbers[$this->numberList[$i]] = $this->checkNumberAtPosition($i);
        }

        return $numbers;
    }

    public function findSum(int $sum): array|false
    {
        foreach ($this->numberList as $startIndex => $startNumber)
        {
            $sumCandidate = $startNumber;
            $currentIndex = $startIndex;
            do {
                $currentIndex++;
                if (!isset($this->numberList[$currentIndex]))
                {
                    return false;
                }
                $sumCandidate += $this->numberList[$currentIndex];
                if ($sumCandidate == $sum)
                {
                    return array_slice($this->numberList, $startIndex, ($currentIndex - $startIndex));
                }
            } while ($sumCandidate < $sum);
        }
        return false;
    }
}