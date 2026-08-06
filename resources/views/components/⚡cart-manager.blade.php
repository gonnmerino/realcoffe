<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Product;

new class extends Component {
  public $isOpen = false;

  #[On('addToCart')]
  public function addToCart($productId)
  {
    $cart = session()->get('cart', []);

    if (isset($cart[$productId])) {
      $cart[$productId]['qty']++;
    } else {
      $product = Product::find($productId);
      if (!$product) return;

      $cart[$productId] = [
        'name' => $product->name,
        'price' => $product->price,
        'qty' => 1,
      ];
    }

    session()->put('cart', $cart);
    $this->isOpen = true;
  }

  public function toggleCart()
  {
    $this->isOpen = !$this->isOpen;
  }

  public function updateQuantity($productId, $action)
  {
    $cart = session()->get('cart', []);

    if (!isset($cart[$productId])) return;

    if ($action === 'increase') {
      $cart[$productId]['qty']++;
    } elseif ($action === 'decrease') {
      $cart[$productId]['qty']--;
      if ($cart[$productId]['qty'] <= 0) {
        unset($cart[$productId]);
      }
    }

    session()->put('cart', $cart);
  }

  public function removeFromCart($productId)
  {
    $cart = session()->get('cart', []);
    unset($cart[$productId]);
    session()->put('cart', $cart);
  }

  public function render()
  {
    $cart = session()->get('cart', []);
    $total = array_reduce($cart, fn($sum, $item) => $sum + ($item['price'] * $item['qty']), 0);
    $count = array_reduce($cart, fn($sum, $item) => $sum + $item['qty'], 0);

    return view('components.⚡cart-manager', compact('cart', 'total', 'count'));
  }
}
?>

<div>
  <div class="relative">
    <button wire:click="toggleCart" type="button"
            class="relative text-white hover:text-[#d4a870] cursor-pointer transition-transform duration-200">
      <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none"
           stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="9" cy="21" r="1"/>
        <circle cx="19" cy="21" r="1"/>
        <path d="M3 3h2l2.6 12.4a2 2 0 0 0 2 1.6h8.8a2 2 0 0 0 2-1.6L22 7H6"/>
      </svg>

      @if($count > 0)
        <span
          class="absolute -top-2 -right-2 bg-[#d4a870] text-[#221813] text-[10px] font-black rounded-full w-4 h-4 flex items-center justify-center">
                {{ $count }}
            </span>
      @endif
    </button>

    @if($isOpen)
      <div class="fixed inset-0 z-40 sm:hidden" wire:click="toggleCart"></div>

      <div
        class="fixed sm:absolute right-4 sm:right-0 left-4 sm:left-auto top-20 sm:top-full sm:mt-4 w-auto sm:w-80 bg-[#2c221a] border border-[#3f3026] rounded-2xl shadow-2xl p-4 sm:p-5 z-50">

        <div class="flex items-center justify-between mb-3">
          <h4 class="font-['Cabinet_Grotesk'] font-black text-lg text-[#ede5d8] uppercase tracking-wide">Tu Carrito</h4>
          <button wire:click="toggleCart" class="text-[#a3988b] hover:text-white transition cursor-pointer p-1 text-xl">&times;
          </button>
        </div>

        <div class="max-h-64 sm:max-h-72 overflow-y-auto pr-1">
          @forelse($cart as $id => $item)
            <div class="flex items-center justify-between gap-2 py-3 border-b border-[#3f3026] last:border-0">
              <div class="overflow-hidden pr-1 flex-1">
                <p class="font-bold text-sm text-[#ede5d8] truncate">{{ $item['name'] }}</p>
                <p class="text-xs text-[#a3988b]">${{ number_format($item['price'], 0, ',', '.') }} c/u</p>
              </div>

              <div class="flex items-center gap-1 shrink-0">
                <button wire:click="updateQuantity({{ $id }}, 'decrease')"
                        class="w-7 h-7 text-[#d4a870] flex items-center justify-center hover:text-white transition cursor-pointer">
                  <x-lucide-circle-minus class="w-4 h-4" />
                </button>
                <span class="text-xs text-white w-5 text-center font-bold">{{ $item['qty'] }}</span>
                <button wire:click="updateQuantity({{ $id }}, 'increase')"
                        class="w-7 h-7 text-[#d4a870] flex items-center justify-center hover:text-white transition cursor-pointer">
                  <x-lucide-circle-plus class="w-4 h-4" />
                </button>
                <button wire:click="removeFromCart({{ $id }})"
                        class="text-red-400 hover:text-red-300 p-1 cursor-pointer ml-1">
                  <x-lucide-x class="w-4 h-4" />
                </button>
              </div>
            </div>
          @empty
            <p class="text-sm text-[#a3988b] text-center py-8">Tu carrito está vacío</p>
          @endforelse
        </div>

        <div class="flex items-center justify-between pt-4 mt-2 border-t border-[#3f3026]">
          <span class="text-xs uppercase tracking-wider text-[#a3988b] font-bold">Total</span>
          <span
            class="font-['Cabinet_Grotesk'] font-black text-xl text-[#d4a870]">${{ number_format($total, 0, ',', '.') }}</span>
        </div>

        @if(!empty($cart))
          <a href="{{ Route::has('checkout') ? route('checkout') : '#' }}"
             class="block text-center w-full mt-4 bg-[#d4a870] text-[#221813] py-3 rounded-full text-xs font-bold uppercase tracking-wider hover:bg-[#e6bb85] transition">
            Finalizar Pedido
          </a>
        @endif
      </div>
    @endif
  </div>
</div>
