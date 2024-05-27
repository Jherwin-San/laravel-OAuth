<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use App\Http\Requests\StoreTasksRequest;
use App\Http\Requests\UpdateTasksRequest;
use App\Http\Resources\TaskResource;
use App\Http\Resources\TaskCollection;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new TaskCollection(Tasks::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTasksRequest $request)
    {
        // Retrieve authenticated user
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        // Get validated data
        $validatedData = $request->validated();

        // Add user_id to validated data
        $validatedData['user_id'] = $user->id;

        // Store data in the database
        $task = Tasks::create($validatedData);

        // Return response
        return response()->json([
            'message' => 'Created Successfully',
            'data' => new TaskResource($task),
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Tasks $tasks)
    {
        return new TaskResource($tasks);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTasksRequest $request, $id, Tasks $tasks)
    {
        // Find the task by ID
        $task = Tasks::find($id);

        // Check if the task exists
        if (!$task) {
            return response()->json([
                'message' => "Task not found",
            ], 404);
        }

        // Update the task with validated data from the request
        $task->update($request->validated());

        // Return a JSON response with a success message and the updated task data
        return response()->json([
            'message' => "Updated successfully",
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tasks $tasks, $id)
    {
        // Find the task by ID
        $task = Tasks::find($id);

        // Check if the task exists
        if (!$task) {
            return response()->json([
                'message' => "Task not found",
            ], 404);
        }


        $task->delete();
        return response()->json([
            "message" => "Successfully Deleted",
        ]);
    }
}
