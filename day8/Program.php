<?php
require_once 'CommandFactory.php';
require_once 'HaltException.php';

class Program
{
    public $accumulator = 0;

    protected $lines = [];
    protected $executionCounter = [];

    public function __construct($input)
    {
        if (is_resource($input))
        {
            $this->loadFromStream($input);
        }
    }

    public function loadFromStream($stream)
    {
        $this->lines = [];
        while ($line = fgets($stream))
        {
            $this->lines[] = $line;
        }
        $this->executionCounter = array_fill(0, count($this->lines), 0);
    }

    public function executeLine(int $lineNumber): int
    {
        if ($this->executionCounter[$lineNumber] > 0)
        {
            throw new HaltException;
        }
        $line = $this->lines[$lineNumber];
        if (preg_match('/([a-z]{3}) ([+-][0-9]+)/', $line, $matches))
        {
            [,$command, $param] = $matches;
            $commandObject = CommandFactory::create($command);
            $commandResult = $commandObject->execute($param);
            $this->accumulator += $commandResult->accumulate;
            $this->executionCounter[$lineNumber]++;
            return ($lineNumber + $commandResult->step);
        }
        return ($lineNumber + 1);
    }

    public function run(): int
    {
        $lineNumber = 0;
        $lineCount = count($this->lines);
        while ($lineNumber < $lineCount)
        {
            try
            {
                $lineNumber = $this->executeLine($lineNumber);
            } catch (HaltException $e)
            {
                break;
            }
        }
        return $this->accumulator;
    }
}