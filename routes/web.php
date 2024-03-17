<?php

use App\Models\Task;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;


/**
 * Display All Tasks
 */
Route::get('/', function () {
    $tasks = Task::orderBy('created_at', 'asc')->get();
    return view('tasks', [
        'tasks' => $tasks
    ]);
});

/**
 * Add a New Task
 */
Route::post('/tasks', function(Request $request) {
    $validator = Validator::make($request->all(), [
        'name' => 'required|max:255'
    ]);

    if($validator->fails()) {
        return redirect('/')
            ->withInput()
            ->withErrors($validator);
    }

    // Create task
    $task = new Task;
    $task->name = $request->name;
    $task->save();

    return redirect('/');
});

/**
 * Delete a Task
 */
Route::delete('/tasks/{id}', function($id) {
    Task::findOrFail($id)->delete();

    return redirect('/');
});
