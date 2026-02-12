<?php

declare(strict_types=1);

namespace App\Features\Todo\Controllers;

use App\Features\Todo\Models\Todo;
use App\Features\Todo\Requests\TodoRequest;
use App\Features\Todo\Resources\TodoResourceCollection;
use App\Features\Todo\Services\TodoService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class TodoController extends Controller
{
    public function __construct(private TodoService $service) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $todos = $this->service->getAll(); 
   
        return TodoResourceCollection::make($todos)->withSuccess('Todos retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TodoRequest $request): JsonResponse
    {
        $todo = $this->service->create($request->validated());

        return TodoResourceCollection::make(collect([$todo]))->withCreated('Todo created successfully.');
    }

    /**
     * Display the specified resource.
     * 
     * Using scoped route model binding to bypass the global scope and retrieve the todo by its ID, regardless of the authenticated user.
     * This allows us to ensure that the todo exists and belongs to the authenticated user, while still adhering to the global scope defined in the model.
     * 
     */
    public function show(int $id)
    {
        $todo = $this->service->get($id);

        return TodoResourceCollection::make(collect([$todo]))->withSuccess('Todo retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Todo $todo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo)
    {
        //
    }
}
