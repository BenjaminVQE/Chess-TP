<?php

class Position
{
    private int $row;
    private int $column;

    public function __construct(int $row, int $column)
    {
        if ($row < 0 || $row > 7) {
            throw new InvalidArgumentException("La ligne doit être entre 0 et 7");
        }

        if ($column < 0 || $column > 7) {
            throw new InvalidArgumentException("La colonne doit être entre 0 et 7");
        }

        $this->row = $row;
        $this->column = $column;
    }

    public function getRow(): int
    {
        return $this->row;
    }

    public function getColumn(): int
    {
        return $this->column;
    }

    public function equals(Position $other): bool
    {
        return $this->row === $other->getRow() && $this->column === $other->getColumn();
    }

    public function toKey(): string
    {
        return "{$this->row}:{$this->column}";
    }

    public static function fromKey(string $key): Position
    {
        $parts = explode(':', $key);
        if (count($parts) !== 2) {
            throw new InvalidArgumentException("Clé de position invalide");
        }
        return new Position((int)$parts[0], (int)$parts[1]);
    }

    public function toAlgebraic(): string
    {
        $file = chr(ord('a') + $this->column);
        $rank = 8 - $this->row;
        return $file . $rank;
    }

    public static function fromAlgebraic(string $str): Position
    {
        $str = strtolower(trim($str));
        if (strlen($str) !== 2) {
            throw new InvalidArgumentException("Format de coordonnées invalide (ex: e2)");
        }
        $file = $str[0];
        $rank = $str[1];
        if ($file < 'a' || $file > 'h') {
            throw new InvalidArgumentException("La colonne doit être entre a et h");
        }
        if ($rank < '1' || $rank > '8') {
            throw new InvalidArgumentException("La ligne doit être entre 1 et 8");
        }
        $column = ord($file) - ord('a');
        $row = 8 - (int)$rank;
        return new Position($row, $column);
    }

    public static function parseMoveInput(string $input): array
    {
        $input = strtolower(trim($input));

        if (preg_match('/^[a-h][1-8][a-h][1-8]$/', $input)) {
            $fromStr = substr($input, 0, 2);
            $toStr = substr($input, 2, 2);
            return [self::fromAlgebraic($fromStr), self::fromAlgebraic($toStr)];
        }

        if (preg_match('/^[a-h][1-8][\s\-][a-h][1-8]$/', $input)) {
            $fromStr = substr($input, 0, 2);
            $toStr = substr($input, 3, 2);
            return [self::fromAlgebraic($fromStr), self::fromAlgebraic($toStr)];
        }

        if (preg_match('/^\d:\d\s\d:\d$/', $input)) {
            $parts = explode(' ', $input);
            return [self::fromKey($parts[0]), self::fromKey($parts[1])];
        }

        throw new InvalidArgumentException("Format invalide. Utilisez le format 'e2 e4' ou 'e2e4'.");
    }
}
