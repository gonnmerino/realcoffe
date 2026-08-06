<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Checkout | Real-Coffee</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cabinet+Grotesk:wght@800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
  @livewireStyles
</head>

<body class="font-['Plus_Jakarta_Sans'] bg-[#221813] text-[#ede5d8] antialiased min-h-screen flex flex-col justify-between selection:bg-[#d4a870] selection:text-[#221813]">

<!-- Header Estilo Dashboard -->
<header class="border-b border-[#3f3026] bg-[#2c221a]/80 backdrop-blur-md sticky top-0 z-50">
  <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
    <a href="{{ route('homepage') }}" class="flex items-center gap-2.5 group">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#d4a870" class="w-6 h-6 transition-transform group-hover:scale-105">
        <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z"/>
      </svg>
      <span class="font-['Cabinet_Grotesk'] text-xl font-black tracking-tight text-white italic">Real-Coffee</span>
    </a>

    <a href="{{ route('homepage') }}" class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#3f3026] text-xs font-bold text-[#a3988b] hover:text-white hover:bg-[#4a382c] transition">
      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
      Volver al menú
    </a>
  </div>
</header>

<main class="max-w-xl mx-auto w-full px-6 py-12 flex-grow flex flex-col justify-center">

  @guest
    <!-- Estado: No Logueado -->
    <div class="bg-[#2c221a] border border-[#3f3026] rounded-3xl p-8 text-center space-y-6 shadow-2xl">
      <div class="w-12 h-12 rounded-2xl bg-[#3f3026] text-[#d4a870] flex items-center justify-center mx-auto">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
      </div>

      <div class="space-y-2">
        <h1 class="font-['Cabinet_Grotesk'] text-2xl font-black uppercase text-[#ede5d8]">Iniciá sesión para continuar</h1>
        <p class="text-xs text-[#a3988b] max-w-xs mx-auto">Para poder confirmar tu pedido y retirar en el local, necesitás acceder con tu cuenta.</p>
      </div>

      <a href="{{ route('login') }}" class="inline-block w-full bg-[#d4a870] text-[#221813] py-3.5 rounded-2xl text-xs font-black uppercase tracking-wider hover:bg-[#e6bb85] transition shadow-lg">
        Iniciar Sesión
      </a>
    </div>
  @endguest

  @auth
    @php
      $cart = session()->get('cart', []);
      $total = array_reduce($cart, fn($sum, $item) => $sum + ($item['price'] * $item['qty']), 0);
    @endphp

    @if(empty($cart))
      <!-- Estado: Carrito Vacío -->
      <div class="bg-[#2c221a] border border-[#3f3026] rounded-3xl p-8 text-center space-y-4 shadow-2xl">
        <p class="text-sm text-[#a3988b]">Tu carrito está vacío.</p>
        <a href="{{ route('homepage') }}" class="inline-block bg-[#d4a870] text-[#221813] px-6 py-2.5 rounded-full text-xs font-black uppercase tracking-wider hover:bg-[#e6bb85] transition">
          Ver Productos
        </a>
      </div>
    @else
      <!-- Checkout Estilo Ticket -->
      <div class="space-y-6">

        <div class="text-center space-y-1">
          <h1 class="font-['Cabinet_Grotesk'] text-3xl font-black uppercase tracking-tight text-[#ede5d8]">
            CHECKOUT
          </h1>
          <p class="text-xs font-bold text-[#D3A870] uppercase tracking-wider">Retiro por Sucursal</p>
        </div>

        <!-- Contenedor Ticket -->
        <div class="bg-[#2c221a] border border-[#3f3026] rounded-3xl p-6 md:p-8 space-y-6 shadow-2xl relative overflow-hidden">

          <!-- Encabezado del Ticket -->
          <div class="border-b border-dashed border-[#3f3026] pb-6 text-center space-y-2">
            <span class="font-['Cabinet_Grotesk'] text-2xl font-black italic tracking-tight text-[#ede5d8]">Real-Coffee</span>

            <div class="bg-[#221813] border border-[#3f3026] rounded-2xl p-3 flex items-center justify-between text-left mt-4">
              <div>
                <p class="text-[10px] uppercase font-bold text-[#a3988b]">Cliente</p>
                <p class="text-xs font-bold text-[#ede5d8]">{{ auth()->user()->name }}</p>
              </div>
              <span class="text-[10px] font-mono bg-[#3f3026] text-[#d4a870] px-2 py-0.5 rounded-md font-bold">
                  {{ auth()->user()->email }}
                </span>
            </div>
          </div>

          <div class="space-y-3 font-['JetBrains_Mono'] text-xs">
            <div class="flex justify-between text-[10px] uppercase font-bold text-[#a3988b] border-b border-[#3f3026] pb-2">
              <span>Cantidad</span>
              <span>Subtotal</span>
            </div>

            <div class="space-y-2 max-h-56 overflow-y-auto pr-1">
              @foreach($cart as $item)
                <div class="flex justify-between items-start gap-4">
                    <span class="text-[#ede5d8] line-clamp-1">
                      <strong class="text-[#d4a870]">{{ $item['qty'] }}x</strong> {{ $item['name'] }}
                    </span>
                  <span class="text-[#ede5d8] font-bold shrink-0">
                      ${{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}
                    </span>
                </div>
              @endforeach
            </div>
          </div>

          <div class="border-t border-dashed border-[#3f3026] pt-4 space-y-3">
            <div class="flex justify-between items-center text-xs text-[#a3988b]">
              <span>Modo de Entrega</span>
              <span class="font-bold text-[#ede5d8]">Retiro en Local</span>
            </div>

            <div class="flex justify-between items-baseline pt-2 border-t border-[#3f3026]">
              <span class="font-['Cabinet_Grotesk'] text-sm uppercase font-black text-[#ede5d8]">Total Final</span>
              <span class="font-['Cabinet_Grotesk'] font-black text-3xl text-[#d4a870]">
                  ${{ number_format($total, 0, ',', '.') }}
                </span>
            </div>
          </div>

          <form action="{{ route('order.store') }}" method="POST" class="space-y-4 pt-2">
            @csrf

            <div class="space-y-1">
              <label class="text-[10px] font-bold uppercase tracking-wider text-[#a3988b]">Notas del Pedido (Opcional)</label>
              <input type="text" name="notes" placeholder="Ej: Sin azúcar, hielo extra..."
                     class="w-full bg-[#221813] border border-[#3f3026] rounded-xl px-3.5 py-2.5 text-xs text-[#ede5d8] placeholder-[#594336] focus:outline-none focus:border-[#d4a870] transition">
            </div>

            <button type="submit" class="w-full bg-[#D3A870] text-[#221813] py-3.5 rounded-2xl font-black text-xs uppercase tracking-wider hover:bg-[#e6bb85] active:scale-[0.99] transition shadow-lg cursor-pointer">
              Confirmar y Emitir Pedido
            </button>
          </form>

        </div>
      </div>
    @endif
  @endauth

</main>

<footer class="border-t border-[#3f3026] py-4 text-center text-[11px] text-[#a3988b]">
  &copy; {{ date('Y') }} Real-Coffee. Sistema de Pedidos.
</footer>

@livewireScripts
</body>
</html>
