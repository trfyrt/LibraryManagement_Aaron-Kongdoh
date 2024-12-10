<?php

namespace Tests\Unit;

use App\Models\Newspapers;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewspapersTest extends TestCase
{
    use RefreshDatabase;

/**
 * Test fetching all newspapers.
 */
public function test_it_can_fetch_all_newspapers(): void
{
    Newspapers::create([
        'title' => 'Newspaper One',
        'publisher' => 'Kompas',
        'publish_date' => now()->subDays(1)->toDateString(),
        'is_available' => true,
    ]);

    Newspapers::create([
        'title' => 'Newspaper Two',
        'publisher' => 'Tribun Timur',
        'publish_date' => now()->toDateString(),
        'is_available' => false,
    ]);

    $response = $this->getJson('/api/newspapers');

    $response->assertStatus(200)
             ->assertJsonStructure([
                 'success',
                 'data' => [
                     'data' => [
                         '*' => ['id', 'title', 'publisher', 'publish_date', 'is_available', 'created_at', 'updated_at'],
                     ],
                 ],
             ]);
}

    /**
     * Test fetching a single newspaper.
     */
    public function test_it_can_fetch_a_single_newspaper(): void
    {
        $newspaper = Newspapers::create([
            'title' => 'Single Newspaper',
            'publisher' => 'Kompas',
            'publish_date' => now()->toDateString(),
            'is_available' => true,
        ]);

        $response = $this->getJson("/api/newspapers/{$newspaper->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'data' => [
                         'id' => $newspaper->id,
                         'title' => 'Single Newspaper',
                     ],
                 ]);
    }

    /**
     * Test fetching a nonexistent newspaper returns 404.
     */
    public function test_it_returns_404_for_nonexistent_newspaper(): void
    {
        $response = $this->getJson('/api/newspapers/9999');

        $response->assertStatus(404)
                 ->assertJson([
                     'success' => false,
                     'message' => 'Newspaper not found',
                 ]);
    }

    /**
     * Test creating a newspaper.
     */
    public function test_it_can_create_a_newspaper(): void
    {
        $data = [
            'title' => 'Created Newspaper',
            'publisher' => 'Kompas',
            'publish_date' => now()->toDateString(),
            'is_available' => true,
        ];

        $response = $this->postJson('/api/newspapers', $data);

        $response->assertStatus(201)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Newspaper created successfully',
                 ]);

        $this->assertDatabaseHas('newspapers', $data);
    }

    /**
     * Test validation for required fields when creating a newspaper.
     */
    public function test_it_validates_required_fields_when_creating_a_newspaper(): void
    {
        $response = $this->postJson('/api/newspapers', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['title', 'publisher', 'publish_date', 'is_available']);
    }

    /**
     * Test updating a newspaper.
     */
    public function test_it_can_update_a_newspaper(): void
    {
        $newspaper = Newspapers::create([
            'title' => 'Original Title',
            'publisher' => 'Kompas',
            'publish_date' => now()->subDays(1)->toDateString(),
            'is_available' => true,
        ]);

        $data = [
            'title' => 'Updated Title',
            'publisher' => 'Tribun Timur',
            'publish_date' => now()->toDateString(),
            'is_available' => false,
        ];

        $response = $this->putJson("/api/newspapers/{$newspaper->id}", $data);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Newspaper updated successfully',
                 ]);

        $this->assertDatabaseHas('newspapers', $data);
    }

    /**
     * Test updating a nonexistent newspaper returns 404.
     */
    public function test_it_returns_404_when_updating_nonexistent_newspaper(): void
    {
        $response = $this->putJson('/api/newspapers/9999', [
            'title' => 'Updated Title',
            'publisher' => 'Tribun Timur',
            'publish_date' => now()->toDateString(),
            'is_available' => false,
        ]);

        $response->assertStatus(404)
                 ->assertJson([
                     'success' => false,
                     'message' => 'Newspaper not found',
                 ]);
    }

    /**
     * Test deleting a newspaper.
     */
    public function test_it_can_delete_a_newspaper(): void
    {
        $newspaper = Newspapers::create([
            'title' => 'To Delete',
            'publisher' => 'Kompas',
            'publish_date' => now()->toDateString(),
            'is_available' => true,
        ]);

        $response = $this->deleteJson("/api/newspapers/{$newspaper->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Newspaper deleted successfully',
                 ]);

        $this->assertDatabaseMissing('newspapers', ['id' => $newspaper->id]);
    }

    /**
     * Test deleting a nonexistent newspaper returns 404.
     */
    public function test_it_returns_404_when_deleting_nonexistent_newspaper(): void
    {
        $response = $this->deleteJson('/api/newspapers/9999');

        $response->assertStatus(404)
                 ->assertJson([
                     'success' => false,
                     'message' => 'Newspaper not found',
                 ]);
    }
}
