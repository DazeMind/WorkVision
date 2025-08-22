<?php

namespace App\Http\Controllers\Web\Proyect;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
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
        $workerIds = $request->input('workerIds');
        $projectId = $request->input('proyectId');
        foreach ($workerIds as $workerid) {
            $attendance = Attendance::create([
                'id_worker' => $workerid,
                'id_project'  => $projectId,
                'date'  => date('Y-m-d'),
                'id_state'  => 1, //Activo
                'hours_worked'  => 8, //Horas por defecto
                'notes'  => 'Asistido',
            ]);
            error_log($workerid);
        }
        return redirect()->route('proyect.show',$projectId)->with('success', 'Colaborador actualizado correctamente.');
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
        //
    }
}
