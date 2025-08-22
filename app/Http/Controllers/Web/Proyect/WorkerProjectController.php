<?php

namespace App\Http\Controllers\Web\Proyect;

use App\Http\Controllers\Controller;
use App\Models\Worker;
use App\Models\WorkersProjects;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WorkerProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        foreach ($request->input('workerIds') as $worker_id) {
            $worker = Worker::findOrFail($worker_id);
            $worker->update(['id_state' => 2]); // Worker pasa a en uso
            $worker_proyect = WorkersProjects::Create([
                'id_project' => $request->input('proyectId'),
                'id_worker' => $worker_id,
                'role' => 'Colaborador',
                'id_state' => 1 //activo
            ]);

        }
        // return redirect()->route('proyect.show',$projectId)->with('success', 'Colaborador actualizado correctamente.');
        return redirect()->back()->with('success', 'Colaborador actualizado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $worker_proyect = WorkersProjects::findOrFail($id);
        $worker_proyect->delete();
        return redirect()->route('proyect.show',$worker_proyect->id_project)->with('success', 'Colaborador actualizado correctamente.');
    }
}
