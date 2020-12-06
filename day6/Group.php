<?php
require_once 'Person.php';

class Group
{
    protected $people = [];

    public static function batchFromStream($stream): array
    {
        $batch = [];
        $group = null;

        while ($line = fgets($stream))
        {
            $line = trim($line);
            if ($line == '')
            {
                // Blank line; finish the current group
                $group = null;
            } else
            {
                if (is_null($group))
                {
                    $group = new static;
                    $batch[] = $group;
                }
                $person = new Person;
                $person->setQuestionsAnsweredFromString($line);
                $group->addPerson($person);
            }
        }

        return $batch;
    }

    public function addPerson(Person $person)
    {
        $this->people[] = $person;
    }

    public function getUniqueQuestions(): array
    {
        $uniqueQuestions = [];

        foreach ($this->people as $person)
        {
            foreach ($person->questionsAnsweredYes as $question)
            {
                if (!in_array($question, $uniqueQuestions))
                {
                    $uniqueQuestions[] = $question;
                }
            }
        }

        return $uniqueQuestions;
    }
}