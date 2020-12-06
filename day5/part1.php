<?php
require_once 'Position.php';

$maxSeatId = 0;
while ($line = fgets(STDIN))
{
    $position = new Position;
    $position->setRowAndColumnFromPartition($line);
    $seatId = $position->getSeatId();
    if ($seatId > $maxSeatId)
    {
        $maxSeatId = $seatId;
    }
}
echo $maxSeatId;