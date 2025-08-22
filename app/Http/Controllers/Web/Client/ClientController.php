<?php

namespace App\Http\Controllers\Web\Client;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SendMailController;
use App\Models\Client;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Services\SendMail as ServicesSendMail;

class ClientController extends Controller
{
    protected $mailService;

    public function __construct(ServicesSendMail $mailService)
    {
        $this->mailService = $mailService;
    }


    public function index()
    {
        //
    }

    public function create()
    {
        $user = auth()->user();
        return Inertia::render('Client/Create', [ 'user' => $user ]);
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'rut' => 'required|string|max:11|unique:clients,rut',
                'address' => 'nullable|string|max:255',
                'phone' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:clients,email',
            ]);

            $client = Client::Create([
                'id_user' => $user->id,
                'full_name' => $validatedData['name'],
                'rut' => $validatedData['rut'],
                'address' => $validatedData['address'],
                'phone' => $validatedData['phone'],
                'email' => $validatedData['email'],
                'membership' => 'UNDEFINED',
                'id_state' => 5, //en proceso
            ]);
            $user->assignRole('dueño');

            // $profileUrl = config('app.url') . '/profile'; // Mejor práctica

            // $this->mailService->sendTextMail($client->email, 'Has creado tu cuenta en WorkVision', "Has creado tu cuenta de forma exitosa, visita nuestra pagina para mas información {$profileUrl}");

            return to_route('profile.edit')
                ->with('flash.message', 'Cliente creado exitosamente.')
                ->with('flash.type', 'success');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $th) {
            error_log($th); 
            return back()->with('flash.message', 'Ocurrió un error inesperado. Inténtalo de nuevo.')->with('flash.type', 'error');
        }
    }


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
