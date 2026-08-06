<x-layouts.app :title="__('Editar Usuario')">
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Editar Usuario') }}
    </h2>
  </x-slot>
  <div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
        <div class="flex justify-between items-center mb-6">
          <h3 class="text-lg font-bold">Edicion de cuentas</h3>
          <a href="{{ route('users.index') }}" class="text-sm text-zinc-400 hover:text-zinc-200 transition-colors">
            &larr; Volver a la lista
          </a>
        </div>

        <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
          @csrf
          @method('PUT')

          <div>
            <label for="name" class="block text-sm font-medium text-zinc-300 mb-1">Nombre</label>
            <input type="text" name="name" id="name"
                   value="{{ old('name', $user->name) }}" required max="100"
                   class="w-full p-2 rounded-md border-zinc-700 bg-zinc-900 text-zinc-100 shadow-sm focus:border-zinc-500 focus:ring focus:ring-zinc-500/20">
            @error('name')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label for="email" class="block text-sm font-medium text-zinc-300 mb-1">Email</label>
            <input type="text" name="email" id="email"
                   value="{{ old('email', $user->email) }}" required max="100"
                   class="w-full p-2 rounded-md border-zinc-700 bg-zinc-900 text-zinc-100 shadow-sm focus:border-zinc-500 focus:ring focus:ring-zinc-500/20">
            @error('name')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="pt-2">
            <label class="inline-flex items-center cursor-pointer">
              <input type="checkbox" name="is_active" value="1" {{ old('is_active', !$user->is_active) ? 'checked' : '' }}
              class="rounded border-zinc-700 bg-zinc-900 text-zinc-500 focus:ring-zinc-500/20 focus:ring-offset-zinc-800">
              <span class="ml-2 text-sm font-medium text-zinc-300">¿Cuenta bloqueada?</span>
            </label>
            @error('is_active')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="pt-4 flex justify-end">
            <button type="submit"
                    class="px-4 py-2 bg-zinc-100 cursor-pointer hover:bg-zinc-200 text-zinc-900 font-semibold rounded-md transition-all shadow-sm">
              Guardar Cambios
            </button>
          </div>
        </form>

      </div>
    </div>
  </div>
</x-layouts.app>
