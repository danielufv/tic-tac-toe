<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MainMatch extends Model
{
    public function matches()
    {
        return $this->hasMany(Match::class);
    }

    // Auxiliary methods

    public static function checkWinner($id)
    {
        $mainMatch = MainMatch::findOrFail($id);
        $matches = $mainMatch->matches;

        $check = [];
        $winner = 0;

        foreach($matches as $match) {
            $check[$match->winner] = ($check[$match->winner] ?? 0) + 1;
        }

        foreach($check as $winnerMatch => $total)
        {
            if($total === 2) {
                $winner = $winnerMatch;
                break;
            }
        }

        return $winner;
    }

    /**
     * Cria uma partida inicial
     *
     * @param $player
     * @return mixed
     */
    public static function createMatch($player)
    {
        $mainMatch = MainMatch::create([]);
        $board = Match::makeBoard();

        $mainMatch->matches()->create([
            'match_id' => $mainMatch->id,
            'name' => 'Match '.str_random(5),
            'next' => $player === Match::PLAYER_X ? Match::PLAYER_O : Match::PLAYER_X,
            'board' => $board
        ]);

        return $mainMatch;
    }
}
