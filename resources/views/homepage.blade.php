<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Real-Coffee | Café Helado de Calidad Premium</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <script src="https://unpkg.com/lenis@1.3.25/dist/lenis.min.js"></script>
  <link
    href="https://fonts.googleapis.com/css2?family=Cabinet+Grotesk:wght@800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
    rel="stylesheet">

  <script>
    const lenis = new Lenis();

    function raf(time) {
      lenis.raf(time);
      requestAnimationFrame(raf);
    }

    requestAnimationFrame(raf);
  </script>
  @livewireStyles
</head>

<body
  class="font-['Plus_Jakarta_Sans'] bg-[#e8e0d5] antialiased overflow-x-hidden selection:bg-[#d4a870] selection:text-[#221813]"
  x-data="{ mobileMenuOpen: false }">

@if(isset($schedule) && $schedule['isClosed'])
  <div class="bg-[#3b2219] px-4 md:px-6 py-3 text-center relative z-50">
    <div class="max-w-7xl mx-auto flex items-center justify-center gap-2 text-xs md:text-sm text-[#f8d7da]">
      <x-lucide-octagon-alert class="w-4 h-4 shrink-0" />
      <span class="font-bold uppercase">Cerrado:</span> <span class="text-left">{{ $schedule['message'] }}</span>
    </div>
  </div>
@endif

