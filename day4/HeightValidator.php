<?php
require_once 'Validator.php';

class HeightValidator implements Validator
{
    public function validate($value): bool
    {
        if (preg_match('/^([0-9]+)(cm|in)$/', $value, $matches))
        {
            [,$number,$unit] = $matches;
            switch ($unit)
            {
                case 'cm':
                    return ($number >= 150 && $number <= 193);
                case 'in':
                    return ($number >= 59 && $number <= 76);
            }
        } else
        {
            return false;
        }
    }
}