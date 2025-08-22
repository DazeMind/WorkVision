<?php

namespace App\Http\Controllers\Web\Cuentas;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use App\Models\Record;
use App\Models\ScheduleRecord;
use App\Models\SubCategory;
use App\Models\Wallet;
use App\Models\WalletType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GestorCuentasController extends Controller
{
    public function index()
    {
        $user =  auth()->user();
        $client = Client::where('id_user',$user->id)->first();
        $categories = Category::whereNull('id_client')->orWhere('id_client', $client->id)->get();        
        $sub_categories = SubCategory::all();

        $walletIds = Wallet::where('id_client', $client->id)->pluck('id'); // Extraer solo los IDs
        $registros = Record::whereNull('deleted_at')->with('category', 'wallet')->whereIn('id_wallet',$walletIds)->get();
        $registrosIds = $registros->pluck('id');
        $userRoles = auth()->user()->getRoleNames();

        $ScheduleRecords = ScheduleRecord::with('record.wallet', 'record.category')->whereNull('deleted_at')->whereIn('id_record', $registrosIds)->get();
        return Inertia::render('Cuentas/Cuentas', [
            'userRoles' => $userRoles,
            'categories' => $categories,
            'sub_categories' => $sub_categories,
            'registros' => $registros,
            'walletTypes' => WalletType::all(),
            'programRecords' => $ScheduleRecords,
            // 'wallets' => Wallet::where('id_client', $client->id)->get(),
            'wallets' => Wallet::where('id_client', $client->id)->with('records')->get(),
        ]);
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
        //
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
