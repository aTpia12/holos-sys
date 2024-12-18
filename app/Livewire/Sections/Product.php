<?php

namespace App\Livewire\Sections;

use Livewire\Component;
use App\Models\Product as ModelsProduct;
use App\Models\Category as ModelsCategory;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Product extends Component
{
    use WithFileUploads;

    public $name;
    public $slug;
    public $category_id = 1;
    public $price;
    public $description;
    public $image;
    public $code;

    public $nameUpdate;
    public $slugUpdate;
    public $category_idUpdate;
    public $priceUpdate;
    public $descriptionUpdate;
    public $imageUpdate;
    public $codeUpdate;
    public $search = '';
    public $categories;
    public $cant;

    public function searchProducts($value)
    {
        // Filtrar categorías según la búsqueda
        if ($value) {
            $this->products = ModelsProduct::where('name', 'like', '%' . $value . '%')
                ->paginate(10); // Usar paginación si es necesario
        } else {
            $this->products = ModelsProduct::paginate(10); // Mostrar todas las categorías si no hay búsqueda
        }
    }

    public function findProduct(ModelsProduct $product)
    {
        $this->nameUpdate = $product->name;
        $this->slugUpdate = $product->slug;
        $this->priceUpdate = $product->price;
        $this->descriptionUpdate = $product->description;
        $this->imageUpdate = $product->image;
        $this->codeUpdate = $product->code;
    }

    public function save()
    {


        ModelsProduct::create([
            'category_id' => $this->category_id,
            'name' => $this->name,
            'cant' => $this->cant,
            'slug' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
            'image' => $this->image,
            'code' => $this->code,
        ]);

        $this->dispatch('productCreated');
    }

    public function render()
    {
        $this->products = ModelsProduct::where('name', 'like', '%' . $this->search . '%')
                ->paginate(10);
        $this->categories = ModelsCategory::all();

        return view('livewire.sections.product', ['products' => $this->products, 'categories' => $this->categories]);
    }
}
