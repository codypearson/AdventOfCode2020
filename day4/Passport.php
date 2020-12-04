<?php
require_once 'Validator.php';

class Passport
{
    protected $dataFields = [];
    protected $requiredFields = [
        'byr',
        'iyr',
        'eyr',
        'hgt',
        'hcl',
        'ecl',
        'pid'
    ];
    protected $additionalValidators = [];

    public static function buildBatchFromStream($stream)
    {
        $batch = [];

        while ($line = fgets($stream))
        {
            if (isset($passport) && trim($line) == '')
            {
                $batch[] = $passport;
                unset($passport);
                continue;
            } elseif (!isset($passport))
            {
                $passport = new static;
            }
            preg_match_all('/([a-z]{3}):([^\s]+)/', $line, $matches);
            [,$keys,$values] = $matches;
            foreach ($keys as $index => $key)
            {
                $passport->setDataField($key, $values[$index]);
            }
        }
        if (isset($passport))
        {
            $batch[] = $passport;
        }

        return $batch;
    }

    public function setDataField(string $key, $value)
    {
        $this->dataFields[$key] = $value;
    }

    public function addValidator(string $field, Validator $validator)
    {
        $this->additionalValidators[] = [$field, $validator];
    }

    protected function validateRequiredFields()
    {
        foreach ($this->requiredFields as $fieldKey)
        {
            if (!isset($this->dataFields[$fieldKey]))
            {
                return false;
            }
        }
        return true;
    }

    public function validate()
    {
        if ($this->validateRequiredFields())
        {
            foreach ($this->additionalValidators as $validatorDefinition)
            {
                [$fieldKey, $validator] = $validatorDefinition;
                if (!$validator->validate($this->dataFields[$fieldKey]))
                {
                    return false;
                }
            }
            return true;
        } else
        {
            return false;
        }
    }
}