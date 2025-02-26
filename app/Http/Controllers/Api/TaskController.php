<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Response;

class TaskController extends Controller
{

    public function index()
    {
        return TaskResource::collection(Task::all());
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
