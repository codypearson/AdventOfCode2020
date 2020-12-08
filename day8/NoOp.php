<?php
require_once 'Command.php';
require_once 'CommandResult.php';

class NoOp implements Command
{
    public function execute(int $param): CommandResult
    {
        return new CommandResult;
    }
}