<div class="relative bg-[#221813] text-[#ede5d8] w-full pb-20 md:pb-32">
  <header class="max-w-7xl mx-auto px-4 md:px-6 py-6 flex justify-between items-center relative z-40">
    <div class="flex items-center gap-2">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#d4a870" class="w-6 h-6 shrink-0">
        <path
          d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z"/>
      </svg>
      <span class="font-['Cabinet_Grotesk'] text-xl md:text-2xl font-black tracking-tighter text-white italic">Real-Coffee</span>
    </div>

    <nav class="hidden md:flex items-center gap-10 text-sm font-medium text-[#c4b8aa]">
      <a href="#menu" class="nav-link hover:text-white transition">Menu</a>
      <a href="#sobre-nosotros" class="nav-link hover:text-white transition">Sobre Nosotros</a>
      <a href="#locales-horarios" class="nav-link hover:text-white transition">Locales y Horarios</a>
    </nav>

    <div class="flex items-center gap-3 relative z-40">
      <div class="hidden md:flex items-center gap-4">
        @if (Route::has('login'))
          @auth
            <div class="relative">
              <button id="user-menu-toggle" onclick="toggleUserMenu(event)"
                      class="flex items-center gap-2 pl-1.5 pr-2.5 py-1.5 rounded-full bg-[#3f3026] hover:bg-[#4a382c] transition cursor-pointer">
                <span
                  class="w-7 h-7 rounded-full bg-[#d4a870] text-[#221813] flex items-center justify-center text-xs font-black uppercase shrink-0">
                  {{ Str::substr(auth()->user()->name, 0, 1) }}
                </span>
                <span class="text-xs font-bold text-[#ede5d8] max-w-[110px] truncate">{{ auth()->user()->name }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                     class="text-[#a3988b] shrink-0">
                  <polyline points="6 9 12 15 18 9"/>
                </svg>
              </button>

              <div id="user-menu-panel"
                   class="hidden absolute right-0 top-full mt-3 w-56 bg-[#2c221a] border border-[#3f3026] rounded-2xl shadow-2xl p-2 z-30">
                <div class="px-3 py-3 border-b border-[#3f3026] mb-1">
                  <p class="text-xs font-black text-[#ede5d8] truncate">{{ auth()->user()->name }}</p>
                  <p class="text-[11px] text-[#a3988b] truncate">{{ auth()->user()->email }}</p>
                </div>
                @if(auth()->user()?->hasAnyRole(['Administrador', 'Cajero', 'Cafeteria', 'Cocina']))
                  <a href="{{ route('dashboard') }}"
                     class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold text-[#ede5d8] hover:bg-[#3f3026] transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="text-[#d4a870]">
                      <rect x="3" y="3" width="7" height="9" rx="1"/>
                      <rect x="14" y="3" width="7" height="5" rx="1"/>
                      <rect x="14" y="12" width="7" height="9" rx="1"/>
                      <rect x="3" y="16" width="7" height="5" rx="1"/>
                    </svg>
                    Dashboard
                  </a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit"
                          class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold text-[#e08a7a] hover:bg-[#3f3026] transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                      <polyline points="16 17 21 12 16 7"/>
                      <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    Cerrar Sesión
                  </button>
                </form>
              </div>
            </div>
          @else
            <a href="#menu"
               class="nav-link bg-[#d4a870] text-[#221813] px-6 py-2.5 rounded-full text-xs font-bold uppercase tracking-wider hover:bg-[#e6bb85] transition">PEDÍ
              AHORA!</a>
          @endauth
        @endif
      </div>

      @livewire('cart-manager')

      <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-white hover:text-[#d4a870] cursor-pointer transition md:hidden p-1 z-50">
        <svg x-show="!mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
        <svg x-show="mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="display: none;"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
    </div>
  </header>

  <div x-show="mobileMenuOpen"
       x-transition:enter="transition ease-out duration-200"
       x-transition:enter-start="opacity-0 -translate-y-2"
       x-transition:enter-end="opacity-100 translate-y-0"
       x-transition:leave="transition ease-in duration-150"
       x-transition:leave-start="opacity-100 translate-y-0"
       x-transition:leave-end="opacity-0 -translate-y-2"
       class="fixed top-20 left-0 w-full bg-[#1b120e] border-b border-[#3f3026] px-6 py-6 flex flex-col gap-4 z-50 md:hidden shadow-2xl"
       style="display: none;">

    @auth
      <div class="flex items-center gap-3 pb-4 border-b border-[#3f3026]">
        <span class="w-9 h-9 rounded-full bg-[#d4a870] text-[#221813] flex items-center justify-center text-sm font-black uppercase shrink-0">
          {{ Str::substr(auth()->user()->name, 0, 1) }}
        </span>
        <div class="overflow-hidden">
          <p class="text-sm font-black text-white truncate">{{ auth()->user()->name }}</p>
          <p class="text-xs text-[#a3988b] truncate">{{ auth()->user()->email }}</p>
        </div>
      </div>

      @if(auth()->user()?->hasAnyRole(['Administrador', 'Cajero', 'Cafeteria', 'Cocina']))
        <a href="{{ route('dashboard') }}" @click="mobileMenuOpen = false" class="flex items-center gap-3 text-sm font-bold text-[#ede5d8] hover:text-[#d4a870] py-2">
          Dashboard
        </a>
      @endif
    @endauth

    <a href="#menu" @click="mobileMenuOpen = false" class="nav-link text-base font-semibold text-[#ede5d8] hover:text-[#d4a870] transition py-2 border-b border-[#2c221a]">Menu</a>
    <a href="#sobre-nosotros" @click="mobileMenuOpen = false" class="nav-link text-base font-semibold text-[#ede5d8] hover:text-[#d4a870] transition py-2 border-b border-[#2c221a]">Sobre Nosotros</a>
    <a href="#locales-horarios" @click="mobileMenuOpen = false" class="nav-link text-base font-semibold text-[#ede5d8] hover:text-[#d4a870] transition py-2 border-b border-[#2c221a]">Locales y Horarios</a>

    <div class="pt-2">
      @auth
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="w-full text-left text-sm font-bold text-[#e08a7a] hover:text-red-400 py-2">
            Cerrar Sesión
          </button>
        </form>
      @else
        <a href="#menu" @click="mobileMenuOpen = false" class="nav-link block text-center bg-[#d4a870] text-[#221813] px-6 py-3 rounded-full text-xs font-bold uppercase tracking-wider hover:bg-[#e6bb85] transition">
          PEDÍ AHORA!
        </a>
      @endauth
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 md:px-6 flex justify-start md:justify-end relative z-10 mb-6 md:mb-10">
    <div
      class="inline-flex items-center gap-2 bg-[#3f3026] text-[#c4b8aa] rounded-full px-3 md:px-4 py-1.5 md:py-2 text-[11px] md:text-xs font-bold tracking-wider">
      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor"
           class="text-[#594336]">
        <path
          d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"/>
      </svg>
      100% GRANOS ITALIANOS
    </div>
  </div>

  <div class="absolute top-24 md:top-30 left-0 w-full flex justify-center z-10 pointer-events-none">
    <h1
      class="text-[15vw] md:text-[17vw] translate-y-50 md:translate-y-0 antialiased leading-none font-extrabold text-[#ede5d8] uppercase tracking-tight text-center select-none whitespace-nowrap">
      CAFÉ HELADO
    </h1>
  </div>

  <main class="max-w-7xl mx-auto px-4 md:px-6 relative z-30 grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-4 items-center">
    <div class="space-y-6 md:pt-12 md:pt-20 text-center md:text-left">
      <p class="text-[#c4b8aa] text-base md:text-lg leading-relaxed max-w-xs mx-auto md:mx-0 font-medium">
        Refresca tu dia con el equilibrio perfecto entre sabor y frescura.
      </p>
    </div>

    <div class="relative flex justify-center items-center md:h-[420px] sm:h-[500px] md:h-[600px] w-full">
      <div class="absolute inset-0 flex justify-center items-center -z-10 pointer-events-none select-none">
        <img src="granos-cafe.webp" alt="Granos de café"
             class="w-full h-full rotate-z-90 object-contain opacity-40 transform scale-[1.8] md:scale-[2.6] drop-shadow-[0_20px_20px_rgba(0,0,0,0.4)]">
      </div>
      <img src="vaso-cafe.webp" alt="Vaso con café helado"
           class="h-full w-auto object-contain drop-shadow-[0_30px_30px_rgba(0,0,0,0.6)] z-20 mt-20 md:mt-70 transform scale-125 md:scale-160 select-none pointer-events-none">
    </div>

    <div class="relative w-24 h-24 md:w-28 md:h-28 flex items-center justify-center mx-auto md:ml-auto md:mt-20 md:mr-0">
      <svg class="absolute inset-0 w-full h-full text-[#d4a870] animate-[spin_20s_linear_infinite]"
           viewBox="0 0 100 100">
        <path d="M50,10 A40,40 0 1,1 49.9,10" id="circle" fill="none" stroke="currentColor" stroke-width="1"
              stroke-dasharray="4 4"/>
        <text class="text-[11px] font-bold uppercase tracking-widest my-4 fill-[#d4a870]">
          <textPath href="#circle">CAFÉ FRIO • ALTA CALIDAD •</textPath>
        </text>
      </svg>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#d4a870" class="w-7 h-7 md:w-8 md:h-8">
        <path
          d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z"/>
      </svg>
    </div>

    <div class="grid grid-cols-3 gap-2 md:gap-6 text-center divide-x divide-[#3f3026] col-span-full pt-4 md:pt-0">
      <div class="flex flex-col items-center gap-2 md:gap-3 px-2 md:px-6">
        <div class="text-[#d4a870]">
          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
               stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m10 20-1.25-2.5L6 18"/>
            <path d="M10 4 8.75 6.5 6 6"/>
            <path d="m14 20 1.25-2.5L18 18"/>
            <path d="m14 4 1.25 2.5L18 6"/>
            <path d="m17 21-3-6h-4"/>
            <path d="m17 3-3 6 1.5 3"/>
            <path d="M2 12h6.5L10 9"/>
            <path d="m20 10-1.5 2 1.5 2"/>
            <path d="M22 12h-6.5L14 15"/>
            <path d="m4 10 1.5 2L4 14"/>
            <path d="m7 21 3-6-1.5-3"/>
            <path d="m7 3 3 6h4"/>
          </svg>
        </div>
        <p class="text-[11px] md:text-xs font-medium text-[#c4b8aa]">Frio<br>Siempre</p>
      </div>

      <div class="flex flex-col items-center gap-2 md:gap-3 px-2 md:px-6">
        <div class="text-[#d4a870]">
          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
               stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/>
          </svg>
        </div>
        <p class="text-[11px] md:text-xs font-medium text-[#c4b8aa]">Granos<br>Premium</p>
      </div>

      <div class="flex flex-col items-center gap-2 md:gap-3 px-2 md:px-6">
        <div class="text-[#d4a870]">
          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
               stroke="currentColor" stroke-width="2">
            <path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/>
            <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/>
          </svg>
        </div>
        <p class="text-[11px] md:text-xs font-medium text-[#c4b8aa]">Energia<br>Natural</p>
      </div>
    </div>
  </main>
</div>

<div
  class="relative z-50 w-[110%] -ml-[5%] bg-[#d4a870] text-[#221813] py-3 md:py-4 transform -rotate-2 -mt-12 md:-mt-16 overflow-hidden shadow-xl">
  <div
    class="flex gap-8 md:gap-12 justify-center items-center font-['Cabinet_Grotesk'] font-black uppercase text-base md:text-xl tracking-wide whitespace-nowrap">
    <span class="flex items-center gap-4 md:gap-6">
      VANILLA ICE
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 md:w-5 md:h-5">
        <path
          d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z"/>
      </svg>
      CARAMEL ICE
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 md:w-5 md:h-5">
        <path
          d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z"/>
      </svg>
      CLASSIC BLACK
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 md:w-5 md:h-5">
        <path
          d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z"/>
      </svg>
      MOCHA ICE
    </span>
  </div>
</div>

<section id="menu" class="text-[#221813] pt-16 md:pt-24 pb-16 md:pb-20 px-4 md:px-6 relative z-10 overflow-hidden">
  <div class="max-w-7xl mx-auto space-y-8 md:space-y-12 relative z-10">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 md:gap-6">
      <h2 class="font-['Cabinet_Grotesk'] text-3xl sm:text-4xl md:text-6xl font-black uppercase tracking-tight leading-none">
        HECHO POR Y PARA <br>AMANTES DEL FRIO
      </h2>
      <p class="text-[#685e54] text-xs md:text-sm max-w-xs font-medium">
        Cada taza esta elaborada para ofrecer una experiencia de cafe suave, refrescante e inolvidable.
      </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      @forelse ($products as $product)
        <div
          class="bg-[#2c221a] rounded-3xl overflow-hidden cursor-pointer group hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 flex flex-col h-full">
          <div class="h-48 sm:h-56 bg-zinc-800 w-full relative">
            @if(!empty($product->image))
              <img src="{{ asset('storage/' . $product->image->path) }}" alt="{{ $product->name }}"
                   class="object-cover w-full h-full opacity-80 group-hover:opacity-100 transition">
            @else
              <div
                class="w-full h-full bg-gradient-to-br from-[#3f3026] to-[#221813] flex items-center justify-center overflow-hidden">
                <svg xmlns="http://www.w3.org/2000/svg" width="52" height="52" viewBox="0 0 24 24" fill="none"
                     stroke="#d4a870" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"
                     class="opacity-80 group-hover:opacity-100 group-hover:scale-110 transition">
                  <path d="M4 8h13v6a5 5 0 0 1-5 5H9a5 5 0 0 1-5-5V8Z"/>
                  <path d="M17 9h1.5a2.5 2.5 0 0 1 0 5H17"/>
                  <path d="M8 2c0 1-1 1-1 2s1 1 1 2"/>
                  <path d="M12 2c0 1-1 1-1 2s1 1 1 2"/>
                </svg>
              </div>
            @endif
          </div>

          <div class="p-5 md:p-6 flex flex-col flex-grow justify-between space-y-4">
            <div>
              <h3
                class="font-['Cabinet_Grotesk'] font-black text-lg md:text-xl text-[#d4a870] tracking-wide">{{ $product->name }}</h3>
              <p class="text-xs text-[#a3988b] mt-2 line-clamp-2">{{ $product->description }}</p>
            </div>

            <div
              class="flex items-center justify-between pt-2"
              x-data="{ added: false }"
              x-on:click.once="() => {}">

              <span
                class="font-['Cabinet_Grotesk'] font-black text-base md:text-lg text-[#ede5d8]">
                ${{ number_format($product->price, 0, ',', '.') }}
              </span>

              <div class="flex items-center gap-2">
                @if(isset($schedule) && $schedule['isClosed'])
                  <button
                    type="button"
                    disabled
                    class="bg-[#3f3026] text-[#705f50] px-4 py-1.5 rounded-full text-[11px] font-black uppercase tracking-wider cursor-not-allowed opacity-60">
                    Cerrado
                  </button>
                @else
                  <span
                    x-show="added"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-x-1"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="text-[10px] font-bold text-[#d4a870] whitespace-nowrap">
                    ¡Agregado!
                  </span>

                  <button
                    type="button"
                    @click="
                      Livewire.dispatch('addToCart', { productId: {{ $product->id }} });
                      added = true;
                      setTimeout(() => added = false, 2000);
                    "
                    class="add-btn group/btn relative flex items-center gap-2 scale-100 bg-[#d4a870] text-[#2c221a] pl-4 pr-1.5 py-1.5 rounded-full text-[11px] font-black uppercase tracking-wider transition-all duration-300 hover:pr-5 hover:gap-3 active:scale-90 shadow-[0_4px_0_0_#8a6a42] hover:shadow-[0_2px_0_0_#8a6a42] hover:translate-y-[2px] cursor-pointer">
                    <span>Añadir</span>
                    <span
                      class="w-6 h-6 rounded-full bg-[#2c221a] text-[#d4a870] flex items-center justify-center shrink-0 transition-transform duration-300 group-hover/btn:rotate-90">
                      <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none"
                           stroke="currentColor" stroke-width="3" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    </span>
                  </button>
                @endif
              </div>
            </div>
          </div>
        </div>
      @empty
        <div class="col-span-full text-center py-12">
          <p class="text-[#a3988b] text-base">No hay productos disponibles en este momento.</p>
        </div>
      @endforelse
    </div>
  </div>
</section>

<section id="sobre-nosotros" class="bg-[#221813] text-[#ede5d8] py-16 md:py-24 px-4 md:px-6 relative overflow-hidden">
  <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-10 md:gap-16 items-center relative z-10">
    <div class="space-y-6 text-center md:text-left">
      <div
        class="inline-flex items-center gap-2 bg-[#3f3026] text-[#c4b8aa] rounded-full px-4 py-2 text-xs font-bold tracking-wider">
        DESDE EL GRANO HASTA TU TAZA
      </div>
      <h2 class="font-['Cabinet_Grotesk'] text-3xl sm:text-4xl md:text-6xl font-black uppercase tracking-tight leading-none">
        NACIMOS PARA<br>ENFRIAR EL CAFÉ<br><span class="text-[#d4a870] italic">SIN PERDER EL ALMA</span>
      </h2>
      <p class="text-[#c4b8aa] text-sm md:text-base leading-relaxed max-w-md mx-auto md:mx-0 font-medium">
        Real-Coffee empezó como un carrito en la puerta de una tostaduría, con una sola idea fija: el café frío no tiene
        por qué ser café de mala calidad servido sobre hielo.
      </p>
    </div>
    <div class="relative flex justify-center items-center h-[320px] md:h-[420px]">
      <img src="vaso-cafe.webp" alt="Vaso con café helado"
           class="h-full w-auto object-contain drop-shadow-[0_30px_30px_rgba(0,0,0,0.6)] transform scale-110 select-none pointer-events-none">
    </div>
  </div>
</section>

<section id="locales-horarios" class="bg-[#e8e0d5] text-[#221813] py-16 md:py-24 px-4 md:px-6 relative">
  <div class="max-w-7xl mx-auto space-y-8 md:space-y-12">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 md:gap-6">
      <h2 class="font-['Cabinet_Grotesk'] text-3xl sm:text-4xl md:text-6xl font-black uppercase tracking-tight leading-none">
        LOCALES <br>Y HORARIOS
      </h2>
      <p class="text-[#685e54] text-xs md:text-sm max-w-xs font-medium">
        Encontranos en la Patagonia Argentina.
      </p>
    </div>
  </div>
</section>

<script>
  document.querySelectorAll('.nav-link').forEach(function (link) {
    link.addEventListener('click', function (e) {
      const href = this.getAttribute('href');
      if (href.startsWith('#')) {
        e.preventDefault();
        const target = document.querySelector(href);
        if (target) {
          lenis.scrollTo(target, {offset: -20});
        }
      }
    });
  });

  function toggleUserMenu(event) {
    if (event) event.preventDefault();
    const panel = document.getElementById('user-menu-panel');
    panel.classList.toggle('hidden');
  }
</script>

@livewireScripts

@if(session('success_order'))
  <div
    x-data="{ show: true }"
    x-init="setTimeout(() => show = false, 4000)"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-4"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-4"
    class="fixed bottom-6 right-6 z-50 bg-[#2c221a] border border-[#3f3026] text-[#ede5d8] px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-4 max-w-sm">

    <div class="w-10 h-10 rounded-xl bg-[#3f3026] text-[#d4a870] flex items-center justify-center shrink-0">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
    </div>

    <div class="space-y-0.5">
      <p class="font-['Cabinet_Grotesk'] font-black text-sm uppercase text-white">Exito!</p>
      <p class="text-xs text-[#a3988b]">{{ session('success_order') }}</p>
    </div>
  </div>
@endif
<footer class="border-t border-[#3f3026] bg-[#221813] py-4 text-center text-[11px] text-[#a3988b]">
  &copy; {{ date('Y') }} Real-Coffee. Sistema de Pedidos.
</footer>
</body>
</html>
