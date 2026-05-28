<?php

require_once __DIR__ . '/src/Game.php';

echo "=== JEU D'ÉCHECS INTERACTIF ===\n\n";
echo "Format des commandes : case_départ case_arrivée (ex: e2 e4, e2e4 ou e2-e4)\n";
echo "Pour quitter, tapez 'quit' ou 'exit'.\n\n";

$game = new Game();
$game->start();

while (true) {
    echo "----------------------------------------\n";
    echo $game->getBoard()->render() . "\n";
    
    $color = $game->getCurrentPlayer() === PieceColor::WHITE ? 'Blancs' : 'Noirs';
    
    if ($game->isCheck($game->getCurrentPlayer())) {
        echo "ATTENTION: Les $color sont en ÉCHEC !\n";
    }

    $input = readline("Au tour des $color. Entrez votre coup (ex: e2 e4) : ");
    
    if ($input === false) {
        break;
    }

    $input = trim($input);

    if ($input === 'quit' || $input === 'exit') {
        echo "Partie terminée. À bientôt !\n";
        break;
    }

    try {
        $positions = Position::parseMoveInput($input);
        $move = new Move($positions[0], $positions[1]);
        
        $game->play($move);
        echo "\nCoup joué avec succès !\n\n";
    } catch (InvalidArgumentException $e) {
        echo "Erreur de position : " . $e->getMessage() . "\n\n";
    } catch (ChessException $e) {
        echo "Coup interdit : " . $e->getMessage() . "\n\n";
    } catch (Exception $e) {
         echo "Erreur : " . $e->getMessage() . "\n\n";
    }
}
