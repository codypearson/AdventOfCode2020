<?php
require_once 'Validator.php';

class ExpirationYearValidator implements Validator
{
    public function validate($value): bool
    {
        return $value >= 2020 && $value <= 2030;
    }
}