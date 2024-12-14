<?php

namespace App\Livewire\Sections;

use Livewire\Component;
use App\Models\User as ModelsUser;

class User extends Component
{
    public function render()
    {
        $users = ModelsUser::where('name', '!=', 'Administrador')->paginate(10);

        return view('livewire.sections.user', ['users' => $users]);
    }
}
