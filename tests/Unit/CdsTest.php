<?php

namespace Tests\Unit;

use App\Models\Cds;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;

class CdsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test fetching all CDs.
     */
    public function test_it_can_fetch_all_cds(): void
    {
        // Buat data manual
        Cds::create([
            'title' => 'CD One',
            'artist' => 'Artist One',
            'genre' => 'Genre One',
            'stock' => 10,
        ]);

        Cds::create([
            'title' => 'CD Two',
            'artist' => 'Artist Two',
            'genre' => 'Genre Two',
            'stock' => 5,
        ]);

        $response = $this->getJson('/api/cds');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'data' => [
                         '*' => ['id', 'title', 'artist', 'genre', 'stock', 'created_at', 'updated_at'],
                     ],
                 ]);
    }

    /**
     * Test fetching a single CD.
     */
    public function test_it_can_fetch_a_single_cd(): void
    {
        $cd = Cds::create([
            'title' => 'CD One',
            'artist' => 'Artist One',
            'genre' => 'Genre One',
            'stock' => 10,
        ]);

        $response = $this->getJson("/api/cds/{$cd->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'data' => [
                         'id' => $cd->id,
                         'title' => 'CD One',
                     ],
                 ]);
    }

    /**
     * Test fetching a nonexistent CD returns 404.
     */
    public function test_it_returns_404_for_nonexistent_cd(): void
    {
        $response = $this->getJson('/api/cds/9999');

        $response->assertStatus(404)
                 ->assertJson([
                     'success' => false,
                     'message' => 'CD not found',
                 ]);
    }

    /**
     * Test creating a CD.
     */
    public function test_it_can_create_a_cd(): void
    {
        $data = [
            'title' => 'New CD',
            'artist' => 'Artist Name',
            'genre' => 'Rock',
            'stock' => 10,
        ];

        $response = $this->postJson('/api/cds', $data);

        $response->assertStatus(201)
                 ->assertJson([
                     'success' => true,
                     'message' => 'CD created successfully',
                 ]);

        $this->assertDatabaseHas('cds', $data);
    }

    /**
     * Test validation for required fields when creating a CD.
     */
    public function test_it_validates_required_fields_when_creating_a_cd(): void
    {
        $response = $this->postJson('/api/cds', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['title', 'artist', 'genre', 'stock']);
    }

    /**
     * Test updating a CD.
     */
    public function test_it_can_update_a_cd(): void
    {
        $cd = Cds::create([
            'title' => 'Original Title',
            'artist' => 'Original Artist',
            'genre' => 'Original Genre',
            'stock' => 5,
        ]);

        $data = [
            'title' => 'Updated Title',
            'artist' => 'Updated Artist',
            'genre' => 'Updated Genre',
            'stock' => 10,
        ];

        $response = $this->putJson("/api/cds/{$cd->id}", $data);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'CD updated successfully',
                 ]);

        $this->assertDatabaseHas('cds', $data);
    }

    /**
     * Test updating a nonexistent CD returns 404.
     */
    public function test_it_returns_404_when_updating_nonexistent_cd(): void
    {
        $response = $this->putJson('/api/cds/9999', [
            'title' => 'Updated Title',
            'artist' => 'Updated Artist',
            'genre' => 'Updated Genre',
            'stock' => 10,
        ]);

        $response->assertStatus(404)
                 ->assertJson([
                     'success' => false,
                     'message' => 'CD not found',
                 ]);
    }

    /**
     * Test deleting a CD.
     */
    public function test_it_can_delete_a_cd(): void
    {
        $cd = Cds::create([
            'title' => 'CD to Delete',
            'artist' => 'Artist',
            'genre' => 'Genre',
            'stock' => 10,
        ]);

        $response = $this->deleteJson("/api/cds/{$cd->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'CD deleted successfully',
                 ]);

        $this->assertDatabaseMissing('cds', ['id' => $cd->id]);
    }

    /**
     * Test deleting a nonexistent CD returns 404.
     */
    public function test_it_returns_404_when_deleting_nonexistent_cd(): void
    {
        $response = $this->deleteJson('/api/cds/9999');

        $response->assertStatus(404)
                 ->assertJson([
                     'success' => false,
                     'message' => 'CD not found',
                 ]);
    }
}
