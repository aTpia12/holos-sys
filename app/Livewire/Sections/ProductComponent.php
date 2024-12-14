<?php

namespace App\Livewire\Sections;

use Livewire\Component;
use App\Models\Product as ProductModel;
use Livewire\WithPagination;

class ProductComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $productId;
    public $quantity;

    public function render()
    {
        $products = ProductModel::where('cant', 0)->paginate(10);

        return view('livewire.sections.product-component', ['products' => $products]);
    }

    public function updateQuantity()
    {
        $this->validate(['quantity' => 'required|integer|min:1']);
        $product = ProductModel::find($this->productId);
        $product->cant += $this->quantity;
        $product->save();

        // Reset fields
        $this->reset(['quantity', 'productId']);
    }
}