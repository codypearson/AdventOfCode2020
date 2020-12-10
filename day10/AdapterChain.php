<?php
require_once 'Adapter.php';
require_once 'AdapterSet.php';

class AdapterChain extends AdapterSet
{
    public $gapIndex = [];
    public $startingInputJoltage = 0;

    public function buildFromSet(AdapterSet $set, int $startingInputJoltage)
    {
        $inputJoltage = $startingInputJoltage;
        $maxOutputJoltage = $set->getMaxOutputJoltage();
        $this->startingInputJoltage = $startingInputJoltage;
        while ($inputJoltage < $maxOutputJoltage)
        {
            $adapter = $set->getAdapterForInput($inputJoltage);
            $this->addAdapter($adapter);
            $this->addGap($adapter->outputJoltage - $inputJoltage);
            $inputJoltage = $adapter->outputJoltage;
        }
    }

    protected function addGap(int $gapSize)
    {
        if (isset($this->gapIndex[$gapSize]))
        {
            $this->gapIndex[$gapSize]++;
        } else
        {
            $this->gapIndex[$gapSize] = 1;
        }
    }
}