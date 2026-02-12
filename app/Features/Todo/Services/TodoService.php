<?php

declare(strict_types=1);

namespace App\Features\Todo\Services;

use App\Features\Todo\Models\Todo;

class TodoService
{
    public function create(array $data): Todo
    {
        return auth()->user()->todos()->create($data);
    }
}
