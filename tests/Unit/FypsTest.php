<?php

namespace Tests\Unit;

use App\Models\Fyps;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FypsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test fetching all FYPs.
     */
    public function test_it_can_fetch_all_fyps(): void
    {
        // Manual data insertion
        Fyps::create(['title' => 'FYP One', 'author' => 'Author One', 'supervisor' => 'Supervisor One', 'year' => 2023, 'is_approved' => false]);
        Fyps::create(['title' => 'FYP Two', 'author' => 'Author Two', 'supervisor' => 'Supervisor Two', 'year' => 2024, 'is_approved' => false]);

        $response = $this->getJson('/api/fyps');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'data' => [
                         '*' => ['id', 'title', 'author', 'supervisor', 'year', 'is_approved', 'created_at', 'updated_at'],
                     ],
                 ]);
    }

    /**
     * Test fetching a single FYP.
     */
    public function test_it_can_fetch_a_single_fyp(): void
    {
        $fyp = Fyps::create(['title' => 'Specific FYP', 'author' => 'John Doe', 'supervisor' => 'Dr. Smith', 'year' => 2023, 'is_approved' => false]);

        $response = $this->getJson("/api/fyps/{$fyp->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'data' => [
                         'id' => $fyp->id,
                         'title' => 'Specific FYP',
                     ],
                 ]);
    }

    /**
     * Test fetching a nonexistent FYP returns 404.
     */
    public function test_it_returns_404_for_nonexistent_fyp(): void
    {
        $response = $this->getJson('/api/fyps/9999');

        $response->assertStatus(404)
                 ->assertJson([
                     'success' => false,
                     'message' => 'FYP not found',
                 ]);
    }

    /**
     * Test creating a new FYP.
     */
    public function test_it_can_create_a_fyp(): void
    {
        $data = [
            'title' => 'New FYP',
            'author' => 'John Doe',
            'supervisor' => 'Dr. Smith',
            'year' => 2023,
        ];

        $response = $this->postJson('/api/fyps', $data);

        $response->assertStatus(201)
                 ->assertJson([
                     'success' => true,
                     'message' => 'FYP created successfully',
                 ]);

        $this->assertDatabaseHas('fyps', $data);
    }

    /**
     * Test validation for required fields when creating a FYP.
     */
    public function test_it_validates_required_fields_when_creating_a_fyp(): void
    {
        $response = $this->postJson('/api/fyps', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['title', 'author', 'supervisor', 'year']);
    }

    /**
     * Test updating an FYP.
     */
    public function test_it_can_update_a_fyp(): void
    {
        $fyp = Fyps::create(['title' => 'Old Title', 'author' => 'John Doe', 'supervisor' => 'Dr. Smith', 'year' => 2023, 'is_approved' => false]);

        $data = [
            'title' => 'Updated Title',
            'author' => 'Updated Author',
            'supervisor' => 'Updated Supervisor',
            'year' => 2024,
        ];

        $response = $this->putJson("/api/fyps/{$fyp->id}", $data);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'FYP updated successfully',
                 ]);

        $this->assertDatabaseHas('fyps', $data);
    }

    /**
     * Test updating a nonexistent FYP returns 404.
     */
    public function test_it_returns_404_when_updating_nonexistent_fyp(): void
    {
        $response = $this->putJson('/api/fyps/9999', [
            'title' => 'Updated Title',
            'author' => 'Updated Author',
            'supervisor' => 'Updated Supervisor',
            'year' => 2024,
        ]);

        $response->assertStatus(404)
                 ->assertJson([
                     'success' => false,
                     'message' => 'FYP not found',
                 ]);
    }

    /**
     * Test deleting an FYP.
     */
    public function test_it_can_delete_a_fyp(): void
    {
        $fyp = Fyps::create(['title' => 'FYP to Delete', 'author' => 'John Doe', 'supervisor' => 'Dr. Smith', 'year' => 2023, 'is_approved' => false]);

        $response = $this->deleteJson("/api/fyps/{$fyp->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'FYP deleted successfully',
                 ]);

        $this->assertDatabaseMissing('fyps', ['id' => $fyp->id]);
    }

    /**
     * Test deleting a nonexistent FYP returns 404.
     */
    public function test_it_returns_404_when_deleting_nonexistent_fyp(): void
    {
        $response = $this->deleteJson('/api/fyps/9999');

        $response->assertStatus(404)
                 ->assertJson([
                     'success' => false,
                     'message' => 'FYP not found',
                 ]);
    }
}
