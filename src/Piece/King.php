<?php

require_once __DIR__ . '/Piece.php';

class King extends Piece
{
    public function __construct(PieceColor $color, Position $position)
    {
        parent::__construct($color, $position);
        $this->type = PieceType::KING;
    }

    protected function isValidMovementShape(Position $target): bool
    {
        $rowDiff = abs($this->position->getRow() - $target->getRow());
        $colDiff = abs($this->position->getColumn() - $target->getColumn());

        if ($rowDiff <= 1 && $colDiff <= 1) {
            return true;
        }

        if ($rowDiff === 0 && $colDiff === 2) {
            return true;
        }

        return false;
    }

    public function canMove(Board $board, Position $target): bool
    {
        $rowDiff = abs($this->position->getRow() - $target->getRow());
        $colDiff = abs($this->position->getColumn() - $target->getColumn());

        if ($rowDiff === 0 && $colDiff === 2) {
            if ($this->hasMoved) {
                return false;
            }

            $rookCol = $target->getColumn() > $this->position->getColumn() ? 7 : 0;
            $rookPos = new Position($this->position->getRow(), $rookCol);
            
            $rook = $board->getPieceAt($rookPos);
            if ($rook === null || $rook->getType() !== PieceType::ROOK || $rook->getColor() !== $this->color || $rook->hasMoved()) {
                return false;
            }

            if (!$board->isPathClear($this->position, $rookPos)) {
                return false;
            }

            return true;
        }

        return parent::canMove($board, $target);
    }
}
