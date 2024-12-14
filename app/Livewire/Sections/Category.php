<?php

namespace App\Livewire\Sections;

use Livewire\Component;
use App\Models\Category as CategoryModel;

class Category extends Component
{
    public $name;
    public $description;
    public $nameUpdate;
    public $descriptionUpdate;
    public $showToast = false;
    public $search = '';

    public CategoryModel $category;
    
    public function searchCategories($value)
    {
        // Filtrar categorías según la búsqueda
        if ($value) {
            $this->categories = CategoryModel::where('name', 'like', '%' . $value . '%')
                ->orWhere('description', 'like', '%' . $value . '%')
                ->paginate(10); // Usar paginación si es necesario
        } else {
            $this->categories = CategoryModel::paginate(10); // Mostrar todas las categorías si no hay búsqueda
        }
    }

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required',
            'description' => 'required'
        ]);

        CategoryModel::create($validated);

        $this->showToast = true;
        $this->dispatch('categoryCreated');
    }

    public function findCategory(CategoryModel $id)
    {
        $this->nameUpdate = $id->name;
        $this->descriptionUpdate = $id->description;

        $this->category = $id;
    }

    public function update()
    {
        $this->validate([
            'nameUpdate' => 'required',
            'descriptionUpdate' => 'required'
        ]);

        $this->category->update([
            'name' => $this->nameUpdate,
            'description' => $this->descriptionUpdate
        ]);
        $this->dispatch('categoryUpdated');
    }

    public function render()
    {
        $this->categories = CategoryModel::where('name', 'like', '%' . $this->search . '%')
        ->orWhere('description', 'like', '%' . $this->search . '%')
        ->paginate(10);

        return view('livewire.sections.category', ['categories' => $this->categories]);
    }
}
