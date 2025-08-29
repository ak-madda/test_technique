<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function projectTasks(Request $request, Project $project)
    {
        $this->authorize('view', $project);

        $tasks = $project->tasks()
            ->with('assignee')
            ->paginate(10);

        return new TaskCollection($tasks);
    }

    public function store(StoreTaskRequest $request, Project $project)
    {
        $this->authorize('update', $project);

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'priority' => $request->priority,
            'project_id' => $project->id,
            'assigned_to' => $request->assigned_to,
            'created_by' => $request->user()->id,
            'due_date' => $request->due_date,
        ]);

        return new TaskResource($task->load('assignee'));
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);

        $task->update($request->validated());

        return new TaskResource($task->load('assignee'));
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        return response()->json(null, 204);
    }

    public function updateStatus(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $request->validate([
            'status' => 'required|in:pending,in_progress,completed'
        ]);

        $task->update(['status' => $request->status]);

        return new TaskResource($task->load('assignee'));
    }
}