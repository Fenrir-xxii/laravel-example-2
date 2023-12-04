<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Survey;
use App\Http\Requests\SurveyRequest;
use Illuminate\Routing\Route;

class RouteTest extends TestCase
{
    // use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    protected $user;
    protected $survey;

    public function setUp(): void {

        parent::setUp();

        $this->user =  User::factory()->create();
        $this->survey = Survey::factory()->for($this->user)->create();
        // $this->survey = Survey::create([
        //     'title' => "Test survey",
        //     'description' => "Whatever",
        //     'start_at' => "2023-11-20",
        //     'end_at' => "2023-11-29",
        //     'active' => true,
        //     'image_id' => null,
        //     'user_id' =>  $this->user->id,
        //     'search' => "Test Survey Тест опитування"
        // ]);
        
    }
    public function tets_home_page(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function test_dashboard_page(): void
    {

        $response = $this->actingAs($this->user)
                         ->get('/dashboard');

        $response->assertStatus(200);
    }
    public function test_surveys_pages(): void
    {
        $response = $this->actingAs($this->user)->get('/surveys');
        $response->assertStatus(200);

        // $r = '/survey/' . $this->survey . '/edit';
        // var_dump($r); die();
        $response2 = $this->actingAs($this->user)->call('GET', '/survey/' . $this->survey->id . '/edit');
        $response2->assertStatus(200);
        
        // $response3 = $this->actingAs($this->user)->call('POST', '/survey/' . $this->survey->id .'/update');
        // $request = new SurveyRequest([], [], ['title' => "new survey"]);
        // $request->setRouteResolver(function () use ($request) {
        //     return (new Route('POST', '/survey/{survey}/update', []))->bind($request);
        // });
        // dd($request->route()->parameter('title'));
        $postData = [
            'survey' => $this->survey,
            'title' => 'new Survey',
            'start_at' => '2023-11-24',
            'end_at' => '2023-11-29'
            // ... add other parameters as needed
        ];
        $response3 = $this->followingRedirects()->actingAs($this->user)->call('POST', '/survey/' . $this->survey->id . '/update', $postData);
        $response3->assertStatus(200);
    }
     /**
     * A basic test example.
     *
     * @return void
     */
    public function testYourTestMethod()
    {
        $postData = [
            'survey' => $this->survey,
            'title' => 'new Survey',
            'start_at' => '2023-11-24',
            'end_at' => '2023-11-29'
            // ... add other parameters as needed
        ];

        $response = $this->followingRedirects()->actingAs($this->user)->post('/survey/'. $this->survey->id .'/update', $postData);

        $response->assertStatus(200); // assert the expected HTTP status code
                //  ->assertJson(['key' => 'value']); // assert any expected JSON response

        // ... add more assertions as needed
    }
}
