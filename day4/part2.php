<?php
require_once 'Passport.php';
require_once 'BirthYearValidator.php';
require_once 'ExpirationYearValidator.php';
require_once 'EyeColorValidator.php';
require_once 'HairColorValidator.php';
require_once 'HeightValidator.php';
require_once 'IssueYearValidator.php';
require_once 'PassportIdValidator.php';

$batch = Passport::buildBatchFromStream(STDIN);
$validCount = 0;

$validators = [
    'byr' => new BirthYearValidator,
    'iyr' => new IssueYearValidator,
    'eyr' => new ExpirationYearValidator,
    'hgt' => new HeightValidator,
    'hcl' => new HairColorValidator,
    'ecl' => new EyeColorValidator,
    'pid' => new PassportIdValidator
];

foreach ($batch as $passport)
{
    foreach ($validators as $field => $validator)
    {
        $passport->addValidator($field, $validator);
    }
    if ($passport->validate())
    {
        $validCount++;
    }
}
echo $validCount;