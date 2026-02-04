<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Tour;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TourApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $admin;
    protected $category;

    protected function setUp(): void
    {
        parent::setUp();

        // Create admin user
        $this->admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'active'
        ]);

        // Create category
        $this->category = Category::create([
            'category_name' => 'Test Category',
            'description' => 'Test Description',
            'status' => 'active'
        ]);
    }

    public function test_can_get_tours_list()
    {
        // Create some tours
        Tour::factory()->count(3)->create([
            'category_id' => $this->category->category_id,
            'created_by' => $this->admin->user_id
        ]);

        $response = $this->getJson('/api/tours');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'message',
                    'data' => [
                        'current_page',
                        'data' => [
                            '*' => [
                                'tour_id',
                                'tour_name',
                                'price',
                                'status'
                            ]
                        ]
                    ]
                ]);
    }

    public function test_admin_can_create_tour()
    {
        $tourData = [
            'tour_name' => 'Test Tour',
            'description' => 'Test Description',
            'price' => 1000000,
            'duration' => 3,
            'max_participants' => 20,
            'start_date' => now()->addDays(7)->format('Y-m-d H:i:s'),
            'end_date' => now()->addDays(10)->format('Y-m-d H:i:s'),
            'location' => 'Test Location',
            'category_id' => $this->category->category_id,
            'status' => 'active'
        ];

        $response = $this->actingAs($this->admin, 'sanctum')
                        ->postJson('/api/admin/tours', $tourData);

        $response->assertStatus(201)
                ->assertJsonStructure([
                    'success',
                    'message',
                    'data' => [
                        'tour_id',
                        'tour_name',
                        'price'
                    ]
                ]);

        $this->assertDatabaseHas('tours', [
            'tour_name' => 'Test Tour',
            'price' => 1000000
        ]);
    }

    public function test_guest_cannot_create_tour()
    {
        $tourData = [
            'tour_name' => 'Test Tour',
            'price' => 1000000
        ];

        $response = $this->postJson('/api/admin/tours', $tourData);

        $response->assertStatus(401);
    }

    public function test_regular_user_cannot_create_tour()
    {
        $user = User::factory()->create(['role' => 'user']);

        $tourData = [
            'tour_name' => 'Test Tour',
            'price' => 1000000
        ];

        $response = $this->actingAs($user, 'sanctum')
                        ->postJson('/api/admin/tours', $tourData);

        $response->assertStatus(403);
    }
}