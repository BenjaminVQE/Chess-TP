# TP Guidé - POO avancée en PHP avec les échecs

## Principe du TP
Dans ce TP, tout le monde doit produire la même architecture de base.

Le but n'est pas de "faire à sa manière", mais de :
- respecter une structure de projet imposée ;
- utiliser les mêmes noms de classes ;
- utiliser les mêmes noms de méthodes ;
- appliquer les mêmes relations d'héritage ;
- mettre en place plusieurs design patterns de manière contrôlée ;
- avancer étape par étape sans tout coder dès le début.

Le sujet est donc volontairement directif.

---

# État d'avancement du projet

Voici le récapitulatif des tâches effectuées (✓) et restantes (✗) pour ce TP :

| Catégorie / Composant | Élément (Méthode / Propriété) | Statut |
|---|---|:---:|
| **Classes principales** | | |
| `Position` | (Classe) | ✓ |
| | `__construct()` | ✓ |
| | `getRow()` | ✓ |
| | `getColumn()` | ✓ |
| | `equals()` | ✓ |
| | `toKey()` | ✓ |
| | `fromKey()` | ✓ |
| `Move` | (Classe) | ✓ |
| | `__construct()` | ✓ |
| | `getFrom()` | ✓ |
| | `getTo()` | ✓ |
| `Board` | (Classe) | ✓ |
| | `placePiece()` | ✓ |
| | `getPieceAt()` | ✓ |
| | `hasPieceAt()` | ✓ |
| | `removePieceAt()` | ✓ |
| | `movePiece()` | ✓ |
| | `isPathClear()` | ✓ |
| | `getPieces()` | ✓ |
| | `getKingPosition()` | ✓ |
| | `render()` | ✓ |
| `Game` | (Classe) | ✓ |
| | `__construct()` | ✓ |
| | `start()` | ✓ |
| | `getBoard()` | ✓ |
| | `getCurrentPlayer()` | ✓ |
| | `play()` | ✓ |
| | `isCheck()` | ✓ |
| | `setupPieces()` | ✓ |
| | `switchPlayer()` | ✓ |
| **Pièces** | | |
| `Piece` | (Classe abstraite) | ✓ |
| | `__construct()` | ✓ |
| | `getColor()` | ✓ |
| | `getPosition()` | ✓ |
| | `setPosition()` | ✓ |
| | `getType()` | ✓ |
| | `render()` | ✓ |
| | `canMove()` | ✓ |
| | `isValidMovementShape()` | ✓ |
| | `canCapture()` | ✓ |
| `King` | (Classe) | ✓ |
| | `isValidMovementShape()` | ✓ |
| `Queen` | (Classe) | ✓ |
| | `isValidMovementShape()` | ✓ |
| `Rook` | (Classe) | ✓ |
| | `isValidMovementShape()` | ✓ |
| `Bishop` | (Classe) | ✓ |
| | `isValidMovementShape()` | ✓ |
| `Knight` | (Classe) | ✓ |
| | `isValidMovementShape()` | ✓ |
| `Pawn` | (Classe) | ✓ |
| | `isValidMovementShape()` | ✓ |
| **Factory** | | |
| `PieceFactory` | (Classe) | ✓ |
| | `create()` | ✓ |
| **Interface / Enums** | | |
| `Renderable` | (Interface) | ✓ |
| | `render()` | ✓ |
| `PieceColor` | (Enum) | ✓ |
| | `WHITE` | ✓ |
| | `BLACK` | ✓ |
| | `opposite()` | ✓ |
| `PieceType` | (Enum) | ✓ |
| | `KING` | ✓ |
| | `QUEEN` | ✓ |
| | `ROOK` | ✓ |
| | `BISHOP` | ✓ |
| | `KNIGHT` | ✓ |
| | `PAWN` | ✓ |
| **Exceptions** | | |
| `ChessException` | (Exception) | ✓ |
| `InvalidMoveException` | (Exception) | ✓ |
| `NoPieceException` | (Exception) | ✓ |
| `WrongTurnException` | (Exception) | ✓ |
| `OccupiedByAllyException`| (Exception) | ✓ |
| **Bonus** | | |
| Roque | | ✗ |
| Promotion du pion | | ✗ |
| Prise en passant | | ✗ |
| Interdiction de mettre son propre roi en échec | | ✗ |
| Échec et mat | | ✗ |
| Pat | | ✗ |
| Historique complet des coups | | ✗ |
| Tests automatisés | | ✗ |
| Autre bonus : `à préciser` | | ✗ |

