<?php

declare(strict_types=1);

namespace App\Features\Todo\Services;

use App\Features\Todo\Exceptions\TodoCreateException;
use App\Features\Todo\Exceptions\TodoNotFoundException;
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

    public function getAll(int $perPage = 5): LengthAwarePaginator
    { 
        return auth()->user()->todos()->latest()->paginate($perPage); 
    }

    public function get(int $id): Todo 
    { 
        $todo = auth()->user()->todos()->find($id);
        
        if (!$todo) {
            throw new TodoNotFoundException();
        }
        
        return $todo;
    }
}
