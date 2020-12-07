<?php
require_once 'RuleSet.php';

$ruleSet = RuleSet::buildFromStream(STDIN);
$colorsCanContain = $ruleSet->canContain('shiny gold', 1);
echo count($colorsCanContain);