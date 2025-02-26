<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{

    public function index(Request $request)
    {
        $query = Task::query();

        if ($request->has('status')) {
            $query->where('status', $request->query('status'));
        }

        if ($request->has('sort_order')) {
            $sortOrder = $request->query('sort_order', 'asc');
            $query->orderBy('created_at', $sortOrder);
        }
        $tasks = $query->get();

        return TaskResource::collection($tasks);
    }

    public function store(TaskStoreRequest $request)
    {
        $created_task = Task::create($request->validated());

        return new TaskResource($created_task);
    }

    public function show(Task $task)
    {
        return new TaskResource($task);
    }

    public function update(TaskStoreRequest $request,Task $task)
    {
        $task->update($request->validated());

        return new TaskResource($task);
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
