<?php
require_once 'AdapterChain.php';
require_once 'AdapterSet.php';

$set = AdapterSet::buildFromStream(STDIN);
$chain = new AdapterChain;
$chain->buildFromSet($set, 0);
echo ($chain->gapIndex[1] * ($chain->gapIndex[3] + 1));