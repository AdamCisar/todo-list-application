<?php

declare(strict_types=1);

namespace App\Features\Todo\Controllers;

use App\Features\Todo\Models\Todo;
use App\Features\Todo\Requests\TodoRequest;
use App\Features\Todo\Resources\TodoResourceCollection;
use App\Features\Todo\Services\TodoService;
use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TodoController extends Controller
{
    public function __construct(private TodoService $service) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TodoRequest $request): JsonResponse
    {
        $todo = $this->service->create($request->validated());

        return ApiResponse::success(
            'Todo created successfully.', 
            TodoResourceCollection::make(collect([$todo])), 
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Todo $todo)
    {
        //
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
