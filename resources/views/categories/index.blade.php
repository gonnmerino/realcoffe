<x-layouts.app :title="__('Lista de categorías')">
  <x-slot name="header">
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
              Lista de categorías
            </h3>
            <p class="text-sm text-zinc-400">
              {{ count($categories) }} categorías registradas
            </p>
          </div>
          <div class="flex flex-row gap-4">
            <a
              class="px-3 py-1.5 rounded-lg border cursor-pointer border-zinc-600 hover:border-zinc-500 hover:bg-zinc-700 transition text-sm"
              href="{{ route('categories.create') }}">
              <span class="align-middle">
                Nueva Categoria
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
              <th class="px-6 py-4">Categoría</th>
              <th class="px-6 py-4">Productos</th>
              <th class="px-6 py-4 text-right">Acciones</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-zinc-700">
            @if(count($categories) > 0)
              @foreach($categories as $category)
                <tr class="hover:bg-zinc-700/40 transition">
                  <td class="px-6 py-4">
                    <div class="flex items-center space-x-3">
                      <div class="w-10 h-10 rounded bg-zinc-900 border border-zinc-700 flex items-center justify-center flex-shrink-0 text-zinc-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                          <path d="M3 7a2 2 0 0 1 2-2h4l2 2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7Z"/>
                        </svg>
                      </div>
                      <div>
                        <div class="font-medium text-white">
                          {{ $category->name }}
                        </div>
                        @if($category->description)
                          <div class="text-xs text-zinc-500">
                            {{ Str::limit($category->description, 40) }}
                          </div>
                        @endif
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4">
                    <span class="text-zinc-300 text-sm">
                      {{ trans_choice('{1} 1 Producto |{0}|[2,*] :count Productos', $category->products_count ?? $category->products->count()) }}
                    </span>
                  </td>
                  <td class="px-6 py-4 text-right space-x-2">
                    <button
                      onclick="Livewire.dispatch('openDeleteModal', { id: {{ $category->id }}, name: '{{ addslashes($category->name) }}' })"
                      class="px-3 py-1.5 rounded-lg cursor-pointer bg-red-900/60 text-white transition text-sm">
                      Eliminar
                    </button>
                    <a href="{{ route('categories.edit', $category->id) }}"
                       class="px-3 py-1.5 rounded-lg border cursor-pointer border-zinc-600 hover:border-zinc-500 hover:bg-zinc-700 transition text-sm">
                      <span class="align-middle">
                        Editar
                      </span>
                    </a>
                  </td>
                </tr>
              @endforeach
            @else
              <tr>
                <td colspan="3" class="px-6 py-10 text-center text-zinc-500 text-sm">
                  Aún no hay categorías registradas.
                </td>
              </tr>
            @endif
            </tbody>
          </table>
        </div>
      </div>
        <div class="mt-6">
          {{ $categories->links() }}
        </div>
    </div>
  </div>
  <livewire:category-delete-modal/>
</x-layouts.app>
