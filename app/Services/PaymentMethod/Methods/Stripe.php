<?php
namespace App\Services\Metodos;

use App\Services\Methods;

class Stripe implements Methods
{
    public function procesar(float $monto)
    {
        // Lógica para procesar pago con Stripe
        return "Procesando pago de $monto con Stripe";
    }
}