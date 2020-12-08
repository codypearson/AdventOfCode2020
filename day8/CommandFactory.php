<?php
require_once 'Accumulate.php';
require_once 'Command.php';
require_once 'Jump.php';
require_once 'NoOp.php';

class CommandFactory
{
    protected static $classes = [
        'acc' => Accumulate::class,
        'jmp' => Jump::class,
        'nop' => NoOp::class
    ];
    public static function create(string $key): Command
    {
        if (!isset(static::$classes[$key]))
        {
            throw new \Exception('Invalid command: ' . $key);
        }
        $class = static::$classes[$key];
        return new $class;
    }
}