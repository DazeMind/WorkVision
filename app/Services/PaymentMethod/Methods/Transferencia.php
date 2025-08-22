<?php
namespace App\Services\Metodos;

use App\Services\Methods;

class Transferencia implements Methods
{
    public function procesar(float $monto)
    {
        // Lógica para pago por transferencia bancaria
        return "Procesando pago de $monto por transferencia bancaria";
    }
}
