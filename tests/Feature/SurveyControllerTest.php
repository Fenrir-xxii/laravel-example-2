<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Survey;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;

class SurveyControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    protected $user;
    protected $survey;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->survey = Survey::factory()->for($this->user)->create();
    }
    public function test_survey_index(): void
    {
        $response = $this->actingAs($this->user)->get(route('surveys.index'));

        $response->assertStatus(200);
    }
    public function test_survey_show(): void
    {
        $response = $this->actingAs($this->user)->get(route('surveys.show', ['survey' => $this->survey]));

        $response->assertStatus(200);
    }
    public function test_survey_store(): void
    {
        $responseCreate = $this->actingAs($this->user)->get(route('surveys.create'));
        $responseCreate->assertStatus(200);

        $responseStore = $this->actingAs($this->user)->post(route('surveys.store'), [
            'title' => "Some survey",
            'description' => "some description",
            'start_at' => now(),
            'end_at' => now()->addDays(2),
            'active' => true,
        ]);
        $responseStore->assertRedirect(route('surveys.index'));

        $this->assertDatabaseHas('surveys', [
            'title' => "Some survey",
            'description' => "some description",
            'active' => true
        ]);
    }
    public function test_survey_edit(): void
    {
        $response = $this->actingAs($this->user)->get(route('surveys.edit', ['survey' => $this->survey]));
        $response->assertStatus(200);
    }
    public function test_survey_update(): void
    {
        Storage::fake('avatars');

        $file = UploadedFile::fake()->image('avatar.jpg');

        $dbImage = Image::create([
            'filename' => $file->getRealPath()
        ]);
        $this->assertDatabaseCount('images', 1);
        $imageId = $dbImage->id;
        $request = [
            'title' => "Updated survey",
            'description' => "Updated description",
            'start_at' => now(),
            'end_at' => now()->addDays(8),
            'active' => false,
            'image_id' => $imageId
        ];

        $response = $this->actingAs($this->user)->post(
            route('surveys.update', ['survey' => $this->survey,]),
            $request
        );
        // var_dump($response);
        $response->assertRedirect(route('surveys.index'));

        $this->assertDatabaseHas('surveys', [
            'title' => "Updated survey",
            'description' => "Updated description",
        ]);
    }
    public function test_survey_destroy(): void
    {
        $response = $this->actingAs($this->user)->delete(route('surveys.destroy', $this->survey));
        $response->assertRedirect(route('surveys.index'));
        $this->assertDatabaseMissing('surveys', [
            'title' => $this->survey->title
        ]);
    }
    public function test_survey_access() : void{
        $responseIndex = $this->get(route('surveys.index'));
        $responseIndex->assertRedirect('/login');

        $responseShow = $this->get(route('surveys.show', ['survey' => $this->survey]));
        $responseShow->assertRedirect('/login');

        $responseCreate = $this->get(route('surveys.create'));
        $responseCreate->assertRedirect('/login');

        $responseStore = $this->post(route('surveys.store'), [
            'title' => "New survey",
            'description' => "some description",
            'start_at' => now(),
            'end_at' => now()->addDays(2),
            'active' => true,
        ]);
        $responseStore->assertRedirect('/login');

        $responseEdit = $this->get(route('surveys.edit', ['survey' => $this->survey]));
        $responseEdit->assertRedirect('/login');

        $request = [
            'title' => "Updated survey",
            'description' => "Updated description",
            'start_at' => now(),
            'end_at' => now()->addDays(8),
            'active' => false
        ];

        $responseUpdate = $this->post(
            route('surveys.update', ['survey' => $this->survey,]),
            $request
        );
        $responseUpdate->assertRedirect('/login');

        $responseDestroy = $this->delete(route('surveys.destroy', $this->survey));
        $responseDestroy->assertRedirect('/login');
    }
}
