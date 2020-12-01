<?php

const SUM_VALUE = 2020;

$expenseEntries = [];

while ($line = fgets(STDIN)) {
    if (is_numeric($line)) {
        $expenseEntries[] = (int) $line;
    }
}

$expenseKeys = array_flip($expenseEntries);

foreach ($expenseEntries as $key => $expenseEntry) 
{
    if ($expenseEntry < SUM_VALUE)
    {
        $desiredValue = SUM_VALUE - $expenseEntry;
        if (array_key_exists($desiredValue, $expenseKeys) && $expenseKeys[$desiredValue] != $key) {
            $result = ($expenseEntry * $desiredValue);
            break;
        }
    }
}

echo (isset($result) ? $result : 'Result not found') . "\n";