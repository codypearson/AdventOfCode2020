<?php
require_once 'Command.php';
require_once 'CommandResult.php';

class Accumulate implements Command
{
    public function execute(int $param): CommandResult
    {
        $result = new CommandResult;
        $result->accumulate = $param;
        return $result;
    }
}