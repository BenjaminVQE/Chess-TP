<?php

require_once __DIR__ . '/Board.php';
require_once __DIR__ . '/Enum/PieceColor.php';
require_once __DIR__ . '/Factory/PieceFactory.php';
require_once __DIR__ . '/Move.php';
require_once __DIR__ . '/Exception/NoPieceException.php';
require_once __DIR__ . '/Exception/WrongTurnException.php';
require_once __DIR__ . '/Exception/InvalidMoveException.php';
require_once __DIR__ . '/Exception/OccupiedByAllyException.php';

class Game
{
    private Board $board;
    private PieceColor $currentPlayer;
    private PieceFactory $pieceFactory;

    public function __construct()
    {
        $this->board = new Board();
        $this->currentPlayer = PieceColor::WHITE;
        $this->pieceFactory = new PieceFactory();
    }

    public function start(): void
    {
        $this->setupPieces();
    }

    public function getBoard(): Board
    {
        return $this->board;
    }

    public function getCurrentPlayer(): PieceColor
    {
        return $this->currentPlayer;
    }

    public function play(Move $move): void
    {
        $from = $move->getFrom();
        $to = $move->getTo();

        $piece = $this->board->getPieceAt($from);

        if ($piece === null) {
            throw new NoPieceException("Aucune pièce à la position source.");
        }

        if ($piece->getColor() !== $this->currentPlayer) {
            throw new WrongTurnException("Ce n'est pas votre tour.");
        }
        $canMove = $piece->canMove($this->board, $to);

        if (!$canMove) {
            if ($this->board->hasPieceAt($to) && $this->board->getPieceAt($to)->getColor() === $this->currentPlayer) {
                throw new OccupiedByAllyException("La case cible est occupée par une pièce alliée.");
            }
            
            throw new InvalidMoveException("Le mouvement est invalide.");
        }

        $this->board->movePiece($from, $to);

        $this->switchPlayer();
    }

    public function isCheck(PieceColor $color): bool
    {
        $kingPos = $this->board->getKingPosition($color);
        if ($kingPos === null) {
            return false;
        }

        $enemyColor = $color->opposite();
        $pieces = $this->board->getPieces();

        foreach ($pieces as $piece) {
            if ($piece->getColor() === $enemyColor) {
                if ($piece->canMove($this->board, $kingPos)) {
                    return true;
                }
            }
        }

        return false;
    }

    private function setupPieces(): void
    {
        $this->board->placePiece($this->pieceFactory->create(PieceType::ROOK, PieceColor::BLACK, new Position(0, 0)));
        $this->board->placePiece($this->pieceFactory->create(PieceType::KNIGHT, PieceColor::BLACK, new Position(0, 1)));
        $this->board->placePiece($this->pieceFactory->create(PieceType::BISHOP, PieceColor::BLACK, new Position(0, 2)));
        $this->board->placePiece($this->pieceFactory->create(PieceType::QUEEN, PieceColor::BLACK, new Position(0, 3)));
        $this->board->placePiece($this->pieceFactory->create(PieceType::KING, PieceColor::BLACK, new Position(0, 4)));
        $this->board->placePiece($this->pieceFactory->create(PieceType::BISHOP, PieceColor::BLACK, new Position(0, 5)));
        $this->board->placePiece($this->pieceFactory->create(PieceType::KNIGHT, PieceColor::BLACK, new Position(0, 6)));
        $this->board->placePiece($this->pieceFactory->create(PieceType::ROOK, PieceColor::BLACK, new Position(0, 7)));

        for ($i = 0; $i < 8; $i++) {
            $this->board->placePiece($this->pieceFactory->create(PieceType::PAWN, PieceColor::BLACK, new Position(1, $i)));
        }

        for ($i = 0; $i < 8; $i++) {
            $this->board->placePiece($this->pieceFactory->create(PieceType::PAWN, PieceColor::WHITE, new Position(6, $i)));
        }

        $this->board->placePiece($this->pieceFactory->create(PieceType::ROOK, PieceColor::WHITE, new Position(7, 0)));
        $this->board->placePiece($this->pieceFactory->create(PieceType::KNIGHT, PieceColor::WHITE, new Position(7, 1)));
        $this->board->placePiece($this->pieceFactory->create(PieceType::BISHOP, PieceColor::WHITE, new Position(7, 2)));
        $this->board->placePiece($this->pieceFactory->create(PieceType::QUEEN, PieceColor::WHITE, new Position(7, 3)));
        $this->board->placePiece($this->pieceFactory->create(PieceType::KING, PieceColor::WHITE, new Position(7, 4)));
        $this->board->placePiece($this->pieceFactory->create(PieceType::BISHOP, PieceColor::WHITE, new Position(7, 5)));
        $this->board->placePiece($this->pieceFactory->create(PieceType::KNIGHT, PieceColor::WHITE, new Position(7, 6)));
        $this->board->placePiece($this->pieceFactory->create(PieceType::ROOK, PieceColor::WHITE, new Position(7, 7)));
    }

    private function switchPlayer(): void
    {
        $this->currentPlayer = $this->currentPlayer->opposite();
    }
}
