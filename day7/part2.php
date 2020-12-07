<?php
require_once 'RuleSet.php';

$ruleSet = RuleSet::buildFromStream(STDIN);
echo $ruleSet->getBagsContained('shiny gold');