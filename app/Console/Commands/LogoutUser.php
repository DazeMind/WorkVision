<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LogoutUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logout:user {user_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cerrar la sesión de un usuario especificado por su ID';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $userId = $this->argument('user_id');  // Obtener el ID del usuario

        $user = User::find($userId);  // Buscar al usuario por su ID

        if ($user) {
            // Aquí cerramos la sesión de ese usuario
            Auth::logout();  // Cierra la sesión actual
            $this->info("Sesión cerrada para el usuario con ID: {$userId}");
        } else {
            $this->error("Usuario con ID {$userId} no encontrado.");
        }
    }
}
