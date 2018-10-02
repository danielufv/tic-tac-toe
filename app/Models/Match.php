<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    const EMPTY_POS = 0;
    const PLAYER_X = 1;
    const PLAYER_O = 2;

    /**
     * Attribute casting.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'int',
        'next' => 'int',
        'winner' => 'int',
        'board' => 'array'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'next', 'winner', 'board'
    ];


    // Auxiliary methods

    /**
     * Gets an initial match config
     *
     * @return array
     */
    public static function makeMatch()
    {
        $board = Match::makeBoard();
        $data = [
            'name' => 'Match '.str_random(5),
            'next' => Match::PLAYER_X,
            'winner' => 0,
            'board' => $board
        ];
        return $data;
    }

    /**
     * Gets an empty (initial) board
     *
     * @return array
     */
    public static function makeBoard()
    {
        return array_fill(0, 9, Match::EMPTY_POS);
    }

    /**
     * Return true if the last move resulted in a winner or false, otherwise.
     * The algorithm considers the last position checked, and based on it, verifies the other possible positions that would give the
     * victory to the player.
     * The array is defined as:
     * |0 | 1 | 2|
     * |--|---|--|
     * |3 | 4 | 5|
     * |--|---|--|
     * |6 | 7 | 8|
     *
     * @param array $board Actual board
     * @param integer $pos Last position
     *
     * @return boolean
     */
    public static function checkWinner($board, $pos)
    {
        $nextPos = [
            [[1, 2], [3, 6], [4, 8]],           // combinations for position 0
            [[0, 2], [4, 7]],                   // combinations for position 1
            [[0, 1], [4, 6], [5, 8]],           // combinations for position 2
            [[0, 6], [4, 5]],                   // combinations for position 3
            [[0, 8], [1, 7], [2, 6], [3, 5]],   // combinations for position 4
            [[2, 8], [3, 4]],                   // combinations for position 5
            [[0, 3], [2, 4], [7, 8]],           // combinations for position 6
            [[1, 4], [6, 8]],                   // combinations for position 7
            [[0, 4], [2, 5], [6, 7]]            // combinations for position 8
        ];

        $currentPlayer = $board[$pos];
        for ($i = 0; $i < count($nextPos[$pos]); $i++) {
            $line = $nextPos[$pos][$i];
            if($currentPlayer === $board[$line[0]] && $currentPlayer === $board[$line[1]]) {
                return true;
            }
        }

        return false;
    }
}
