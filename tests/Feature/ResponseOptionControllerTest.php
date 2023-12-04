<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Survey;
use App\Models\ResponseOption;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;

class ResponseOptionControllerTest extends TestCase
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
    public function test_option_index(): void
    {
        $response = $this->actingAs($this->user)->get(route('options.index', array('survey' =>$this->survey)));

        $response->assertStatus(200);
    }
    public function test_option_store(): void
    {
        $responseCreate = $this->actingAs($this->user)->get(route('options.create', array('survey' =>$this->survey)));
        $responseCreate->assertStatus(200);

        $responseStore = $this->actingAs($this->user)->post(route('options.store', array('survey' => $this->survey)), [
            'title' => "Option #1",
        ]);
        $responseStore->assertRedirect(route('options.index', array('survey' =>$this->survey)));
        $this->assertDatabaseHas('response_options', [
            'title' => "Option #1"
        ]);
    }
    public function test_option_edit(): void
    {
        $response = $this->actingAs($this->user)->get(route('options.edit', ['option' => $this->option]));
        $response->assertStatus(200);
    }
    public function test_option_update(): void
    {
        Storage::fake('avatars');

        $file = UploadedFile::fake()->image('avatar.jpg');

        $dbImage = Image::create([
            'filename' => $file->getRealPath()
        ]);
        $request = [
            'title' => "Updated option",
            'image_id' => $dbImage->id
        ];

        $response = $this->actingAs($this->user)->post(
            route('options.update', ['option' => $this->option]),
            $request
        );
        $this->assertDatabaseHas('response_options', [
            'title' => "Updated option"
        ]);
        // var_dump($response);
        $response->assertRedirect(route('options.index', [$this->survey]));
    }
    public function test_option_destroy(): void
    {
        $response = $this->actingAs($this->user)->delete(route('options.destroy', $this->option));
        $response->assertRedirect(route('surveys.index', [$this->survey]));
        $this->assertDatabaseMissing('response_options', [
            'title' => $this->option->title
        ]);
    }
    public function test_option_access() : void{
        $responseIndex = $this->get(route('options.index', array('survey' =>$this->survey)));
        $responseIndex->assertRedirect('/login');

        $responseCreate = $this->get(route('options.create', array('survey' =>$this->survey)));
        $responseCreate->assertRedirect('/login');

        $responseStore = $this->post(route('options.store', array('survey' => $this->survey)), [
            'title' => "Option #1",
        ]);
        $responseStore->assertRedirect('/login');

        $responseEdit = $this->get(route('options.edit', ['option' => $this->option]));
        $responseEdit->assertRedirect('/login');

        $request = [
            'title' => "Updated option"
        ];

        $responseUpdate = $this->post(
            route('options.update', ['option' => $this->option]),
            $request
        );
        $responseUpdate->assertRedirect('/login');

        $responseDestroy = $this->delete(route('options.destroy', $this->option));
        $responseDestroy->assertRedirect('/login');
    }
}
