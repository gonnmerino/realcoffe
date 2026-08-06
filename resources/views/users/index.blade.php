<x-layouts.app :title="__('Lista de usuarios')">
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
              Lista de usuarios
            </h3>
            <p class="text-sm text-zinc-400">
              {{ count($users) }} usuarios registrados
            </p>
          </div>
          <div class="flex flex-row gap-4">

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
              <th class="px-6 py-4">Usuario</th>
              <th class="px-6 py-4">Rol/es</th>
              <th class="px-6 py-4">Estado</th>
              <th class="px-6 py-4 text-right">Acciones</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-zinc-700">
            @if(count($users) > 0)
              @foreach($users as $user)
                <tr class="hover:bg-zinc-700/40 transition">
                  <td class="px-6 py-4">
                    <div class="flex items-center space-x-3">
                      <div class="w-10 h-10 rounded-full bg-zinc-900 border border-zinc-700 flex items-center justify-center flex-shrink-0 text-zinc-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                          <path d="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0ZM4 20c0-3.3 3.6-6 8-6s8 2.7 8 6"/>
                        </svg>
                      </div>
                      <div>
                        <div class="font-medium text-white">
                          {{ $user->name }}
                        </div>
                        <div class="text-xs text-zinc-500">
                          {{ $user->email }}
                        </div>
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4">
                    <div class="flex flex-wrap gap-1.5">
                      @forelse($user->roles as $role)
                        <span class="px-3 py-1 rounded-full text-xs bg-zinc-700 text-zinc-300 border border-zinc-600">
                          {{ $role->name }}
                        </span>
                      @empty
                        <span class="text-xs text-zinc-500">Sin rol asignado</span>
                      @endforelse
                    </div>
                  </td>
                  <td class="px-6 py-4">
                    <div class="flex flex-wrap gap-1.5">
                      @if($user->is_active == 1)
                        <span class="text-emerald-400 font-semibold px-3 py-1 rounded-full text-xs bg-zinc-700 border border-zinc-600">Ok</span>
                      @else
                        <span class="text-red-400 px-3 font-semibold py-1 rounded-full text-xs bg-zinc-700 border border-zinc-600">Cuenta bloqueada</span>
                      @endif
                    </div>
                  </td>
                  <td class="px-6 py-4 text-right space-x-2">
                    <button
                      onclick="Livewire.dispatch('openDeleteModal', { id: {{ $user->id }}, email: '{{ addslashes($user->email) }}', name: '{{ addslashes($user->name) }}' })"
                      class="px-3 py-1.5 rounded-lg cursor-pointer bg-red-900/60 text-white transition text-sm">
                      Bloquear cuenta
                    </button>
                    <a href="{{ route('users.edit', $user->id) }}"
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
                  Aún no hay usuarios registrados.
                </td>
              </tr>
            @endif
            </tbody>
          </table>
        </div>
      </div>
        <div class="mt-6">
          {{ $users->links() }}
        </div>
    </div>
  </div>
  <livewire:user-blocked-modal />
</x-layouts.app>
