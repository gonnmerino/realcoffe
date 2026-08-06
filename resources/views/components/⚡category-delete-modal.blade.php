<?php

use Livewire\Component;
use App\Models\Category;
use App\Models\Product;

new class extends Component {
  public $categoryId;
  public $categoryName;
  public $isOpen = false;

  protected $listeners = ['openDeleteModal' => 'open'];

  public function open($id, $name)
  {
    $this->categoryId = $id;
    $this->categoryName = $name;
    $this->isOpen = true;
  }

  public function close()
  {
    $this->isOpen = false;
    $this->reset(['categoryId', 'categoryName']);
  }

  public function deleteCategory()
  {
    $products = Product::where('category_id', $this->categoryId)->count();
    if($products == 1) {
      session()->flash('error', "Esta categoría aún tiene {$products} producto asociado. Cambia el producto a otra categoria para poder eliminarla");
      return;
    } elseif($products > 0) {
      session()->flash('error', "Esta categoría aún tiene {$products} productos asociados. Cambia los productos a otra categoria para poder eliminarla");
      return;
    } else {
      $category = Category::findOrFail($this->categoryId);
      $category->delete();
      return redirect()->route('categories.index')->with('success', 'Categoría eliminada correctamente.');
    };
  }

}; ?>

<div>
  @if($isOpen)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
      <div class="bg-zinc-800 text-zinc-100 p-6 rounded-lg border border-zinc-700 shadow-xl max-w-md w-full">
        @if (session()->has('error'))
          <div class="mb-4 p-4 bg-red-950/40 text-red-400 rounded-lg border border-red-900/50 text-sm">
            {{ session('error') }}
          </div>
        @endif
        <h3 class="text-lg font-bold text-zinc-100">¿Estás seguro?</h3>
        <p class="text-sm text-zinc-400 mt-2">
          Estás a punto de eliminar la categoria: <strong class="text-zinc-200">{{ $categoryName }}</strong>.
        </p>
        <div class="flex justify-end space-x-3 mt-6">
          <button type="button"
                  wire:click="$set('isOpen', false)"
                  class="px-4 py-2 bg-zinc-700 hover:bg-zinc-600 text-zinc-300 font-semibold rounded-md text-sm transition-colors cursor-pointer">
            Cancelar
          </button>
          <button type="button"
                  wire:click="deleteCategory"
                  class="px-4 py-2 bg-zinc-100 hover:bg-zinc-200 text-zinc-900 font-semibold rounded-md text-sm transition-all cursor-pointer">
            Confirmar y Eliminar
          </button>
        </div>
      </div>
    </div>
  @endif
</div>
