<?php

namespace App\Livewire\Sections;

use Livewire\Component;
use App\Models\Product as ProductModel;
use App\Models\User as UserModel;
use App\Models\Sale as SaleModel;
use App\Mail\TicketMailable;
use Illuminate\Support\Facades\Mail;

class Pos extends Component
{
    public $search = '';
    public $cart = [];
    public $total = 0;
    public $subtotal = 0;
    public $iva = 0;
    public $ivaRate = 0.16; // 16% de IVA
    public $paymentType;
    public $products = [];

    public $userSearch = '';
    public $users = [];
    public $selectedUser = null;
    
    public $newUserName = '';
    public $newUserPhone = '';
    public $newUserEmail = '';
    public $showNewUserFields = false;

    public function searchProducts($value)
    {
        // Filtrar productos según la búsqueda
        if ($value) {
            $this->products = ProductModel::where('name', 'like', '%' . $value . '%')
            ->orWhereHas('category', function ($query) use ($value) {
                $query->where('name', 'like', '%' . $value . '%'); // Asegúrate de que 'name' sea el campo correcto en tu tabla de categorías
            })
            ->get();
        } else {
            $this->products = []; // Mantener productos vacíos si no hay búsqueda
        }
    }

    public function render()
    {
        return view('livewire.sections.pos', [
            'products' => $this->products,
            'cart' => $this->cart,
            'total' => $this->calculateTotals(),
        ]);
    }
    public function addToCart($productId)
    {
        $product = ProductModel::find($productId);
        
        if (!$product || $product->cant <= 0) {
            $this->dispatch('errorStock', 'Este producto no está disponible en stock.');
            return;
        }

        // Verificar si el producto ya está en el carrito
        foreach ($this->cart as &$item) {
            if ($item['id'] === $productId) {
                if ($item['quantity'] < $product->cant) {
                    $item['quantity']++;
                }else{
                    $this->dispatch('errorStock', 'No se puede agregar más de este producto, no hay suficiente stock.');
                }
                return;
            }
        }

        // Si no está, agregarlo al carrito
        $this->cart[] = [
            'id' => $productId,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => 1,
            'image' => 'https://holos-spa.com/images/products/'.$product->image.'.jpeg'
        ];

        // Actualizar total después de agregar al carrito
        $this->total = $this->calculateTotals();
        $this->products = [];
    }

    public function removeFromCart($productId)
    {
        foreach ($this->cart as $key => $item) {
            if ($item['id'] === $productId) {
                unset($this->cart[$key]);
                break; // Salir del bucle después de eliminar
            }
        }

        // Actualizar total después de eliminar del carrito
        $this->total = $this->calculateTotals();
    }

    public function calculateTotals()
    {
        $this->subtotal = array_reduce($this->cart, function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);

        // Calcular IVA
        $this->iva = $this->subtotal * $this->ivaRate;

        // Calcular total
        $this->total = $this->subtotal + $this->iva;
    }
    
    public function searchUsers($value)
    {
        if ($value) {
            // Limpiar el valor para evitar problemas de codificación
            $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
    
            $this->users = UserModel::where('name', 'like', '%' . $value . '%')->get();
            
            // Si no se encuentran usuarios, agregar opción para crear uno nuevo
            if ($this->users->isEmpty()) {
                $this->users = [
                    (object)[
                        'id' => 'new', 
                        'name' => 'Agregar nuevo usuario: ' . $value,
                    ]
                ];
            }
        } else {
            $this->users = []; // Mantener usuarios vacíos si no hay búsqueda
        }
    }

    
    public function createUser()
    {
    
        // Crear el nuevo usuario
        $user = UserModel::create([
            'name' => $this->newUserName,
            'phone' => $this->newUserPhone,
            'email' => $this->newUserEmail,
        ]);
    
        // Almacenar el ID del nuevo usuario
        $this->selectedUser = $user->id;
    
        // Limpiar campos después de crear
        $this->resetNewUserFields();
        
        // Limpiar la lista de usuarios después de crear uno
        $this->users = [];
    }
    
    public function resetNewUserFields()
    {
        $this->newUserName = '';
        $this->newUserPhone = '';
        $this->newUserEmail = '';
    }

    /*public function searchUsers($value)
    {
        if ($value) {
            $this->users = UserModel::where('name', 'like', '%' . $value . '%')->get();
        } else {
            $this->users = []; // Mantener usuarios vacíos si no hay búsqueda
        }
    }*/

    public function selectUser($userId)
    {
        if($userId === 0){
            $showNewUserFields = true;
            $this->selectedUser = $userId; // Almacenar el ID del usuario seleccionado
            $this->users = []; // 
        }else{
            $this->selectedUser = $userId; // Almacenar el ID del usuario seleccionado
            $this->users = []; // Limpiar la lista de usuarios después de seleccionar uno    
        }
        
    }

    public function processSale()
    {
        $saleCart = SaleModel::create([
            'user_id' => $this->selectedUser,
            'total' => $this->total,
            'subtotal' => $this->subtotal,
            'iva' => $this->iva,
            'type' => $this->paymentType,
            'cart' => json_encode($this->cart),
        ]);

        $ticketData = [
            'user' => UserModel::find($this->selectedUser),
            'products' => json_decode(json_encode($this->cart)),
            'subtotal' => $this->subtotal,
            'iva' => $this->iva,
            'total' => $this->total,
            'date' => now(),
            'email' => UserModel::find($this->selectedUser)->email,
            'name' => UserModel::find($this->selectedUser)->name,
        ];
        
        session(['ticketData' => $ticketData]);
        
        $sendEmail = Mail::to(UserModel::find($this->selectedUser)->email)->send(new TicketMailable($ticketData));

        foreach ($this->cart as $item) {
            $product = ProductModel::find($item['id']);

                $product->cant -= $item['quantity'];
                $product->save();

        }

        return redirect()->route('ticket', $saleCart);
    }
}
