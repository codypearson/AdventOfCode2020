<?php
class Adapter
{
    const INPUT_TOLERANCE = 3;
    public $outputJoltage;

    public function __construct(int $outputJoltage)
    {
        $this->outputJoltage = $outputJoltage;
    }
}