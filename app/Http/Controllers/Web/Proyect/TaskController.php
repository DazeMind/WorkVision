<?php

namespace App\Http\Controllers\Web\Proyect;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TasksState;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function show(string $id)
    {
        //
    }
    
    public function store(Request $request)
    {
        $task = Task::Create([
            'id_project' => $request->input('id_project'),
            'id_worker_project' => $request->input('id_worker_project'),
            'title'=> $request->input('title'),
            'description'=> $request->input('description') ,
            'id_task_priority' => $request->input('priority') ,
            'date' => $request->input('date'),
            'time'=> $request->input('time') ,
            'id_state'=> 3 , // Tarea por hacer
        ]);
        return redirect()->route('proyect.show',$request->input('id_project'))->with('success', 'Tarea Creada correctamente.');

    }

    public function tasksComplete(string $id)
    {
        $task = Task::findOrFail($id);
        if ($task->id_state != 1) {
            $task->update([
                'id_state' => 1,
            ]);
        }else{
            $task->update([
                'id_state' => 3,
            ]);
        }
    }


    public function updateState(Request $request, Task $task)
    {
        try {
            $taskState = TasksState::where('name',$request->state['name'])->first();
            $task->update([
                'id_state' => $taskState->id
            ]);
        } catch (\Throwable $th) {
            error_log($th);
        }

        // return redirect()->route('proyect.show',$request->input('id_project'))->with('success', 'Tarea Creada correctamente.');
        // return response()->json(['message' => 'Estado actualizado con éxito.']);
    }

    public function update(Request $request, Task $task)
    {
        try {
            $task->update([
                'id_worker_project' => $request->input('id_worker_project'),
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'id_task_priority' => $request->input('priority'),
                'time' => $request->input('time'),
                'date' => $request->input('date'),
                'id_state' => $request->input('id_state')
            ]);
        } catch (\Throwable $th) {
            error_log($th);
        }

        // return redirect()->route('proyect.show',$request->input('id_project'))->with('success', 'Tarea Creada correctamente.');
        // return response()->json(['message' => 'Estado actualizado con éxito.']);
    }

    public function destroy(string $id)
    {
        $task = Task::FindOrFail($id);
        try {
            $task->delete();
            return redirect()->route('proyect.show',$task->id_project)->with('success', 'Tarea Eliminada correctamente.');
        } catch (\Throwable $th) {
            return redirect()->route('proyect.show',$task->id_project)->with('danger', 'Error al eliminar tarea.');
        }
        
    }
}
