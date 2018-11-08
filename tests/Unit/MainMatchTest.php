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
        Match::create(['winner' => Match::PLAYER_X]);

        $winner = MainMatch::checkWinner();

        $this->assertFalse($winner);

        Match::create(['winner' => Match::PLAYER_O]);

        $this->assertFalse($winner);

        $thirdMatch = Match::create(['winner' => Match::PLAYER_X]);

        $this->assertEquals(Match::PLAYER_X, $thirdMatch);
    }

    public function testCheckWinnerTwo()
    {
        Match::create(['winner' => Match::PLAYER_X]);

        $winner = MainMatch::checkWinner();

        $this->assertFalse($winner);

        Match::create(['winner' => Match::PLAYER_X]);

        $this->assertTrue($winner);
    }

    public function testCheckWinnerThree()
    {
        Match::create(['winner' => Match::PLAYER_X]);

        $winner = MainMatch::checkWinner();

        $this->assertFalse($winner);

        Match::create(['winner' => Match::EMPTY_POS]);

        $this->assertFalse($winner);

        Match::create(['winner' => Match::PLAYER_X]);

        $this->assertTrue($winner);
    }

    public function testCheckDrawOne()
    {
        Match::create(['winner' => Match::EMPTY_POS]);

        $winner = MainMatch::checkWinner();

        $this->assertFalse($winner);

        Match::create(['winner' => Match::EMPTY_POS]);

        $this->assertFalse($winner);
    }

    public function testCheckDrawTwo()
    {
        Match::create(['winner' => Match::EMPTY_POS]);

        $winner = MainMatch::checkWinner();

        $this->assertFalse($winner);

        Match::create(['winner' => Match::PLAYER_O]);

        $this->assertFalse($winner);

        Match::create(['winner' => Match::PLAYER_X]);

        $this->assertFalse($winner);
    }
}
