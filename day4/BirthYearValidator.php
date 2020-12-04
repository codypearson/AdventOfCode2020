<?php
require_once 'Validator.php';

class BirthYearValidator implements Validator
{
    public function validate($value): bool
    {
        return $value >= 1920 && $value <= 2002;
    }
}