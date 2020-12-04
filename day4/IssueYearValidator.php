<?php
require_once 'Validator.php';

class IssueYearValidator implements Validator
{
    public function validate($value): bool
    {
        return $value >= 2010 && $value <= 2020;
    }
}