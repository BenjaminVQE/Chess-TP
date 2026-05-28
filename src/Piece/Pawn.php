<?php

require_once __DIR__ . '/Piece.php';

class Pawn extends Piece
{
    public function __construct(PieceColor $color, Position $position)
    {
        parent::__construct($color, $position);
        $this->type = PieceType::PAWN;
    }

    protected function isValidMovementShape(Position $target): bool
    {
        $rowDiff = $target->getRow() - $this->position->getRow();
        $colDiff = abs($target->getColumn() - $this->position->getColumn());

        $direction = $this->color === PieceColor::WHITE ? -1 : 1;
        $startRow = $this->color === PieceColor::WHITE ? 6 : 1;

        if ($colDiff === 0 && $rowDiff === $direction) {
            return true;
        }

        if ($colDiff === 0 && $rowDiff === 2 * $direction && $this->position->getRow() === $startRow) {
            return true;
        }

        if ($colDiff === 1 && $rowDiff === $direction) {
            return true;
        }

        return false;
    }
}
