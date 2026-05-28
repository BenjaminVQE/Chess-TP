<?php

require_once __DIR__ . '/Contract/Renderable.php';
require_once __DIR__ . '/Position.php';
require_once __DIR__ . '/Piece/Piece.php';

class Board implements Renderable
{
    private array $pieces = [];

    public function placePiece(Piece $piece): void
    {
        $this->pieces[$piece->getPosition()->toKey()] = $piece;
    }

    public function getPieceAt(Position $position): ?Piece
    {
        return $this->pieces[$position->toKey()] ?? null;
    }

    public function hasPieceAt(Position $position): bool
    {
        return isset($this->pieces[$position->toKey()]);
    }

    public function removePieceAt(Position $position): void
    {
        unset($this->pieces[$position->toKey()]);
    }

    public function movePiece(Position $from, Position $to): void
    {
        if ($this->hasPieceAt($from)) {
            $piece = $this->pieces[$from->toKey()];
            $this->removePieceAt($from);
            $piece->setPosition($to);
            $this->placePiece($piece);
        }
    }

    public function isPathClear(Position $from, Position $to): bool
    {
        $rowDiff = $to->getRow() - $from->getRow();
        $colDiff = $to->getColumn() - $from->getColumn();

        $rowStep = $rowDiff === 0 ? 0 : $rowDiff / abs($rowDiff);
        $colStep = $colDiff === 0 ? 0 : $colDiff / abs($colDiff);

        $currentRow = $from->getRow() + $rowStep;
        $currentCol = $from->getColumn() + $colStep;

        while ($currentRow !== $to->getRow() || $currentCol !== $to->getColumn()) {
            $currentPos = new Position($currentRow, $currentCol);
            if ($this->hasPieceAt($currentPos)) {
                return false;
            }
            $currentRow += $rowStep;
            $currentCol += $colStep;
        }

        return true;
    }

    public function getPieces(): array
    {
        return array_values($this->pieces);
    }

    public function getKingPosition(PieceColor $color): ?Position
    {
        foreach ($this->pieces as $piece) {
            if ($piece->getType() === PieceType::KING && $piece->getColor() === $color) {
                return $piece->getPosition();
            }
        }
        return null;
    }

    public function render(): string
    {
        $output = "  a b c d e f g h\n";
        for ($row = 0; $row < 8; $row++) {
            $output .= (8 - $row) . " ";
            for ($col = 0; $col < 8; $col++) {
                $pos = new Position($row, $col);
                if ($this->hasPieceAt($pos)) {
                    $output .= $this->getPieceAt($pos)->render() . " ";
                } else {
                    $output .= ". ";
                }
            }
            $output .= (8 - $row) . "\n";
        }
        $output .= "  a b c d e f g h\n";
        return $output;
    }
}
