<?php

namespace Tests\Unit;

use App\Models\Match;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MatchTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /**
     * Tests match creation
     */
    public function testCreateMatch()
    {
        $match = factory(Match::class)->create();

        $this->assertInstanceOf(Match::class, $match);
    }

    /**
     * Tests match update
     */
    public function testUpdateMatch()
    {
        $match = factory(Match::class)->create();

        $pX = Match::PLAYER_X;
        $pO = Match::PLAYER_O;
        $pE = Match::EMPTY_POS;

        $next = [$pX, $pO];
        $states = [$pE, $pX, $pO];

        $data = [
            'name' => $this->faker->name,
            'next' => $this->faker->randomElement($next),
            'winner' => $this->faker->randomElement($states),
            'board' => $this->faker->randomElements($states, 9, true)
        ];

        $updated = $match->update($data);

        $this->assertTrue($updated);
        $this->assertEquals($data['name'], $match->name);
        $this->assertEquals($data['next'], $match->next);
        $this->assertEquals($data['winner'], $match->winner);
        $this->assertEquals($data['board'], $match->board);
    }

    /**
     * Tests match delete
     */
    public function testDeleteMatch()
    {
        $match = factory(Match::class)->create();

        $delete = $match->delete();

        $this->assertTrue($delete);
    }

    /**
     * Tests match show
     */
    public function testShowMatch()
    {
        $match = factory(Match::class)->create();

        $show = Match::find($match->id);

        $this->assertInstanceOf(Match::class, $show);
        $this->assertEquals($show->name, $match->name);
        $this->assertEquals($show->next, $match->next);
        $this->assertEquals($show->winner, $match->winner);
        $this->assertEquals($show->board, $match->board);
    }

    /**
     * Tests makeMath method
     */
    public function testMakeMatchMethod()
    {
        $data = Match::makeMatch();
        $match = Match::create($data);

        $this->assertInstanceOf(Match::class, $match);
    }

    /**
     * Tests makeBoard method
     */
    public function testMakeBoardMethod()
    {
        $board = Match::makeBoard();

        $emptyBoard = array_fill(0, 9, Match::EMPTY_POS);

        $this->assertEquals($emptyBoard, $board);
    }

    /**
     * Tests checkWinner method
     */
    public function testCheckWinner()
    {
        $pX = Match::PLAYER_X;
        $pO = Match::PLAYER_O;
        $pE = Match::EMPTY_POS;

        // all possible win scenarios for each board config
        $configs = [
            ['board' => [$pX, $pX, $pX, $pE, $pO, $pE, $pO, $pE, $pE], 'winPos' => [0, 1, 2]],
            ['board' => [$pX, $pE, $pE, $pX, $pO, $pE, $pX, $pE, $pE], 'winPos' => [0, 3, 6]],
            ['board' => [$pO, $pE, $pE, $pE, $pO, $pE, $pX, $pX, $pX], 'winPos' => [6, 7, 8]],
            ['board' => [$pO, $pE, $pX, $pE, $pO, $pX, $pX, $pO, $pX], 'winPos' => [2, 5, 8]],
            ['board' => [$pO, $pX, $pO, $pE, $pX, $pE, $pO, $pX, $pE], 'winPos' => [1, 4, 7]],
            ['board' => [$pO, $pE, $pO, $pX, $pX, $pX, $pO, $pE, $pE], 'winPos' => [3, 4, 5]],
            ['board' => [$pX, $pE, $pO, $pE, $pX, $pE, $pO, $pE, $pX], 'winPos' => [0, 4, 8]],
            ['board' => [$pX, $pE, $pX, $pO, $pX, $pE, $pX, $pE, $pO], 'winPos' => [2, 4, 6]]
        ];

        foreach($configs as $key => $config) {
            foreach($config['winPos'] as $pos) {
                $this->assertTrue(Match::checkWinner($config['board'], $pos), 'Failed to check winner of board '.$key.' at pos '.$pos);
            }
        }
    }
}
