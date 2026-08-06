<x-layouts.app :title="__('Editar Producto')">
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Editar Producto') }}
    </h2>
  </x-slot>
  <h2 class="text-7xl font-bold italic">{{ $product->name }}</h2>
  <div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
        <div class="flex justify-between items-center mb-6">
          <h3 class="text-lg font-bold">Edicion</h3>
          <a href="{{ route('products.index') }}" class="text-sm text-zinc-400 hover:text-zinc-200 transition-colors">
            &larr; Volver a la lista
          </a>
        </div>

        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
          @csrf
          @method('PUT')

          <div>
            <label for="name" class="block text-sm font-medium text-zinc-300 mb-1">Nombre del Producto</label>
            <input type="text" name="name" id="name"
                   value="{{ old('name', $product->name) }}" required max="100"
                   class="w-full p-2 rounded-md border-zinc-700 bg-zinc-900 text-zinc-100 shadow-sm focus:border-zinc-500 focus:ring focus:ring-zinc-500/20">
            @error('name')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label for="description" class="block text-sm font-medium text-zinc-300 mb-1">Descripción</label>
            <textarea name="description" id="description" rows="3" required max="255"
                      class="w-full p-2 rounded-md border-zinc-700 bg-zinc-900 text-zinc-100 shadow-sm focus:border-zinc-500 focus:ring focus:ring-zinc-500/20">{{ old('description', $product->description) }}</textarea>
            @error('description')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label for="price" class="block text-sm font-medium text-zinc-300 mb-1">Precio ($)</label>
              <input type="number" step="0.01" name="price" id="price"
                     value="{{ old('price', $product->price) }}" required
                     class="w-full p-2 rounded-md border-zinc-700 bg-zinc-900 text-zinc-100 shadow-sm focus:border-zinc-500 focus:ring focus:ring-zinc-500/20">
              @error('price')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="stock" class="block text-sm font-medium text-zinc-300 mb-1">Stock</label>
              <input type="number" name="stock" id="stock" min="0"
                     value="{{ old('stock', $product->stock) }}" required
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
              @foreach($categories as $category)
                <option value="{{ $category->id }}"
                  {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                  {{ $category->name }}
                </option>
              @endforeach
            </select>
            @error('category_id')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="border-t border-zinc-700/50 pt-4">
            <label class="block text-sm font-medium text-zinc-300 mb-2">Imagen del Producto</label>

            <div class="flex items-start space-x-6">
              <div class="w-24 h-24 rounded-lg bg-zinc-900 border border-zinc-700 overflow-hidden flex-shrink-0">
                @if($product->image?->path)
                  <img src="{{ Storage::url($product->image->path) }}"
                       alt="{{ $product->image->alt }}"
                       id=""
                       class="w-full h-full object-cover">
                @else
                  <div class="w-full h-full flex items-center justify-center text-[10px] text-zinc-600">
                    Sin foto
                  </div>
                @endif
              </div>

              <div class="flex-1">
                <p class="text-xs text-zinc-400 mb-2">Selecciona un archivo si quieres reemplazar la imagen actual:</p>
                <input type="file" name="image" id="image" accept="image/*"
                       class="w-full text-sm text-zinc-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-zinc-700 file:text-zinc-200 hover:file:bg-zinc-600 cursor-pointer">
                @error('image')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
              </div>
            </div>
          </div>

          <div class="pt-2">
            <label class="inline-flex items-center cursor-pointer">
              <input type="checkbox" name="is_featured" value="1"
                     {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                     class="rounded border-zinc-700 bg-zinc-900 text-zinc-500 focus:ring-zinc-500/20 focus:ring-offset-zinc-800">
              <span class="ml-2 text-sm font-medium text-zinc-300">Destacar producto (Mostrar en portada)</span>
            </label>
            @error('is_featured')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="pt-4 flex justify-end">
            <button type="submit"
                    class="px-4 py-2 bg-zinc-100 cursor-pointer hover:bg-zinc-200 text-zinc-900 font-semibold rounded-md transition-all shadow-sm">
              Actualizar Producto
            </button>
          </div>
        </form>

      </div>
    </div>
  </div>
</x-layouts.app>
