<?php

namespace App\Http\Controllers\Web\Company;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Company;
use App\Models\Wallet;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $type = $request->isOrdersMode ? 'orders/sales' : 'Projects';
        $client = Client::where('id_user',$user->id)->first();
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255|unique:companies,name',
                'email' => 'nullable|string|email|max:255',
                'phone' => 'required|integer|max:999999999',
                'address' => 'required|string|max:255',
                'rut' => 'required|string|max:11|unique:companies,rut',
                'creation_date' => 'required|date',
            ]);

            $company = Company::Create([
                'id_client' => $client->id,
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'],
                'address' => $validatedData['address'],
                'rut' => $validatedData['rut'],
                'type' => $type,
                'creation_date' => $validatedData['creation_date'],
                'id_state' => 1, //Activo
            ]);

            $walletCompany = Wallet::Create([
                'id_client' => $client->id,
                'id_type' => 1, //General
                'name' => $validatedData['name'],
                'amount' => 0, // 0 cuenta nueva
                'currency' => 'CLP',
                'number_account' => null,
                'color' => '#cfcece',
                'id_state' => 1,
            ]);
            $walletCompany->save();

            return to_route('profile.edit')
                ->with('flash.message', 'Empresa creada exitosamente.')
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

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