---

## Objectif pédagogique
Vous devez construire un mini moteur métier d'échecs en PHP pour travailler :
- l'encapsulation ;
- l'héritage ;
- les classes abstraites ;
- les interfaces ;
- le polymorphisme ;
- la composition ;
- les exceptions métier ;
- plusieurs design patterns simples et utiles.

Ce TP ne demande pas :
- d'interface graphique ;
- d'intelligence artificielle ;
- de multijoueur réseau.

## Règle importante
Vous ne devez pas improviser l'architecture.

Vous devez respecter exactement :
- les dossiers ;
- les fichiers ;
- les classes ;
- les signatures de méthodes ;
- les relations entre classes.

Si une méthode est demandée, elle doit exister avec le nom indiqué.
Si une classe est demandée, elle doit être créée dans le fichier indiqué.

## Arborescence imposée
Votre projet doit respecter exactement cette structure à la fin :

```text
chess/
├── readme.md
├── index.php
└── src/
    ├── Board.php
    ├── Game.php
    ├── Position.php
    ├── Move.php
    ├── Factory/
    │   └── PieceFactory.php
    ├── Contract/
    │   └── Renderable.php
    ├── Enum/
    │   ├── PieceColor.php
    │   └── PieceType.php
    ├── Exception/
    │   ├── ChessException.php
    │   ├── InvalidMoveException.php
    │   ├── NoPieceException.php
    │   ├── WrongTurnException.php
    │   └── OccupiedByAllyException.php
    └── Piece/
        ├── Piece.php
        ├── King.php
        ├── Queen.php
        ├── Rook.php
        ├── Bishop.php
        ├── Knight.php
        └── Pawn.php
```

## Classes imposées
Vous devez créer exactement les classes suivantes :
- Board
- Game
- Position
- Move
- PieceFactory
- Piece
- King
- Queen
- Rook
- Bishop
- Knight
- Pawn
- ChessException
- InvalidMoveException
- NoPieceException
- WrongTurnException
- OccupiedByAllyException

Vous devez également créer :
- l'interface Renderable
- l'enum PieceColor
- l'enum PieceType

## Relations d'héritage imposées
Vous devez respecter exactement ce schéma :

### Héritage métier
- Piece est une classe abstraite
- King hérite de Piece
- Queen hérite de Piece
- Rook hérite de Piece
- Bishop hérite de Piece
- Knight hérite de Piece
- Pawn hérite de Piece

### Héritage des exceptions
- ChessException hérite de Exception
- InvalidMoveException hérite de ChessException
- NoPieceException hérite de ChessException
- WrongTurnException hérite de ChessException
- OccupiedByAllyException hérite de ChessException

### Contrat commun
- Piece implémente Renderable
- Board implémente Renderable

## Design patterns imposés
Vous devez mettre en place les patterns suivants.

### 1. Factory
Classe concernée : `PieceFactory`
Rôle : centraliser la création des pièces ; éviter d'instancier les pièces directement dans Game.

### 2. Strategy via polymorphisme
Classes concernées : `Piece` et toutes les classes filles de `Piece`
Rôle : chaque pièce possède sa propre stratégie de déplacement ; on évite un gros bloc de if/else dans Game.

### 3. Template Method
Classe concernée : `Piece`
Rôle : la classe abstraite porte la structure commune de validation ; les sous-classes ne redéfinissent que la logique spécifique de déplacement.

