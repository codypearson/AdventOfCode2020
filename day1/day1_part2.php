<?php

$expenseEntries = [];

while ($line = fgets(STDIN)) {
    if (is_numeric($line)) {
        $expenseEntries[] = (int) $line;
    }
}

function findSum (array $numberList, int $desiredSum, int $count)
{
    if ($count == 1)
    {
        return (array_search($desiredSum, $numberList) !== false) ? [$desiredSum] : null;
    } else {
        foreach ($numberList as $number) {
            $desiredNumber = $desiredSum - $number;
            $result = findSum($numberList, $desiredNumber, ($count - 1));
            if (is_array($result)) {
                array_unshift($result, $number);
                return $result;
            }
        }
        return null;
    }
}

function multiplyAll (array $numbers)
{
    if (count($numbers) < 2) {
        return null;
    } else {
        $result = array_shift($numbers);
        while (!is_null($nextNum = array_shift($numbers))) {
            $result *= $nextNum;
        }
        return $result;
    }
}

echo(multiplyAll(findSum($expenseEntries, 2020, 3)));