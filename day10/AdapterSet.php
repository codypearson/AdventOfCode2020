<?php
require_once 'Adapter.php';

class AdapterSet
{
    public $set = [];

    public static function buildFromStream($stream): static
    {
        $set = new static;
        while ($line = fgets($stream))
        {
            $set->addAdapter(new Adapter(trim($line)));
        }
        return $set;
    }

    public function addAdapter(Adapter $adapter)
    {
        $this->set[$adapter->outputJoltage] = $adapter;
    }

    public function getAdapterForInput(int $inputJoltage): ?Adapter
    {
        foreach (range(($inputJoltage + 1), ($inputJoltage + Adapter::INPUT_TOLERANCE)) as $desiredOutputJoltage)
        {
            if (isset($this->set[$desiredOutputJoltage]))
            {
                return $this->set[$desiredOutputJoltage];
            }
        }
        return null;
    }

    public function getMaxOutputJoltage(): int
    {
        return max(array_keys($this->set));
    }
}