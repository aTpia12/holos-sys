<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function show()
    {
        // Recuperar los datos del ticket desde la sesión
        $ticketData = session('ticketData');

        return view('livewire.sections.ticket', compact('ticketData'));
    }
}