<?php declare(strict_types=1);

namespace App\Features\Todo\Services;

use App\Features\Todo\Exceptions\TodoCreateException;
use App\Features\Todo\Exceptions\TodoDeleteException;
use App\Features\Todo\Exceptions\TodoNotFoundException;
use App\Features\Todo\Exceptions\TodoUpdateException;
use App\Features\Todo\Models\Todo;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\QueryException;

class TodoService
{
    public function create(array $data): Todo
    {
        try {
            $todo = auth()->user()->todos()->create($data);
        } catch (QueryException $e) {
            throw new TodoCreateException();
        }

        return $todo;
    }

    public function getAll($filters = []): LengthAwarePaginator
    {
        return auth()
            ->user()
            ->todos()
            ->when($filters['status'] ?? null, fn($q, $status) => $q->where($status, true))
            ->latest()
            ->paginate($filters['per_page'] ?? 5);
    }

    public function get(int $id): Todo
    {
        $todo = auth()->user()->todos()->find($id);

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
        $total = auth()->user()->todos()->count();
        $completed = auth()->user()->todos()->where('completed', true)->count();

        return [
            'total' => $total,
            'completed' => $completed,
            'pending' => $total - $completed,
        ];
    }
}
