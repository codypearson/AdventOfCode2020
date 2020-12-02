<?php

class PasswordRule
{
    public $character;
    public $minCount;
    public $maxCount;

    public function __construct(string $character, int $minCount, int $maxCount)
    {
        $this->character = $character;
        $this->minCount = $minCount;
        $this->maxCount = $maxCount;
    }

    public function test(string $subject)
    {
        $charCount = substr_count($subject, $this->character);
        return $charCount >= $this->minCount && $charCount <= $this->maxCount;
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
        [,$minCount, $maxCount, $character, $subject] = $matches;
        $password = new Password($subject);
        $password->addPasswordRule(new PasswordRule($character, $minCount, $maxCount));
        if ($password->test())
        {
            $validCount++;
        }
    }
}
echo $validCount . "\n";