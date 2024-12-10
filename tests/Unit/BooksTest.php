<?php

namespace Tests\Unit;

use App\Models\Books;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;

class BooksTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test fetching all books.
     */
    public function test_it_can_fetch_all_books(): void
    {
        // Buat data manual
        Books::create([
            'title' => 'Book One',
            'author' => 'Author One',
            'publisher' => 'Publisher One',
            'year' => 2023,
            'type' => 'book',
        ]);

        Books::create([
            'title' => 'Book Two',
            'author' => 'Author Two',
            'publisher' => 'Publisher Two',
            'year' => 2022,
            'type' => 'ebook',
        ]);

        $response = $this->getJson('/api/books');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'data' => [
                         '*' => ['id', 'title', 'author', 'publisher', 'year', 'type', 'created_at', 'updated_at'],
                     ],
                 ]);
    }

    /**
     * Test fetching a single book.
     */
    public function test_it_can_fetch_a_single_book(): void
    {
        $book = Books::create([
            'title' => 'Book One',
            'author' => 'Author One',
            'publisher' => 'Publisher One',
            'year' => 2023,
            'type' => 'book',
        ]);

        $response = $this->getJson("/api/books/{$book->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'data' => [
                         'id' => $book->id,
                         'title' => 'Book One',
                     ],
                 ]);
    }

    /**
     * Test fetching a nonexistent book returns 404.
     */
    public function test_it_returns_404_for_nonexistent_book(): void
    {
        $response = $this->getJson('/api/books/9999');

        $response->assertStatus(404)
                 ->assertJson([
                     'success' => false,
                     'message' => 'Book not found',
                 ]);
    }

    /**
     * Test creating a book.
     */
    public function test_it_can_create_a_book(): void
    {
        $data = [
            'title' => 'New Book',
            'author' => 'John Doe',
            'publisher' => 'Tech Press',
            'year' => 2023,
            'type' => 'book',
        ];

        $response = $this->postJson('/api/books', $data);

        $response->assertStatus(201)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Book created successfully',
                 ]);

        $this->assertDatabaseHas('books', $data);
    }

    /**
     * Test validation for required fields when creating a book.
     */
    public function test_it_validates_required_fields_when_creating_a_book(): void
    {
        $response = $this->postJson('/api/books', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['title', 'author', 'publisher', 'year', 'type']);
    }

    /**
     * Test updating a book.
     */
    public function test_it_can_update_a_book(): void
    {
        $book = Books::create([
            'title' => 'Original Title',
            'author' => 'Original Author',
            'publisher' => 'Original Publisher',
            'year' => 2022,
            'type' => 'book',
        ]);

        $data = [
            'title' => 'Updated Title',
            'author' => 'Updated Author',
            'publisher' => 'Updated Publisher',
            'year' => 2023,
            'type' => 'ebook',
        ];

        $response = $this->putJson("/api/books/{$book->id}", $data);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Book updated successfully',
                 ]);

        $this->assertDatabaseHas('books', $data);
    }

    /**
     * Test updating a nonexistent book returns 404.
     */
    public function test_it_returns_404_when_updating_nonexistent_book(): void
    {
        $response = $this->putJson('/api/books/9999', [
            'title' => 'Updated Title',
            'author' => 'Updated Author',
            'publisher' => 'Updated Publisher',
            'year' => 2023,
            'type' => 'ebook',
        ]);

        $response->assertStatus(404)
                 ->assertJson([
                     'success' => false,
                     'message' => 'Book not found',
                 ]);
    }

    /**
     * Test deleting a book.
     */
    public function test_it_can_delete_a_book(): void
    {
        $book = Books::create([
            'title' => 'Book to Delete',
            'author' => 'Author',
            'publisher' => 'Publisher',
            'year' => 2023,
            'type' => 'book',
        ]);

        $response = $this->deleteJson("/api/books/{$book->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Book deleted successfully',
                 ]);

        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }

    /**
     * Test deleting a nonexistent book returns 404.
     */
    public function test_it_returns_404_when_deleting_nonexistent_book(): void
    {
        $response = $this->deleteJson('/api/books/9999');

        $response->assertStatus(404)
                 ->assertJson([
                     'success' => false,
                     'message' => 'Book not found',
                 ]);
    }
}
