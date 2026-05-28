<?php

require_once __DIR__ . '/../Contract/Renderable.php';
require_once __DIR__ . '/../Enum/PieceColor.php';
require_once __DIR__ . '/../Enum/PieceType.php';
require_once __DIR__ . '/../Position.php';

abstract class Piece implements Renderable
{
    protected PieceColor $color;
    protected Position $position;
    protected PieceType $type;

    public function __construct(PieceColor $color, Position $position)
    {
        $this->color = $color;
        $this->position = $position;
    }

    public function getColor(): PieceColor
    {
        return $this->color;
    }

    public function getPosition(): Position
    {
        return $this->position;
    }

    public function setPosition(Position $position): void
    {
        $this->position = $position;
    }

    public function getType(): PieceType
    {
        return $this->type;
    }

    public function render(): string
    {
        $map = [
            PieceType::KING->name => ['WHITE' => 'K', 'BLACK' => 'k'],
            PieceType::QUEEN->name => ['WHITE' => 'Q', 'BLACK' => 'q'],
            PieceType::ROOK->name => ['WHITE' => 'R', 'BLACK' => 'r'],
            PieceType::BISHOP->name => ['WHITE' => 'B', 'BLACK' => 'b'],
            PieceType::KNIGHT->name => ['WHITE' => 'N', 'BLACK' => 'n'],
            PieceType::PAWN->name => ['WHITE' => 'P', 'BLACK' => 'p'],
        ];

        return $map[$this->type->name][$this->color->name];
    }

    public function canMove(Board $board, Position $target): bool
    {
        if ($this->position->equals($target)) {
            return false;
        }

        if (!$this->isValidMovementShape($target)) {
            return false;
        }

        if ($board->hasPieceAt($target)) {
            $pieceAtTarget = $board->getPieceAt($target);
            if ($pieceAtTarget->getColor() === $this->color) {
                return false;
            }
            
            if ($this->type === PieceType::PAWN && $this->position->getColumn() === $target->getColumn()) {
                return false;
            }
        } else {
             if ($this->type === PieceType::PAWN && $this->position->getColumn() !== $target->getColumn()) {
                 return false;
             }
        }

        if ($this->type !== PieceType::KNIGHT) {
            if (!$board->isPathClear($this->position, $target)) {
                return false;
            }
        }

        return true;
    }

    abstract protected function isValidMovementShape(Position $target): bool;

    protected function canCapture(Board $board, Position $target): bool
    {
        if ($board->hasPieceAt($target)) {
            $targetPiece = $board->getPieceAt($target);
            return $targetPiece->getColor() !== $this->getColor();
        }
        return false;
    }
}
