<?php
require_once 'Program.php';

$program = new Program(STDIN);
echo $program->run();