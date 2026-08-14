<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VideoAdminTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Seed default admin user and initial videos
        $this->seed();
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function unauthenticated_user_is_redirected_to_login()
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function user_can_login_with_valid_credentials()
    {
        $response = $this->post('/login', [
            'email' => 'admin@example.com',
            'password' => 'password123',
            'remember' => 'on',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function dashboard_shows_add_and_edit_buttons()
    {
        $user = User::where('email', 'admin@example.com')->first();
        
        $response = $this->actingAs($user)->get('/dashboard');
        
        $response->assertStatus(200);
        $response->assertSee('Add Video');
        $response->assertSee('Edit Videos');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function add_video_page_displays_form_fields_and_teachers()
    {
        $user = User::where('email', 'admin@example.com')->first();
        
        $response = $this->actingAs($user)->get('/videos/add');
        
        $response->assertStatus(200);
        $response->assertSee('Title');
        $response->assertSee('Description');
        $response->assertSee('Video Link / iFrame');
        $response->assertSee('Alexa');
        $response->assertSee('Jemini');
        $response->assertSee('Anna');
        $response->assertSee('Upload Thumbnail Image');
        $response->assertSee('Save Video Record');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function user_can_store_new_video_in_database()
    {
        $user = User::where('email', 'admin@example.com')->first();
        
        $response = $this->actingAs($user)->post('/videos/save', [
            'title' => 'Test Video Title',
            'description' => 'Test Video Description',
            'video_url' => 'https://vimeo.com/76979871',
            'teacher_name' => 'Alexa',
            'thumbnail_url' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97',
        ]);

        $response->assertRedirect(route('videos.edit-list'));
        $this->assertDatabaseHas('videos', [
            'title' => 'Test Video Title',
            'teacher_name' => 'Alexa',
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function data_table_page_displays_records_search_and_pagination()
    {
        $user = User::where('email', 'admin@example.com')->first();
        
        $response = $this->actingAs($user)->get('/videos/edit-list');
        
        $response->assertStatus(200);
        $response->assertSee('Data Table');
        $response->assertSee('Search title, teacher');
        $response->assertSee('Show Records:');
        $response->assertSee('Alexa');
        $response->assertSee('View');
        $response->assertSee('Edit');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function edit_page_loads_prefilled_data_and_embedded_video_player()
    {
        $user = User::where('email', 'admin@example.com')->first();
        $video = Video::first();
        
        $response = $this->actingAs($user)->get("/videos/{$video->id}/edit");
        
        $response->assertStatus(200);
        $response->assertSee($video->title);
        $response->assertSee('Embedded Video Preview');
        $response->assertSee($video->teacher_name);
        $response->assertSee('Save Changes');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function updating_video_shows_toaster_and_redirects_to_edit_data_table_page()
    {
        $user = User::where('email', 'admin@example.com')->first();
        $video = Video::first();
        
        $response = $this->actingAs($user)->post("/videos/{$video->id}/update", [
            'title' => 'Updated Title Masterclass',
            'description' => 'Updated Description text',
            'video_url' => 'https://vimeo.com/76979871',
            'teacher_name' => 'Jemini',
            'thumbnail_url' => $video->thumbnail_path,
        ]);

        // Requirement 11 & 12: Redirects to edit data table page with toaster session message
        $response->assertRedirect(route('videos.edit-list'));
        $response->assertSessionHas('toaster_success', 'Video updated successfully');
        
        $this->assertDatabaseHas('videos', [
            'id' => $video->id,
            'title' => 'Updated Title Masterclass',
            'teacher_name' => 'Jemini',
        ]);
    }
}
