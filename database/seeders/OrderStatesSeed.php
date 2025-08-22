<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderStatesSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = [
            
            ['name' => 'Agendada','description' => 'Tiene una fecha y hora programada'],
            ['name' => 'En curso','description' => 'El trabajo o servicio ya comenzó.'],
            ['name' => 'Pendiente','description' => 'La orden fue creada pero aún no se ha procesado.'],
            ['name' => 'En camino','description' => 'Si es un servicio a domicilio o entrega.'],
            ['name' => 'Asignada','description' => 'Se ha designado a una persona o equipo para realizarla.'],
            ['name' => 'Entregada','description' => 'En caso de productos o servicios entregables.'],
            ['name' => 'Completada','description' => 'El trabajo fue realizado exitosamente.'],
            ['name' => 'Finalizada','description' => 'Equivalente a completada, depende del contexto.'],
            ['name' => 'En espera de confirmación','description' => 'Esperando aprobación o confirmación del cliente.'],
            ['name' => 'Cerrada','description' => 'Ya no requiere más acción, incluso si no fue completada con éxito.'],
            ['name' => 'Cancelada','description' => 'Fue anulada por el cliente o el proveedor.'],
            ['name' => 'Rechazada','description' => 'No fue aprobada o aceptada.'],
            ['name' => 'Suspendida','description' => 'Se pausó temporalmente.'],
            ['name' => 'Vencido','description' => 'No se ejecutó en el tiempo previsto.'],
            ['name' => 'Requiere intervención','description' => 'Se detuvo porque necesita acción adicional (firma, aprobación, stock, etc).'],
            ['name' => 'Fallida','description' => 'Hubo un intento pero no se completó con éxito.'],
        ];
        DB::table('order_states')->insert($states);
    }
}