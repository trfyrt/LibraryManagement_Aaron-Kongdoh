<?php

namespace Tests\Unit;

use App\Models\Journals;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JournalsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test fetching all journals.
     */
    public function test_it_can_fetch_all_journals(): void
    {
        Journals::create(['title' => 'Journal One', 'author' => 'Author One', 'publish_date' => '2024-01-01', 'abstract' => 'Abstract One']);
        Journals::create(['title' => 'Journal Two', 'author' => 'Author Two', 'publish_date' => '2024-01-02', 'abstract' => 'Abstract Two']);

        $response = $this->getJson('/api/journals');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'data' => [
                         'data' => [
                             '*' => ['id', 'title', 'author', 'publish_date', 'abstract', 'is_approved', 'created_at', 'updated_at'],
                         ],
                     ],
                 ]);
    }

    /**
     * Test fetching a single journal.
     */
    public function test_it_can_fetch_a_single_journal(): void
    {
        $journal = Journals::create(['title' => 'Specific Journal', 'author' => 'Author Name', 'publish_date' => '2024-01-01', 'abstract' => 'Specific Abstract']);

        $response = $this->getJson("/api/journals/{$journal->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'data' => [
                         'id' => $journal->id,
                         'title' => 'Specific Journal',
                     ],
                 ]);
    }

    /**
     * Test fetching a nonexistent journal returns 404.
     */
    public function test_it_returns_404_for_nonexistent_journal(): void
    {
        $response = $this->getJson('/api/journals/9999');

        $response->assertStatus(404)
                 ->assertJson([
                     'success' => false,
                     'message' => 'Journal not found',
                 ]);
    }

    /**
     * Test creating a new journal.
     */
    public function test_it_can_create_a_journal(): void
    {
        $data = [
            'title' => 'New Journal',
            'author' => 'Jane Doe',
            'publish_date' => '2024-01-01',
            'abstract' => 'This is a test abstract.',
        ];

        $response = $this->postJson('/api/journals', $data);

        $response->assertStatus(201)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Journal created successfully',
                 ]);

        $this->assertDatabaseHas('journals', $data);
    }

    /**
     * Test validation for required fields when creating a journal.
     */
    public function test_it_validates_required_fields_when_creating_a_journal(): void
    {
        $response = $this->postJson('/api/journals', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['title', 'author', 'publish_date', 'abstract']);
    }

    /**
     * Test updating a journal.
     */
    public function test_it_can_update_a_journal(): void
    {
        $journal = Journals::create(['title' => 'Old Title', 'author' => 'Old Author', 'publish_date' => '2024-01-01', 'abstract' => 'Old Abstract']);

        $data = [
            'title' => 'Updated Title',
            'author' => 'Updated Author',
            'publish_date' => '2024-01-01',
            'abstract' => 'Updated abstract.',
        ];

        $response = $this->putJson("/api/journals/{$journal->id}", $data);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Journal updated successfully',
                 ]);

        $this->assertDatabaseHas('journals', $data);
    }

    /**
     * Test updating a nonexistent journal returns 404.
     */
    public function test_it_returns_404_when_updating_nonexistent_journal(): void
    {
        $response = $this->putJson('/api/journals/9999', [
            'title' => 'Updated Title',
            'author' => 'Updated Author',
            'publish_date' => '2024-01-01',
            'abstract' => 'Updated abstract.',
        ]);

        $response->assertStatus(404)
                 ->assertJson([
                     'success' => false,
                     'message' => 'Journal not found',
                 ]);
    }

    /**
     * Test deleting a journal.
     */
    public function test_it_can_delete_a_journal(): void
    {
        $journal = Journals::create(['title' => 'Journal Title', 'author' => 'Author', 'publish_date' => '2024-01-01', 'abstract' => 'Abstract']);

        $response = $this->deleteJson("/api/journals/{$journal->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Journal deleted successfully',
                 ]);

        $this->assertDatabaseMissing('journals', ['id' => $journal->id]);
    }

    /**
     * Test deleting a nonexistent journal returns 404.
     */
    public function test_it_returns_404_when_deleting_nonexistent_journal(): void
    {
        $response = $this->deleteJson('/api/journals/9999');

        $response->assertStatus(404)
                 ->assertJson([
                     'success' => false,
                     'message' => 'Journal not found',
                 ]);
    }
}
