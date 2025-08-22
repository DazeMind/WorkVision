<?php

namespace App\Http\Controllers\Web\Bank;

use App\Http\Controllers\Controller;
use App\Models\BankData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class BankDataController extends Controller
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
        try {
            $bankData = BankData::updateOrCreate(
                ['id_client' => $request->id_client],
                [
                    'id_bank' => $request->id_bank,
                    'id_bank_account_type' => $request->id_bank_account_type,
                    'account_number' => $request->account_number,
                    'id_state' => 1, // Activo
                ]
            );
        } catch (\Throwable $th) {
            error_log($th);
        }
        return Redirect::route('profile.edit');
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
