<?php declare(strict_types=1);

namespace App\Features\Todo\Controllers;

use App\Features\Todo\Requests\TodoRequest;
use App\Features\Todo\Resources\TodoResourceCollection;
use App\Features\Todo\Services\TodoService;
use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

class TodoController extends Controller
{
    public function __construct(
        private TodoService $service
    ) {}

    public function index(TodoRequest $request): JsonResponse
    {
        $todos = $this->service->getAll($request->validated());

        return TodoResourceCollection::make($todos)->withSuccess('Todos retrieved successfully.');
    }

    public function store(TodoRequest $request): JsonResponse
    {
        $todo = $this->service->create($request->validated());

        return TodoResourceCollection::make(collect([$todo]))->withCreated('Todo created successfully.');
    }

    public function show(int $id): JsonResponse
    {
        $todo = $this->service->get($id);

        return TodoResourceCollection::make(collect([$todo]))->withSuccess('Todo retrieved successfully.');
    }

    public function update(TodoRequest $request, int $id): JsonResponse
    {
        $todo = $this->service->update($id, $request->validated());

        return TodoResourceCollection::make(collect([$todo]))->withSuccess('Todo updated successfully.');
    }

    public function destroy(int $id): JsonResponse
    {
        $this->service->delete($id);

        return ApiResponse::success('Todo deleted successfully.', null);
    }

    public function toggle(int $id): JsonResponse
    {
        $todo = $this->service->toggle($id);

        return TodoResourceCollection::make(collect([$todo]))->withSuccess('Todo toggled successfully.');
    }

    public function stats(): JsonResponse
    {
        $stats = $this->service->stats();

        return ApiResponse::success('Todo stats retrieved successfully.', $stats);
    }
}
