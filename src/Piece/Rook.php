<?php

require_once __DIR__ . '/Piece.php';

class Rook extends Piece
{
    public function __construct(PieceColor $color, Position $position)
    {
        parent::__construct($color, $position);
        $this->type = PieceType::ROOK;
    }

    protected function isValidMovementShape(Position $target): bool
    {
        $rowDiff = abs($this->position->getRow() - $target->getRow());
        $colDiff = abs($this->position->getColumn() - $target->getColumn());

        return $rowDiff === 0 || $colDiff === 0;
    }
}
