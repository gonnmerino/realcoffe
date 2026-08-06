<x-layouts.app :title="__('Lista de productos')">
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-2xl font-bold text-white">
          Productos
        </h2>

        <p class="text-sm text-zinc-400 mt-1">
          Administra el catálogo de productos.
        </p>
      </div>

      <a href="{{ route('products.create') }}"
         class="px-4 py-2 rounded-lg font-medium transition inline-block text-center align-middle"
         style="background:#D4A870;color:#221813;">
        Nuevo Producto
      </a>
    </div>
  </x-slot>

  <div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      @if (session('success'))
        <div class="mb-4 p-4 bg-zinc-700/50 text-zinc-200 rounded-lg border border-zinc-600 text-sm">
          {{ session('success') }}
        </div>
      @endif
      <div class="bg-zinc-800 border border-zinc-700 rounded-xl shadow-sm">
        <div class="border-b border-zinc-700 px-6 py-4 flex justify-between items-center">
          <div>
            <h3 class="text-lg font-semibold text-white">
              Lista de productos
            </h3>
            <p class="text-sm text-zinc-400">
              {{ count($products) }} productos registrados
            </p>

          </div>
          <div class="flex flex-row gap-4">
            <a
              class="px-3 py-1.5 rounded-lg border cursor-pointer border-zinc-600 hover:border-zinc-500 hover:bg-zinc-700 transition text-sm"
              href="{{route('products.create')}}">
              <span class="align-middle">
                Añadir un nuevo
              </span>
            </a>

            <input
              type="text"
              placeholder="Buscar..."
              class="bg-zinc-900 border border-zinc-700 rounded-lg px-4 py-2 text-sm text-white placeholder:text-zinc-500 focus:outline-none focus:ring-2"
              style="--tw-ring-color:#D4A870;">
          </div>
        </div>
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead class="bg-zinc-900/60">
            <tr class="text-left text-sm uppercase tracking-wider text-zinc-400">
              <th class="px-6 py-4">
                Producto
              </th>
              <th class="px-6 py-4">
                Categoria
              </th>
              <th class="px-6 py-4">
                Precio
              </th>
              <th class="px-6 py-4">
                Stock
              </th>
              <th class="px-6 py-4 text-right">
                Acciones
              </th>
            </tr>
            </thead>
            <tbody class="divide-y divide-zinc-700">
            @foreach($products as $product)
              <tr class="hover:bg-zinc-700/40 transition">
                <td class="px-6 py-4">
                  <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded bg-zinc-900 border border-zinc-700 overflow-hidden flex-shrink-0">
                      @if($product->image?->path)
                        <img src="{{ Storage::url($product->image->path) }}"
                             alt="{{ $product->image->alt }}"
                             class="w-full h-full object-cover">
                      @else
                        <div class="w-full h-full flex items-center justify-center text-[10px] text-zinc-600">
                          Sin foto
                        </div>
                      @endif
                    </div>
                    <div class="flex flex-col">
                      <div class="font-medium text-white">
                        {{ $product->name }}
                      </div>
                      @if($product->description)
                        <div class="text-xs text-zinc-500">
                          {{ Str::limit($product->description, 40) }}
                        </div>
                      @endif
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4">
                  <span class="font-semibold text-zinc-500">
                    {{$product->category->name ?? 'Sin categoria'}}
                  </span>
                </td>
                <td class="px-6 py-4">
                  <span
                    class="font-semibold"
                    style="color:#D4A870;">
                    ${{ number_format($product['price']) }}
                  </span>
                </td>
                <td class="px-6 py-4">
                  @if($product['stock'] > 20)
                    <span class="px-3 py-1 rounded-full text-xs bg-green-500/15 text-green-400">
                    {{ $product['stock'] }} disponibles
                  </span>
                  @elseif($product['stock'] > 0)
                    <span class="px-3 py-1 rounded-full text-xs bg-yellow-500/15 text-yellow-400">
                    {{ $product['stock'] }} disponibles
                  </span>
                  @else
                    <span class="px-3 py-1 rounded-full text-xs bg-red-500/15 text-red-400">
                    Sin stock
                  </span>
                  @endif
                </td>
                <td class="px-6 py-4 text-right space-x-2">
                  <button
                    onclick="Livewire.dispatch('openDeleteModal', { id: {{ $product->id }}, name: '{{ addslashes($product->name) }}' })"
                    class="px-3 py-1.5 rounded-lg cursor-pointer bg-red-900/60 text-white transition text-sm">
                    Eliminar
                  </button>
                  <a href="{{route('products.edit', $product->id)}}"
                     class="px-3 py-1.5 rounded-lg border cursor-pointer border-zinc-600 hover:border-zinc-500 hover:bg-zinc-700 transition text-sm">
                    <span class="align-middle">
                      Editar
                    </span>
                  </a>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
        <div class="mt-6">
          {{ $products->links() }}
        </div>
    </div>
  </div>
  <livewire:product-delete-modal/>
</x-layouts.app>
