<?php

class Cell
{
    public $hasTree = false;

    public function setHasTreeFromString(string $input)
    {
        $this->hasTree = ($input == '#');
    }
}

class Cursor {
    public $row = 0;
    public $column = 0;

    protected $grid;

    public function __construct(Grid $grid)
    {
        $this->grid = $grid;
    }

    public function left()
    {
        if ($this->column == 0)
        {
            $this->column = ($this->grid->columnCount - 1);
        } else {
            $this->column--;
        }
        return true;
    }

    public function right()
    {
        $maxColumnIndex = $this->grid->columnCount - 1;
        if ($this->column == $maxColumnIndex)
        {
            $this->column = 0;
        } else
        {
            $this->column++;
        }
        return true;
    }

    public function up()
    {
        $newRow = $this->row - 1;
        if ($newRow < 0) {
            return false;
        } else {
            $this->row = $newRow;
            return true;
        }
    }

    public function down()
    {
        $newRow = $this->row + 1;
        if ($newRow > $this->grid->getMaxRowIndex())
        {
            return false;
        } else {
            $this->row = $newRow;
            return true;
        }
    }
}

class Grid
{
    public $columnCount = 0;
    protected $gridContents = [];
    protected $cursor;

    public static function buildFromStream($stream)
    {
        $grid = new static;
        $rowIndex = 0;
        while ($line = fgets($stream))
        {
            foreach (str_split(trim($line)) as $columnIndex => $character)
            {
                $grid->getCellAtPosition($rowIndex, $columnIndex)->setHasTreeFromString($character);
            }
            $rowIndex++;
        }

        return $grid;
    }

    public function __construct()
    {
        $this->cursor = new Cursor($this);
    }

    public function newRow()
    {
        $newRow = [];
        for ($i = 0; $i < $this->columnCount; $i++)
        {
            $newRow[] = new Cell;
        }
        $this->gridContents[] = $newRow;
    }

    public function newColumn()
    {
        $this->columnCount++;
        foreach ($this->gridContents as &$row)
        {
            $row[] = new Cell;
        }
    }

    public function getMaxRowIndex()
    {
        return count($this->gridContents) - 1;
    }

    public function getCellAtPosition(int $rowIndex, int $columnIndex)
    {
        $maxRowIndex = $this->getMaxRowIndex();
        if ($rowIndex > $maxRowIndex)
        {
            $rowsToCreate = $rowIndex - $maxRowIndex;
            for ($i = 0; $i < $rowsToCreate; $i++)
            {
                $this->newRow();
            }
        }

        $maxColumnIndex = $this->columnCount - 1;
        if ($columnIndex > $maxColumnIndex)
        {
            $columnsToCreate = $columnIndex - $maxColumnIndex;
            for ($i = 0; $i < $columnsToCreate; $i++)
            {
                $this->newColumn();
            }
        }

        return $this->gridContents[$rowIndex][$columnIndex];
    }

    public function getCurrentCell()
    {
        return $this->gridContents[$this->cursor->row][$this->cursor->column];
    }

    public function traverse(array $sequence)
    {
        $treeCount = 0;
        $this->cursor = new Cursor($this);

        while (true)
        {
            foreach ($sequence as $sequenceStep)
            {
                [$cursorMethod, $stepCount] = $sequenceStep;
                for ($i = 0; $i < $stepCount; $i++)
                {
                    if (!$this->cursor->$cursorMethod())
                    {
                        break 3;
                    }
                }
            }
            if ($this->getCurrentCell()->hasTree)
            {
                $treeCount++;
            }
        }

        return $treeCount;
    }
}

$grid = Grid::buildFromStream(STDIN);
echo
    $grid->traverse([
        ['right', 1],
        ['down', 1]
    ]) *
    $grid->traverse([
        ['right', 3],
        ['down', 1]
    ]) *
    $grid->traverse([
        ['right', 5],
        ['down', 1]
    ]) *
    $grid->traverse([
        ['right', 7],
        ['down', 1]
    ]) *
    $grid->traverse([
        ['right', 1],
        ['down', 2]
    ]);