<?php

namespace App\Http\Controllers\Web\Proyect;

use App\Http\Controllers\Controller;
use App\Http\Requests\Proyect\ProyectStoreRequest;
use App\Models\Client;
use App\Models\Companies_projects;
use App\Models\Company;
use App\Models\Project;
use App\Models\State;
use App\Models\Task;
use App\Models\TaskPriority;
use App\Models\Wallet;
use App\Models\WorkersProjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ProyectController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('dueño')) {
            $client = Client::where('id_user', $user->id)->first();
            $companies = Company::where('id_client', $client->id)->with(['workers', 'projects.state'])->get();
        } else if($user->hasRole('SuperAdmin')){
            $companies = Company::with(['workers', 'projects'])->get();
        }

        return Inertia::render('Proyects/IndexProyect', [
            'companies' => $companies,
            'user' => $user,
        ]);
    }

    public function create()
    {
        $user = Auth::user();
        if ($user->hasRole('dueño')) {
            $client = Client::where('id_user', $user->id)->first();
            $companies = Company::where('id_client', $client->id)->with('workers')->get();
        } else if($user->hasRole('SuperAdmin')){
            $companies = Company::with('workers')->get();      
        }
        return Inertia::render('Proyects/CreateProyect', [
            'companies' => $companies,
            'user' => $user,
            'states' => State::all(),
        ]);
    }

    public function store(ProyectStoreRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {                
                $proyect = Project::create([
                    'name' => $request['name'],
                    'description' => $request['description'],
                    'start_date' => $request['start_date'],
                    'end_date' => $request['end_date'],
                    'value' => $request['value'],
                    'budget' => $request['budget'],
                    'address' => $request['address'],
                    'status' => $request['status'],
                    'id_state' => 5, //en proceso
                ]);
                
                Companies_projects::create([
                    'id_project' => $proyect->id,
                    'id_company' => $request['id_company'],
                    'id_state' => 5
                ]);

                $client = Client::where('id_user', auth()->id())->first();
                Wallet::create([
                    'id_client' => $client->id,
                    'id_type' => 13, //cuenta para proyecto
                    'name' => $request['name'], //nombre del proyecto
                    'amount' => 0, //montos a rellenar
                    'currency' => 'CLP',
                    'number_account' => null,
                    'color' =>  '#15e1e5', //Celeste predefinido
                    'id_state' => 1,
                ]);
            });
               return to_route('proyect.index')
                ->with('title', 'Éxito')
                ->with('message', 'Proyecto creado exitosamente.')
                ->with('type', 'success');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $th) {
            error_log($th); 
            return back()->with('flash.message', 'Ocurrió un error inesperado. Inténtalo de nuevo.')->with('flash.type', 'error');
        }
        
    }

    public function show(string $id)
    {
        $project = Project::findOrFail($id);
        $user = Auth::user();

        $tasks = Task::where('id_project',$id)->with('state','priority')->get();

        $workers_project = WorkersProjects::where('id_project', $id)->with(['worker.attendance' => function ($query) use ($id) { $query->where('id_project', $id); }])->get();
        
        if ($user->hasRole('dueño')) {
            $client = Client::where('id_user', $user->id)->first();
            $companies = Company::where('id_client', $client->id)->with('workers.state')->get();
        } else {
            $companies = Company::with('workers.state')->get();      
        }
        $workerProjectIds = $workers_project->pluck('worker.id')->toArray();
        $allWorkers = $companies->flatMap(function ($company) use ($workerProjectIds) {
            return $company->workers->filter(function ($worker) use ($workerProjectIds) {
                return !in_array($worker->id, $workerProjectIds);
            });
        })->all();
        $wallet = Wallet::all();
        return Inertia::render('Proyects/ShowProyect', [
            'project' => $project,
            'workers_project' => $workers_project,
            'companies' => $companies,
            'user' => $user,
            'allWorkers' => $allWorkers,
            'tasks' => $tasks,
            'taskpriorities' => TaskPriority::all(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $project = Project::with('companies')->findOrFail($id);

        $user = Auth::user();
        if ($user->hasRole('dueño')) {
            $client = Client::where('id_user', $user->id)->first();
            $companies = Company::where('id_client', $client->id)->with('workers')->get();
        } else {
            $companies = Company::with('workers')->get();      
        }
        return Inertia::render('Proyects/EditProyect', [
            'project' => $project,
            'companies' => $companies,
            'user' => $user,
        ]);
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
        try {
            $project = Project::FindOrFail($id);
            $wallet = Wallet::where('name',$project->name)->first();
            $wallet->delete();
            $project->delete();

             return to_route('proyect.index')
                ->with('title', 'Éxito')
                ->with('message', 'Proyecto eliminado exitosamente.')
                ->with('type', 'danger');
        } catch (\Throwable $th) {
            error_log($th);
        }
    }
}
