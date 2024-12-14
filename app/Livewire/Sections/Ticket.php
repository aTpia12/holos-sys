<?php

namespace App\Livewire\Sections;

use Livewire\Component;
use App\Models\Sale as TicketModel;
use App\Models\User as UserModel;
use App\Mail\TicketMailable;
use Illuminate\Support\Facades\Mail;

class Ticket extends Component
{
    public $ticketData;
    public $ticketId; // Propiedad para almacenar el ID del ticket

    public function mount($id = null) // Captura el ID opcional
    {
        $this->ticketId = $id; // Asigna el ID a la propiedad
        
        $data = $this->getTicketData($id);
        
        $cartData = $data->cart;
        
        $cartData = mb_convert_encoding($cartData, 'UTF-8', 'UTF-8');

        // Decodificar JSON y manejar posibles errores
        $products = json_decode($cartData, true);

        $this->ticketData = [
                'name' => $data->user->name,
                'email' => $data->user->email,
                'products' => json_decode($data->cart, false),
                'subtotal' => $data->subtotal,
                'iva' => $data->iva,
                'total' => $data->total,
                'date' => $data->created_at,
            ];

            // Guardar en sesiÃ³n
            session(['ticketData' => $this->ticketData]);
    }

    public function render()
    {
        return view('livewire.sections.ticket');
    }

    private function getTicketData($id)
    {
        
        return TicketModel::where('id', $id)->first(); 
    }
    
    public function sendTicketEmail()
    {
    
        //dd($this->ticketData);
        $email = $this->getUserEmail();
    

        // Enviar el correo electr¨®nico
        $sendEmail = Mail::to($email)->send(new TicketMailable($this->ticketData));

      return redirect()->route('ticket', $this->ticketId); 
    }
    
    public function getUserEmail()
    {
        return $this->ticketData['email'] ? $this->ticketData['email'] : null; // Devuelve el correo del usuario
    }
}
