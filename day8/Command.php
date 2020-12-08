<?php
require_once 'CommandResult.php';

interface Command
{
    public function execute(int $param): CommandResult;
}