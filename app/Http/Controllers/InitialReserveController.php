<?php

namespace App\Http\Controllers;

use App\Mail\CredentialsUserMailable;
use App\Mail\NotificationAdminNewUserMailable;
use App\Models\User;
use App\Services\WhatsappService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class InitialReserveController extends Controller
{
    protected $whatsappService;
    public function __construct(WhatsappService $whatsappService)
    {
        $this->whatsappService = $whatsappService;
    }
    public function __invoke(Request $request)
    {
        $userExist = User::where('email', $request->input('email'))->first();

        if($userExist){
            return response()->json([
                'message' => 'El usuario ya existe en nuestro sistema.',
                'txt' => 'Porfavor ingresa en nuestra plataforma con tus datos de acceso!',
                'type' => 'error'
            ]);
        }
        else{

            $password = Str::random(8);

            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'password' => Hash::make($password),
            ]);

            Mail::to($user->email)->send(new CredentialsUserMailable($user, $password));
            Mail::to('mcamacho@echopoint.com.mx')->send(new NotificationAdminNewUserMailable($user));
            Mail::to('recepcion@holos-spa.com')->send(new NotificationAdminNewUserMailable($user));

            $this->whatsappService->send('525540052578', $user);
            $this->whatsappService->send('522285211115', $user);
            $this->whatsappService->send('525514520548', $user);

            return response()->json([
                'message' => 'Tu reservación se ha registrado con éxito.',
                'txt' => 'A la brevedad una persona de nuestro equipo se comunicará contigo',
                'type' => 'success'
            ]);
        }
    }
}
