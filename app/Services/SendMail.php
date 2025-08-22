<?php
namespace App\Services;

use Illuminate\Support\Facades\Mail;
use App\Mail\SendTextMail;
use Exception;

class SendMail
{
    public function sendTextMail(string $correo, string $asunto, $data): void
    {
        try {
            Mail::to($correo)->send(new SendTextMail($asunto, $data));
        } catch (Exception $e) {
            throw new Exception('Error al enviar correo: ' . $e->getMessage());
        }
    }
}
