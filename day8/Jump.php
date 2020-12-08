<?php
require_once 'Command.php';
require_once 'CommandResult.php';

class Jump implements Command
{
    public function execute(int $param): CommandResult
    {
        $result = new CommandResult;
        $result->step = $param;
        return $result;
    }
}