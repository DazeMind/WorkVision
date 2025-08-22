<?php

namespace App\Http\Controllers\Finance;

use App\Exports\IncomeExpensesExcel;
use App\Http\Controllers\Controller;
use App\Jobs\ProgramedRecordInsert;
use App\Models\Record;
use App\Models\ScheduledExpense;
use App\Models\ScheduleRecord;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class FinanceController extends Controller
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
        //
    }

    public function incomeExpenseStore(Request $request)
    {
        $type = $request->input('type') == 1 ? 'income' : ($request->input('type') == 2 ? 'expense' : null);
        $register = Record::create([
            'id_wallet' => $request->wallet,
            'id_category' => $request->category,
            'amount' => $request->amount,
            'description' => $request->description ?? null,
            'date' => $request->date,
            'document' => null,
            'type' => $type,
        ]);
        $wallet = Wallet::findOrFail($request->wallet); 
        $currentAmount = $request->input('type') == 1 ? $wallet->amount + $request->amount : $wallet->amount - $request->amount;
        $wallet->update([
            'amount' => $currentAmount,
        ]);

        if (request()->hasFile('file')) {
            $request->validate([ 'file' => 'file|mimes:jpeg,png,jpg,pdf,jfif,webp',]);
            try {
                $file = $request->file('file');
                $fileName = $register->id_wallet . '_' . $register->id . '_' . $file->getClientOriginalName();
                $storagePath = $request->input('type') == 1  ? 'Incomes' : ($request->input('type') == 2 ? 'Expenses' : null);; //documentsIncomes documentsExpenses
                $pathRegister = $storagePath . '/' . $fileName;
                if ($register) {
                    $register->document = $pathRegister;
                    $register->save();
                } else {
                    return response()->json(['message' => 'No se encontró el registro proporcionado'], 404);
                }
                //REDUCIR PESO IMAGEN
                $path = $file->storeAs('public/' . $storagePath, $fileName);
            } catch (\Exception $e) {
                error_log($e);
                return response()->json(['message' => 'Error al cargar la imagen', 'error' => $e->getMessage()], 500);
            }
        }
        if ( $request->input('day')) {
            $this->programedRecord($register, $request->input('day'));
        }
        return;
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
    public function updateProgramRecord(Request $request, string $id){
        $scheduleRecord = ScheduleRecord::findOrFail($id);
        $data = $request->input('data');
        $record = Record::findOrFail($data['id']);
        DB::beginTransaction();
        try {
            $scheduleRecord->update([
                'DOTM' => $data['DOTM'],
                'id_record' => $data['id'],
                'next_execution' => $this->nextExecution($data['DOTM']),
                'id_state' => 1, // activo
            ]);
        
            $record->update([
                'id_wallet' => $data['wallet']['id'],
                'id_category' => $data['id_category'],
                'amount' => $data['amount'],
                'description' => $data['description'] ?? null,
                'date' => $data['date'],
                'document' => null,
                'type' => $data['type'],
            ]);
            DB::commit();
            session()->flash('title', 'Editado con éxitos');
            session()->flash('message', 'El Conductor ');
            session()->flash('type', 'success');

            return redirect()->route('Cuentas');
        } catch (\Exception $e) {
            error_log($e);
            DB::rollBack();
            Log::error('Error al actualizar registros programados: ' . $e->getMessage());
            
            // throw new \Exception('Hubo un error al actualizar los registros.');
        }
        
        return;
        
    }

    public function destroyProgramRecord(string $id)
    {
        try {
            // Obtener el registro a eliminar
            $ScheduleRecord = ScheduleRecord::findOrFail($id);
            // Eliminar el registro
            $ScheduleRecord->delete();
            return;
        } catch (\Exception $e) {
            return;
        }
    }
    public function destroy(string $id, Request $request)
    {
        try {
            // Obtener el registro a eliminar
            $record = Record::findOrFail($id);
            $wallet = Wallet::find($record->id_wallet); // Buscar la wallet asociada
            if ($record->shceduleRecord) { $record->shceduleRecord()->delete(); }
            if (!$wallet) {
                return response()->json(['error' => 'Wallet no encontrada'], 400);
            }
            // Actualizar el amount de la wallet según el tipo de registro
            if ($request->input('type') === 'income') {
                $wallet->amount -= $record->amount; // Restar si es ingreso
            } else {
                $wallet->amount += $record->amount; // Sumar si es gasto
            }
            // Guardar cambios en la wallet
            $wallet->save();
            // Eliminar el registro
            if ($record->document) {
                $rutaArchivo = 'public/' . $record->document;
            }
            try {
                Storage::delete($rutaArchivo);
            } catch (\Throwable $th) {
                error_log($th);
            }
            $record->update(['document' => null]);

            $record->delete();
            return;
        } catch (\Exception $e) {
            error_log($e);
            return;
        }




        
        
    }

    public function DownloadFilteredRecordsExcel(){
        return Excel::download(new IncomeExpensesExcel, 'Reporte_Finanzas.xlsx');
    }

    //FUNCIONES PRIVADAS

    private function programedRecord($register, $day){
        $scheduledExpenses = ScheduleRecord::Create([
            'DOTM' => $day,
            'id_record' => $register->id,
            'next_execution' =>$this->nextExecution($day),
            'id_state' => 1, //activo
        ]);

        Log::info('se creo un registro programado '.$scheduledExpenses->id);
    }

    private function nextExecution($day){
        $nextExecution = now()->addMonth()->day($day)->format('Y-m-d');
        return $nextExecution;
    }
}
