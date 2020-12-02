<?php

class PasswordRule
{
    public $character;
    public $firstPosition;
    public $secondPosition;

    public function __construct(string $character, int $firstPosition, int $secondPosition)
    {
        $this->character = $character;
        $this->firstPosition = $firstPosition - 1;
        $this->secondPosition = $secondPosition - 1;
    }

    public function test(string $subject)
    {
        return (substr($subject, $this->firstPosition, 1) == $this->character) xor (substr($subject, $this->secondPosition, 1) == $this->character);
    }
}

class Password
{
    public $password;
    public $passwordRules = [];

    public function __construct(string $password)
    {
        $this->password = $password;
    }

    public function addPasswordRule(PasswordRule $rule)
    {
        $this->passwordRules[] = $rule;
    }

    public function test()
    {
        foreach ($this->passwordRules as $rule)
        {
            if (!$rule->test($this->password))
            {
                return false;
            }
        }
        return true;
    }
}

$validCount = 0;
while ($line = fgets(STDIN))
{
    $matches = null;
    if (preg_match('/([0-9]+)-([0-9]+) ([a-z]): (.*)/', $line, $matches))
    {
        [,$firstPosition, $secondPosition, $character, $subject] = $matches;
        $password = new Password($subject);
        $password->addPasswordRule(new PasswordRule($character, $firstPosition, $secondPosition));
        if ($password->test())
        {
            $validCount++;
        }
    }
}
echo $validCount . "\n";