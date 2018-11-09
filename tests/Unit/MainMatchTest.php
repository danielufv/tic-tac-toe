<?php

namespace Tests\Unit;

use App\Models\MainMatch;
use App\Models\Match;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MainMatchTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /**
     * Tests match creation
     */
    public function testCreateMainMatch()
    {
        $mainMatch = factory(MainMatch::class)->create();

        $this->assertInstanceOf(MainMatch::class, $mainMatch);
    }

    /**
     * Tests match creation
     */
    public function testCreateDefaultMatch()
    {
        $mainMatch = MainMatch::createMatch(Match::PLAYER_X);

        $this->assertInstanceOf(MainMatch::class, $mainMatch);

        $this->assertEquals(count($mainMatch->matches), 1);
    }

    /**
     * Tests match delete
     */
    public function testDeleteMatch()
    {
        $mainMatch = factory(MainMatch::class)->create();

        $delete = $mainMatch->delete();

        $this->assertTrue($delete);
    }

    /**
     * Tests match show
     */
    public function testShowMatch()
    {
        $mainMatch = factory(MainMatch::class)->create();

        $show = MainMatch::find($mainMatch->id);

        $this->assertInstanceOf(MainMatch::class, $show);
        $this->assertEquals($show->id, $mainMatch->id);
    }

    public function testCheckWinnerOne()
    {
        $mainMatch = factory(MainMatch::class)->create();

        Match::create(['main_match_id' => $mainMatch->id, 'name' => 'Match '.str_random(5), 'winner' => Match::PLAYER_X]);

        $winner = MainMatch::checkWinner($mainMatch->id);

        $this->assertEquals($winner, Match::EMPTY_POS);

        Match::create(['main_match_id' => $mainMatch->id, 'name' => 'Match '.str_random(5), 'winner' => Match::PLAYER_O]);

        $winner = MainMatch::checkWinner($mainMatch->id);

        $this->assertEquals($winner, Match::EMPTY_POS);

        Match::create(['main_match_id' => $mainMatch->id, 'name' => 'Match '.str_random(5), 'winner' => Match::PLAYER_X]);

        $winner = MainMatch::checkWinner($mainMatch->id);

        $this->assertEquals($winner, Match::PLAYER_X);
    }

    public function testCheckWinnerTwo()
    {
        $mainMatch = factory(MainMatch::class)->create();

        Match::create(['main_match_id' => $mainMatch->id, 'name' => 'Match '.str_random(5), 'winner' => Match::PLAYER_X]);

        $winner = MainMatch::checkWinner($mainMatch->id);

        $this->assertEquals($winner, Match::EMPTY_POS);

        Match::create(['main_match_id' => $mainMatch->id, 'name' => 'Match '.str_random(5), 'winner' => Match::PLAYER_X]);

        $winner = MainMatch::checkWinner($mainMatch->id);

        $this->assertEquals($winner, Match::PLAYER_X);
    }

    public function testCheckWinnerThree()
    {
        $mainMatch = factory(MainMatch::class)->create();

        Match::create(['main_match_id' => $mainMatch->id, 'name' => 'Match '.str_random(5), 'winner' => Match::PLAYER_X]);

        $winner = MainMatch::checkWinner($mainMatch->id);

        $this->assertEquals($winner, Match::EMPTY_POS);

        Match::create(['main_match_id' => $mainMatch->id, 'name' => 'Match '.str_random(5), 'winner' => Match::EMPTY_POS]);

        $winner = MainMatch::checkWinner($mainMatch->id);

        $this->assertEquals($winner, Match::EMPTY_POS);

        Match::create(['main_match_id' => $mainMatch->id, 'name' => 'Match '.str_random(5), 'winner' => Match::PLAYER_X]);

        $winner = MainMatch::checkWinner($mainMatch->id);

        $this->assertEquals($winner, Match::PLAYER_X);
    }

    public function testCheckDrawOne()
    {
        $mainMatch = factory(MainMatch::class)->create();

        Match::create(['main_match_id' => $mainMatch->id, 'name' => 'Match '.str_random(5), 'winner' => Match::EMPTY_POS]);

        $winner = MainMatch::checkWinner($mainMatch->id);

        $this->assertEquals($winner, Match::EMPTY_POS);

        Match::create(['main_match_id' => $mainMatch->id, 'name' => 'Match '.str_random(5), 'winner' => Match::EMPTY_POS]);

        $winner = MainMatch::checkWinner($mainMatch->id);

        $this->assertEquals($winner, Match::EMPTY_POS);
    }

    public function testCheckDrawTwo()
    {
        $mainMatch = factory(MainMatch::class)->create();

        Match::create(['main_match_id' => $mainMatch->id, 'name' => 'Match '.str_random(5), 'winner' => Match::EMPTY_POS]);

        $winner = MainMatch::checkWinner($mainMatch->id);

        $this->assertEquals($winner, Match::EMPTY_POS);

        Match::create(['main_match_id' => $mainMatch->id, 'name' => 'Match '.str_random(5), 'winner' => Match::PLAYER_O]);

        $winner = MainMatch::checkWinner($mainMatch->id);

        $this->assertEquals($winner, Match::EMPTY_POS);

        Match::create(['main_match_id' => $mainMatch->id, 'name' => 'Match '.str_random(5), 'winner' => Match::PLAYER_X]);

        $winner = MainMatch::checkWinner($mainMatch->id);

        $this->assertEquals($winner, Match::EMPTY_POS);
    }
}
