<?php declare(strict_types=1);

namespace App\Features\Todo\Repositories;

use App\Features\Todo\Exceptions\TodoCreateException;
use App\Features\Todo\Exceptions\TodoDeleteException;
use App\Features\Todo\Exceptions\TodoNotFoundException;
use App\Features\Todo\Exceptions\TodoUpdateException;
use App\Features\Todo\Models\Todo;
use App\Features\User\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class TodoRepository
{
    private User $currentUser;

    public function __construct(
        private Todo $todo,
    ) {
        $this->currentUser = Auth::user();
    }

    public function create(array $data): Todo
    {
        try {
            $todo = $this->currentUser->todos()->create($data);
        } catch (QueryException $e) {
            throw new TodoCreateException();
        }

        return $todo;
    }

    public function getAll($filters = []): LengthAwarePaginator
    {
        return $this
            ->todo
            ->when($filters['status'] ?? null, fn($q, $status) => $q->where($status, true))
            ->latest()
            ->paginate($filters['per_page'] ?? 5);
    }

    public function get(int $id): Todo
    {
        $todo = $this->todo->find($id);

        if (!$todo) {
            throw new TodoNotFoundException();
        }

        return $todo;
    }

    public function update(int $id, array $data): Todo
    {
        if (empty($data)) {
            throw new TodoUpdateException('No data provided for update.');
        }

        $todo = $this->get($id);

        $isUpdated = $todo->update($data);

        if (!$isUpdated) {
            throw new TodoUpdateException();
        }

        return $todo;
    }

    public function delete(int $id): bool
    {
        $todo = $this->get($id);

        $isDeleted = $todo->delete();

        if (!$isDeleted) {
            throw new TodoDeleteException();
        }

        return $isDeleted;
    }

    public function toggle(int $id): Todo
    {
        $todo = $this->get($id);

        $isUpdated = $todo->update(['completed' => !$todo->completed]);

        if (!$isUpdated) {
            throw new TodoUpdateException();
        }

        return $todo;
    }

    public function stats(): array
    {
        $total = $this->todo->count();
        $completed = $this->todo->where('completed', true)->count();

        return [
            'total' => $total,
            'completed' => $completed,
            'pending' => $total - $completed,
        ];
    }

    public function search(string $query): Collection
    {
        return $this
            ->todo
            ->where('title', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->limit(10)
            ->get();
    }
}
