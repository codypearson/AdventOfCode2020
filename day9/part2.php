<?php
require_once 'NumberList.php';

$list = new NumberList(STDIN);
$numbersValidated = $list->checkAllNumbersAfterPreamble();
$validNumbers = array_filter($numbersValidated, function (bool $value) {
    return !$value;
});

reset($validNumbers);
$firstInvalid = key($validNumbers);
$sumSequence = $list->findSum($firstInvalid);
echo min($sumSequence) + max($sumSequence);