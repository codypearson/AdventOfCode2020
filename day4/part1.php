<?php
require_once 'Passport.php';
$batch = Passport::buildBatchFromStream(STDIN);
$validCount = 0;
foreach ($batch as $passport)
{
    if ($passport->validate())
    {
        $validCount++;
    }
}
echo $validCount;