<?php

namespace App\Http\Controllers\Web\Worker;

use App\Http\Controllers\Controller;
use App\Http\Requests\Worker\WorkerStoreRequest;
use App\Http\Requests\Worker\WorkerUpdateRequest;
use App\Models\Client;
use App\Models\Company;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Worker;
use App\Models\WorkerCompany;
use App\Models\WorkersProjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class WorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function create()
    {
        $user = Auth::user();
        if ($user->hasRole('dueño')) {
            $client = Client::where('id_user', $user->id)->first();
            $companies = Company::where('id_client', $client->id)->with('workers')->get();
        } else {
            $companies = Company::with('workers')->get();      
        }
        return Inertia::render('Workers/CreateWorkers', [
            'companies' => $companies,
            'user' => $user,
        ]); 
    }

    public function store(WorkerStoreRequest $request)
    {
        $userId = auth()->id();
        if (!$userId) {
            return;
        }
        $password = 12345678; // O utiliza un generador de contraseñas más seguro
        try {
            DB::beginTransaction();
            $newWorker = Worker::create([
                'first_name' => $request['first_name'],
                'second_name' => $request['second_name'],
                'first_last_name' => $request['first_last_name'],
                'second_last_name' => $request['second_last_name'],
                'rut' => $request['rut'],
                'email' => $request['email'],
                'phone' => $request['phone'],
                'address' => $request['address'],
                'date_of_birth' => $request['dob'],
                'afp' => $request['afp'],
                'health_plan'=> $request['health_plan'],
                'password' => bcrypt($password), // Encripta la contraseña
                'id_state' => 5, // Estado en proceso
            ]);
            
            WorkerCompany::create([
                'id_company' => $request['id_company'],
                'id_worker' => $newWorker->id,
                'id_state' => 1,
            ]);
            
            $nameUser = $request['first_name'].' '.$request['first_last_name'];
            $WorkerUser = User::create([
                'name' => $nameUser,
                'email' => $request['email'],
                'password' => Hash::make($password),
            ])->assignRole('Worker');

            //ENVIAR CORREO CON CONTRASEÑA AL USER

            DB::commit();
             return to_route('worker.create')
                ->with('title', 'Éxito')
                ->with('message', 'Colaborador creado exitosamente.')
                ->with('type', 'success');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $th) {
            DB::rollBack();
            error_log($th); 
            return back()->with('flash.message', 'Ocurrió un error inesperado. Inténtalo de nuevo.')->with('flash.type', 'error');
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {   
        $user = Auth::user();
        if ($user->hasRole('dueño')) {
            $client = Client::where('id_user', $user->id)->first();
            $companies = Company::where('id_client', $client->id)->with('workers')->get();
        } else {
            $companies = Company::with('workers')->get();      
        }
        $worker = Worker::findOrFail($id);

        return Inertia::render('Workers/EditWorker', [
            'worker' => $worker,
            'companies' => $companies,
        ]);
    }

    public function update(WorkerUpdateRequest $request, string $id)
    {
        try {
            $worker = Worker::findOrFail($id);
            $worker->update($request->validated());
        
            return redirect()->route('worker.create')->with('success', 'Colaborador actualizado correctamente.');
        } catch (\Throwable $th) {
            return redirect()->route('worker.edit',$id)->with('Danger', 'Error al intentar actualizar Colaborador.');
        }
        
    }

    public function destroy(string $id)
    {
        $worker = Worker::findOrFail($id);

        $workerCompany = WorkerCompany::where('id_worker', $id)->first();
        $workerProject = WorkersProjects::where('id_worker', $id)->first(); // ← Asumo que querías esto

        if ($workerProject) {
            $workerProject->delete();
        }

        if ($workerCompany) {
            $workerCompany->delete();
        }

        $worker->delete();

        return to_route('worker.create')->with('title', 'Éxito')
                ->with('message', 'Colaborador '.$worker->first_name.' '.$worker->first_last_name.' eliminado exitosamente.')
                ->with('type', 'danger');
    }
}
