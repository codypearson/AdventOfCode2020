<?php
require_once 'Validator.php';

class EyeColorValidator implements Validator
{
    public function validate($value): bool
    {
        switch ($value)
        {
            case 'amb':
            case 'blu':
            case 'brn':
            case 'gry':
            case 'grn':
            case 'hzl':
            case 'oth':
                return true;
            default:
                return false;
        }
    }
}