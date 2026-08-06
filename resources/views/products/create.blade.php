<x-layouts.app :title="__('Crear Producto')">
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Crear Producto') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">

        <div class="flex justify-between items-center mb-6">
          <h3 class="text-lg font-bold">Nuevo Producto</h3>
          <a href="{{ route('products.index') }}" class="text-sm text-zinc-400 hover:text-zinc-200 transition-colors">
            &larr; Volver a la lista
          </a>
        </div>

        <form action="{{ route('products.store') }}" method="POST" class="space-y-4" enctype="multipart/form-data">
          @csrf

          <div>
            <label for="name" class="block text-sm font-medium text-zinc-300 mb-1">Nombre del Producto</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required max="100"
                   class="w-full p-2 rounded-md border-zinc-700 bg-zinc-900 text-zinc-100 shadow-sm focus:border-zinc-500 focus:ring focus:ring-zinc-500/20">
            @error('name')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label for="description" class="block text-sm font-medium text-zinc-300 mb-1">Descripción</label>
            <textarea name="description" id="description" rows="3" required max="255"
                      class="w-full p-2 rounded-md border-zinc-700 bg-zinc-900 text-zinc-100 shadow-sm focus:border-zinc-500 focus:ring focus:ring-zinc-500/20">{{ old('description') }}</textarea>
            @error('description')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label for="price" class="block text-sm font-medium text-zinc-300 mb-1">Precio ($)</label>
              <input type="number" step="0.01" name="price" id="price" value="{{ old('price') }}" required
                     class="w-full p-2 rounded-md border-zinc-700 bg-zinc-900 text-zinc-100 shadow-sm focus:border-zinc-500 focus:ring focus:ring-zinc-500/20">
              @error('price')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="stock" class="block text-sm font-medium text-zinc-300 mb-1">Stock Inicial</label>
              <input type="number" name="stock" id="stock" value="{{ old('stock') }}" required
                     class="w-full p-2 rounded-md border-zinc-700 bg-zinc-900 text-zinc-100 shadow-sm focus:border-zinc-500 focus:ring focus:ring-zinc-500/20">
              @error('stock')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <div>
            <label for="category_id" class="block text-sm font-medium text-zinc-300 mb-1">Categoría</label>
            <select name="category_id" id="category_id"
                    class="w-full p-2 rounded-md border-zinc-700 bg-zinc-900 text-zinc-100 shadow-sm focus:border-zinc-500 focus:ring focus:ring-zinc-500/20">
              <option value="" disabled {{old('$category_id') ? '' : 'selected'}}>Seleccionar categoría...</option>
              @foreach($categories as $category)
                <option value="{{ $category->id }}"
                  {{ old('category_id') == $category->id ? 'selected' : '' }}>
                  {{ $category->name }}
                </option>
              @endforeach
            </select>
            @error('category_id')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="pt-2">
            <label class="inline-flex items-center cursor-pointer">
              <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
              class="rounded border-zinc-700 bg-zinc-900 text-zinc-500 focus:ring-zinc-500/20 focus:ring-offset-zinc-800">
              <span class="ml-2 text-sm font-medium text-zinc-300">Destacar producto (Mostrar en portada)</span>
            </label>
            @error('is_featured')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label for="image" class="block cursor-pointer text-sm font-medium text-zinc-300 mb-1">Imagen del Producto</label>
            <input type="file" name="image" id="image" accept="image/*"
                   class="w-full cursor-pointer text-sm text-zinc-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-zinc-700 file:text-zinc-200 hover:file:bg-zinc-600 cursor-pointer">
            @error('image')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="pt-4 flex justify-end">
            <button type="submit"
                    class="px-4 py-2 bg-zinc-100 cursor-pointer hover:bg-zinc-200 text-zinc-900 font-semibold rounded-md transition-all shadow-sm">
              Guardar Producto
            </button>
          </div>
        </form>

      </div>
    </div>
  </div>
</x-layouts.app>
