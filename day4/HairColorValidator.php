<?php
require_once 'Validator.php';

class HairColorValidator implements Validator
{
    public function validate($value): bool
    {
        return (bool) preg_match('/^#[0-9a-f]{6}$/', $value);
    }
}