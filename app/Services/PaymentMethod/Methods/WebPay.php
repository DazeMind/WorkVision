<?php
namespace App\Services\Metodos;

use App\Services\Methods;

class WebPay implements Methods
{
    public function procesar(float $monto)
    {
        // Lógica real para procesar el pago con WebPay
        // Por ejemplo, llamar a API, validar respuesta, etc.
        return "Procesando pago de $monto con WebPay";
    }
}