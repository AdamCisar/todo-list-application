<?php declare(strict_types=1);

namespace App\Features\Todo\Controllers;

use App\Features\Todo\Repositories\TodoRepository;
use App\Features\Todo\Requests\TodoRequest;
use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

class TodoController extends Controller
{
    public function __construct(
        private TodoRepository $repository
    ) {}

    public function index(TodoRequest $request): JsonResponse
    {
        $todos = $this->repository->getAll($request->validated());

        return $todos->toResourceCollection()->withSuccess('Todos retrieved successfully.');
    }

    public function store(TodoRequest $request): JsonResponse
    {
        $todo = $this->repository->create($request->validated());

        return $todo->toResource()->withCreated('Todo created successfully.');
    }

    public function show(int $id): JsonResponse
    {
        $todo = $this->repository->get($id);

        return $todo->toResource()->withSuccess('Todo retrieved successfully.');
    }

    public function update(TodoRequest $request, int $id): JsonResponse
    {
        $todo = $this->repository->update($id, $request->validated());

        return $todo->toResource()->withSuccess('Todo updated successfully.');
    }

    public function destroy(int $id): JsonResponse
    {
        $this->repository->delete($id);

        return ApiResponse::success('Todo deleted successfully.', null);
    }

    public function toggle(int $id): JsonResponse
    {
        $todo = $this->repository->toggle($id);

        return $todo->toResource()->withSuccess('Todo toggled successfully.');
    }

    public function stats(): JsonResponse
    {
        $stats = $this->repository->stats();

        return ApiResponse::success('Todo stats retrieved successfully.', $stats);
    }

    public function search(string $query): JsonResponse
    {
        $todos = $this->repository->search($query);

        return $todos->toResourceCollection()->withSuccess('Todo search results retrieved successfully.');
    }
}
