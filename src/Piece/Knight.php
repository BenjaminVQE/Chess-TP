<?php

require_once __DIR__ . '/Piece.php';

class Knight extends Piece
{
    public function __construct(PieceColor $color, Position $position)
    {
        parent::__construct($color, $position);
        $this->type = PieceType::KNIGHT;
    }

    protected function isValidMovementShape(Position $target): bool
    {
        $rowDiff = abs($this->position->getRow() - $target->getRow());
        $colDiff = abs($this->position->getColumn() - $target->getColumn());

        return ($rowDiff === 2 && $colDiff === 1) || ($rowDiff === 1 && $colDiff === 2);
    }
}
