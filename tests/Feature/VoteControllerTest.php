<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Survey;
use App\Models\ResponseOption;
use App\Models\Vote;

class VoteControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    protected $user;
    protected $survey;
    protected $option;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->survey = Survey::factory()->for($this->user)->create();
        $this->option = ResponseOption::factory()->for($this->survey)->create();
    }
    public function test_vote_index(): void
    {
        $response = $this->actingAs($this->user)->get(route('voting.index'));

        $response->assertStatus(200);
    }
    public function test_vote_store(): void //Vote
    {
        $responseCreate = $this->actingAs($this->user)->get(route('voting.create', array('survey' =>$this->survey)));
        $responseCreate->assertStatus(200);

        $responseStore = $this->actingAs($this->user)->post(route('voting.store'), array('selected_option' => $this->option->id));
        $responseStore->assertRedirect(route('voting.index'));

        $this->assertDatabaseHas('votes', [
            'user_id' => $this->user->id,
            'survey_id' => $this->survey->id
        ]);
        // return Vote::query()->first();
    }

    public function test_vote_double_voting(): void
    {
        // voting
        $firstResponseStore = $this->actingAs($this->user)->post(route('voting.store'), array('selected_option' => $this->option->id));
         
        // voting again
        $secondResponseStore = $this->actingAs($this->user)->post(route('voting.store'), array('selected_option' => $this->option->id));
        
        // check count of votes in db
        $this->assertDatabaseCount('votes', 1);

        $firstResponseStore->assertRedirect(route('voting.index'));
        $secondResponseStore->assertRedirect(route('voting.index'));

    }
}
