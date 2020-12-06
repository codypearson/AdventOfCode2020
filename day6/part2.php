<?php

require_once 'Group.php';

$batch = Group::batchFromStream(STDIN);
$uniqueSum = 0;

foreach ($batch as $group)
{
    $uniqueQuestions = $group->getQuestionsAnsweredByAll();
    $uniqueSum += count($uniqueQuestions);
}
echo $uniqueSum;