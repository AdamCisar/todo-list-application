<?php declare(strict_types=1);

namespace Tests\Todo\Unit;

use App\Features\Todo\Exceptions\TodoCreateException;
use App\Features\Todo\Repositories\TodoRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use Tests\Todo\DataProviders\TodoCreateDataProvider;
use Tests\TestCase;

class TodoRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createAuthenticatedUser();
        $this->repository = app(TodoRepository::class);
    }

    public function test_create_todo(): void
    {
        $todo = $this->repository->create([
            'title' => 'Test Todo',
            'completed' => false,
        ]);

        $this->assertDatabaseHas('todos', [
            'id' => $todo->id,
            'title' => 'Test Todo',
            'completed' => false,
        ]);
    }

    #[DataProviderExternal(TodoCreateDataProvider::class, 'invalidTodoPayloadProvider')]
    public function test_create_todo_throws_exception_on_failure(array $payload): void
    {
        $this->expectException(TodoCreateException::class);

        $this->repository->create($payload);
    }
}
