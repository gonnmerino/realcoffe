<?php

use Livewire\Component;
use App\Models\Product;

new class extends Component {
  public $productId;
  public $productName;
  public $isOpen = false;

  protected $listeners = ['openDeleteModal' => 'open'];

  public function open($id, $name)
  {
    $this->productId = $id;
    $this->productName = $name;
    $this->isOpen = true;
  }

  public function close()
  {
    $this->isOpen = false;
    $this->reset(['productId', 'productName']);
  }

  public function deleteProduct()
  {
    $product = Product::findOrFail($this->productId);
    $product->is_published = false;
    $product->save();

    $this->dispatch('product-deleted');

    session()->flash('success', "{$this->productName} se eliminó correctamente!");

    return redirect()->route('products.index');
  }
}; ?>

<div>
  @if($isOpen)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
      <div class="bg-zinc-800 text-zinc-100 p-6 rounded-lg border border-zinc-700 shadow-xl max-w-md w-full">

        <h3 class="text-lg font-bold text-zinc-100">¿Estás seguro?</h3>
        <p class="text-sm text-zinc-400 mt-2">
          Estás a punto de eliminar el producto: <strong class="text-zinc-200">{{ $productName }}</strong>.
        </p>
        <div class="flex justify-end space-x-3 mt-6">
          <button type="button"
                  wire:click="$set('isOpen', false)"
                  class="px-4 py-2 bg-zinc-700 hover:bg-zinc-600 text-zinc-300 font-semibold rounded-md text-sm transition-colors cursor-pointer">
            Cancelar
          </button>
          <button type="button"
                  wire:click="deleteProduct"
                  class="px-4 py-2 bg-zinc-100 hover:bg-zinc-200 text-zinc-900 font-semibold rounded-md text-sm transition-all cursor-pointer">
            Confirmar y Eliminar
          </button>
        </div>

      </div>
    </div>
  @endif
</div>
