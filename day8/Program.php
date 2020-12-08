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
        } elseif (is_array($input))
        {
            $this->lines = $input;
        }
        $this->executionCounter = array_fill(0, count($this->lines), 0);
    }

    protected function loadFromStream($stream)
    {
        $this->lines = [];
        while ($line = fgets($stream))
        {
            $this->lines[] = $line;
        }
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

    public function run(bool $catchException = true): int
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
                if ($catchException)
                {
                    break;
                } else
                {
                    throw $e;
                }
            }
        }
        return $this->accumulator;
    }

    public function debug(): int
    {
        $possibleChanges = [
            'nop' => 'jmp',
            'jmp' => 'nop'
        ];

        foreach ($this->lines as $lineNumber => $line)
        {
            $newLine = null;
            foreach ($possibleChanges as $from => $to)
            {
                $position = strpos($line, $from);
                if ($position !== false)
                {
                    $newLine = substr_replace($line, $to, $position, strlen($from));
                    break;
                }
            }
            if (!is_null($newLine))
            {
                $newCode = $this->lines;
                $newCode[$lineNumber] = $newLine;
                $newProgram = new static($newCode);
                try {
                    return $newProgram->run(false);
                } catch (HaltException) {
                    continue;
                }
            }
        }
    }
}