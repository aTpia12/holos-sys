<?php

namespace App\Livewire\Sections;

use Livewire\Component;
use App\Models\Sale as SaleModel;

class Sale extends Component
{
    public $sales;
    public function render()
    {
        $this->sales = SaleModel::all();

        return view('livewire.sections.sale');
    }
}
