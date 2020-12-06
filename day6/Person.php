<?php

class Person
{
    public $questionsAnsweredYes = [];

    public function setQuestionsAnsweredFromString(string $questionsAnswered)
    {
        $this->questionsAnsweredYes = str_split($questionsAnswered);
    }
}