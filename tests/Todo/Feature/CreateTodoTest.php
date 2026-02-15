<?php declare(strict_types=1);

namespace Tests\Todo\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use Symfony\Component\HttpFoundation\Response;
use Tests\Todo\DataProviders\TodoCreateDataProvider;
use Tests\Todo\TodoTest;

class CreateTodoTest extends TodoTest
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createAuthenticatedUser();
    }

    private function send(array $payload): TestResponse
    {
        return $this->postJson(static::API_BASE_URL, $payload);
    }

    public function test_create_todo_successfully(): void
    {
        $payload = [
            'title' => 'Test todo',
            'description' => 'Some description',
        ];

        $response = $this->send($payload);

        $response
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonFragment([
                'title' => 'Test todo',
                'description' => 'Some description',
                'completed' => false,
            ]);

        $this->assertDatabaseHas('todos', [
            'title' => 'Test todo',
            'description' => 'Some description',
            'completed' => false,
            'user_id' => $this->user->id,
        ]);
    }

    #[DataProviderExternal(TodoCreateDataProvider::class, 'invalidTodoPayloadProvider')]
    public function test_fail_when_validation_fails(array $payload): void
    {
        $response = $this->send($payload);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['title']);
    }
}
