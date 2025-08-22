<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Company;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $client = Client::where('id_user',$userId)->first();
        $wallets = Wallet::where('id_client', $client->id)->get();
        
        $companies = Company::where('id_client', $client->id)->with(['workers', 'projects.state','orders.orderDeliveries','orders.orderDetails.product','orders.state','orders.consumer'])->get();

        // Calcula la suma de los amounts de los incomes
        $totalIncome = $wallets->flatMap(function ($wallet) {
            return $wallet->records->where('type', 'income')->pluck('amount');
        })->sum();
    
        $totalExpenses = $wallets->flatMap(function ($wallet) {
            return $wallet->records->where('type', 'expense')->pluck('amount');
        })->sum();
        
        $userRoles = auth()->user()->getRoleNames();
        return Inertia::render('Dashboard', [
            'userRoles' => $userRoles,
            'wallet' => $wallets,
            'totalIncome' => $totalIncome,
            'totalExpenses' => $totalExpenses,
            'companies' => $companies,
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
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
