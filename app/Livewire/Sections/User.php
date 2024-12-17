<?php

namespace App\Livewire\Sections;

use Livewire\Component;
use App\Models\User as ModelsUser;

class User extends Component
{

    public $search = '';
    public function searchUsers($value)
    {
        // Filtrar categorías según la búsqueda
        if ($value) {
            $this->users = ModelsUser::where('name', 'like', '%' . $value . '%')
                ->orWhere('email', 'like', '%' . $value . '%')
                ->where('name', '!=', 'Administrador')
                ->paginate(10); // Usar paginación si es necesario
        } else {
            $this->users = ModelsUser::where('name', '!=', 'Administrador')->paginate(10); // Mostrar todas las categorías si no hay búsqueda
        }
    }
    public function render()
    {
        $this->users = ModelsUser::where(function($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%');
        })
            ->where('name', '!=', 'Administrador')
            ->paginate(10);

        return view('livewire.sections.user', ['users' => $this->users]);
    }
}
