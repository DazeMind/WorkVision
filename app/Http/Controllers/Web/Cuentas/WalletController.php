<?php

namespace App\Http\Controllers\Web\Cuentas;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use App\Models\SubCategory;
use App\Models\Wallet;
use App\Models\WalletType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WalletController extends Controller
{
    public function index()
    {   
        $client = Client::where('id_user',auth()->id())->first();        
        $walletTypes = WalletType::all(); $wallets = Wallet::where('id_client',$client->id)->get();
        $userRoles = auth()->user()->getRoleNames();

        return Inertia::render('Cuentas/Wallet/IndexWallet', ['userRoles' => $userRoles, 'walletTypes' => $walletTypes, 'wallets' => $wallets]);
    }
 
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $client = Client::where('id_user', auth()->id())->first();
            $validatedData = $request->validate([
                'formData.walletTypes' => 'required| ',
                'formData.name' => 'required|string|min:3',
                'formData.amount' => 'required|integer',
                'formData.numberAccount' => '',
                'formData.color' => 'required',
            ]);
            $wallet = Wallet::create([
                'id_client' => $client->id,
                'id_type' => $validatedData['formData']['walletTypes'],
                'name' => $validatedData['formData']['name'],
                'amount' => $validatedData['formData']['amount'],
                'currency' => 'CLP',
                'number_account' => $validatedData['formData']['numberAccount'],
                'color' => $validatedData['formData']['color'],
                'id_state' => 1,
            ]);
            $wallet->save();
        } catch (\Throwable $th) {
            error_log($th);
        }
        
        return ;
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
        try {
            $wallet = Wallet::findOrFail($id);
            $wallet->delete();
        } catch (\Throwable $th) {
            error_log($th);
        }
        return;
    }
}
