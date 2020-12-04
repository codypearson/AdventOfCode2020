<?php
require_once 'Validator.php';

class PassportIdValidator implements Validator
{
    public function validate($value): bool
    {
        return (bool) preg_match('/^[0-9]{9}$/', $value);
    }
}