### 4. Value Object
Classe concernée : `Position`
Rôle : représenter une case valide ; éviter de manipuler des coordonnées brutes partout.

## Ordre de travail obligatoire
Vous devez avancer dans cet ordre :
1. Position
2. PieceColor et PieceType
3. Renderable
4. Piece
5. King, Queen, Rook, Bishop, Knight, Pawn
6. Move
7. Board
8. ChessException et les exceptions filles
9. PieceFactory
10. Game
11. index.php

Vous ne devez pas commencer Game avant d'avoir terminé Board et les pièces.

## Ce qu'il ne faut pas faire au début
Au début du TP, vous ne devez pas coder :
- le roque ;
- la promotion ;
- la prise en passant ;
- l'échec et mat ;
- le pat ;
- un historique complet des coups.

On construit d'abord un socle propre.

## Phase 1 - Mise en place du socle
À cette phase, vous ne travaillez que sur : `Position`, `PieceColor`, `PieceType`, `Renderable`.

### 1. Classe Position (`src/Position.php`)
Propriétés imposées :
- `private int $row;`
- `private int $column;`

Méthodes imposées :
- `public function __construct(int $row, int $column)`
- `public function getRow(): int`
- `public function getColumn(): int`
- `public function equals(Position $other): bool`
- `public function toKey(): string`
- `public static function fromKey(string $key): Position`

Contraintes : `row` et `column` doivent être compris entre 0 et 7. `toKey()` doit retourner une chaîne du type "6:4".

### 2. Enum PieceColor (`src/Enum/PieceColor.php`)
Valeurs imposées : `WHITE`, `BLACK`
Méthode imposée : `public function opposite(): PieceColor`

### 3. Enum PieceType (`src/Enum/PieceType.php`)
Valeurs imposées : `KING`, `QUEEN`, `ROOK`, `BISHOP`, `KNIGHT`, `PAWN`

### 4. Interface Renderable (`src/Contract/Renderable.php`)
Méthode imposée : `public function render(): string;`

## Phase 2 - Hiérarchie des pièces
À cette phase, vous créez l'héritage métier.

### 1. Classe abstraite Piece (`src/Piece/Piece.php`)
Propriétés imposées :
- `protected PieceColor $color;`
- `protected Position $position;`
- `protected PieceType $type;`

Méthodes imposées :
- `public function __construct(PieceColor $color, Position $position)`
- `public function getColor(): PieceColor`
- `public function getPosition(): Position`
- `public function setPosition(Position $position): void`
- `public function getType(): PieceType`
- `public function render(): string`
- `public function canMove(Board $board, Position $target): bool`
- `abstract protected function isValidMovementShape(Position $target): bool`
- `protected function canCapture(Board $board, Position $target): bool`

### 2. Classes filles imposées
- `King`, `Queen`, `Rook`, `Bishop`, `Knight`, `Pawn` (dans `src/Piece/`)
Chaque sous-classe redéfinit `isValidMovementShape()` et initialise son type.

## Phase 3 - Représenter une intention de coup
Classe `Move` (`src/Move.php`) avec `from` et `to` (`Position`).

## Phase 4 - Construire le plateau
Classe `Board` (`src/Board.php`) avec stockage des pièces par clé de position.

## Phase 5 - Exceptions métier
Classes d'exceptions dans `src/Exception/` : `ChessException`, `InvalidMoveException`, `NoPieceException`, `WrongTurnException`, `OccupiedByAllyException`.

## Phase 6 - Factory de pièces
Classe `PieceFactory` (`src/Factory/PieceFactory.php`) pour centraliser la création des pièces.

## Phase 7 - Construire la partie
Classe `Game` (`src/Game.php`) qui gère la logique principale, les tours et la mise en place.

## Ce qui sera évalué
L'évaluation portera sur le respect strict de l'architecture, la qualité du polymorphisme, la gestion correcte des règles de base et la propreté du code.

