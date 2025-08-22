<?php

namespace App\Exports;

use App\Models\Client;
use App\Models\Expense;
use App\Models\Incomes;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class IncomeExpensesExcel implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithTitle
{
    public function title(): string
    {
        return 'Registro Finanzas';
    }

    public function collection()
    {
        $user = Auth::user();
        if (!$user) { return collect(); }

        $client = Client::where('id_user', $user->id)->first();
        if (!$client) { return collect(); }

        $walletIds = Wallet::where('id_client', $client->id)->pluck('id');
        
        $expenses = Expense::whereIn('id_wallet', $walletIds)->with(['wallet', 'category'])
            ->get()
            ->map(function ($expense) {
                return [
                    'id' => $expense->id,
                    'client_id' => $expense->wallet->client->full_name ?? null,
                    'type' => 'Expense',
                    'name' => $expense->category->name ?? 'Sin categoría',
                    'amount' => $expense->amount,
                    'currency' => $expense->currency,
                    'wallet_name' => $expense->wallet->name ?? 'Sin billetera',
                    'created_at' => $expense->created_at->format('Y-m-d H:i:s'),
                ];
            });

        $incomes = Incomes::whereIn('id_wallet', $walletIds)->with(['wallet', 'category'])
            ->get()
            ->map(function ($income) {
                return [
                    'id' => $income->id,
                    'client_id' => $income->wallet->client->full_name ?? null,
                    'type' => 'Income',
                    'name' => $income->category->name ?? 'Sin categoría',
                    'amount' => $income->amount,
                    'currency' => $income->currency,
                    'wallet_name' => $income->wallet->name ?? 'Sin billetera',
                    'created_at' => $income->created_at->format('Y-m-d H:i:s'),
                ];
            });

            $registros = array_merge($expenses->toArray(), $incomes->toArray());
    
            return new Collection($registros); // Retorna una colección de arrays
    }

    public function headings(): array
    {
        return [
            'ID',
            'ID Cliente',
            'Tipo', // Income o Expense
            'Categoría',
            'Monto',
            'Moneda',
            'Billetera',
            'Fecha de Creación',
        ];
    }

    public function map($record): array
    {
        return [
            $record['id'],
            $record['client_id'],
            $record['type'],
            $record['name'],
            $record['amount'],
            $record['currency'],
            $record['wallet_name'],
            $record['created_at'],
        ];
    }
}
