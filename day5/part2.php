<?php
require_once 'Position.php';
require_once 'Gap.php';

$positions = [];
while ($line = fgets(STDIN))
{
    $position = new Position;
    $position->setRowAndColumnFromPartition($line);
    $seatId = $position->getSeatId();
    $positions[] = $seatId;
}

$gaps = Gap::findGapsInArrayOfNumbers($positions, 1);
$gap = array_shift($gaps);
echo $gap->gapStart;