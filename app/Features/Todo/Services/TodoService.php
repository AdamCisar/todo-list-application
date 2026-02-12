<?php

declare(strict_types=1);

namespace App\Features\Todo\Services;

use App\Features\Todo\Models\Todo;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TodoService
{
    public function create(array $data): Todo
    {
        return auth()->user()->todos()->create($data);
    }

    public function getAll(int $perPage = 5): LengthAwarePaginator
    { 
        return auth()->user()->todos()->latest()->paginate($perPage); 
    }
}
