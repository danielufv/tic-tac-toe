<?php

namespace App\Http\Controllers;

use App\Models\Match;
use Illuminate\Support\Facades\Input;

class MatchController extends Controller
{
    /**
     * Returns a list of matches
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function matches()
    {
        $matches = Match::all();
        return response()->json($matches);
    }

    /**
     * Returns the state of a single match
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function match($id)
    {
        $match = Match::findOrFail($id);
        return response()->json($match);
    }

    /**
     * Makes a move in a match
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function move($id)
    {
        $match = Match::findOrFail($id);
        $board = $match->board;

        $position = Input::get('position');

        // Update the movement only if the position is not already checked or the match was not ended
        if(!$board[$position] && !$match->winner) {
            $currentPlayer = $match->next;
            $board[$position] = $currentPlayer;
            $winner = Match::checkWinner($board, $position);
            $match->board = $board;
            $match->next = $currentPlayer === Match::PLAYER_X ? Match::PLAYER_O : Match::PLAYER_X;
            $match->winner = $winner ? $currentPlayer : $winner;
            $match->save();
        }

        return response()->json($match);
    }

    /**
     * Creates a new match and returns the new list of matches
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        Match::create(Match::makeMatch());

        return response()->json(Match::all());
    }

    /**
     * Deletes the match and returns the new list of matches
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        Match::destroy($id);

        return response()->json(Match::all());
    }
}