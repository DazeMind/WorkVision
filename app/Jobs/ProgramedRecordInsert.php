<?php

namespace App\Jobs;

use App\Models\Record;
use App\Models\ScheduleRecord;
use App\Models\Wallet;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProgramedRecordInsert implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $day = date('j');
        Log::info('Se está ejecutando el Job ProgramedRecordInsert para el día ' . $day . '.');
        
        $programedRecords = ScheduleRecord::where('DOTM' ,'=', $day)->whereNull('deleted_at')->get();

        foreach ($programedRecords as $programedRecord) {
            $type = $programedRecord->type == 1 ? 'income' : ($programedRecord->type == 2 ? 'expense' : null);
            $record = Record::findOrFail($programedRecord->id_firstRecord);
            // $recordExist = $table::where()->first()
            $newRecord = Record::create([
                'id_wallet' => $record->id_wallet,
                'id_category' => $record->id_category,
                'amount' => $record->amount,
                'description' => 'Registro Programado '. $record->description ?? null,
                'date' => date('Y-m-d'),
                'document' => null,
                'type' => $type,
            ]);

            $wallet = Wallet::findOrFail($record->id_wallet);

            $currentAmount = $programedRecord->type == 1 ? $wallet->amount + $newRecord->amount : $wallet->amount - $newRecord->amount;

            $wallet->update([ 'amount' => $currentAmount, ]);
            
        }
    }
}
#Registro -> ScheduleRecordSaves ->schedule registro#