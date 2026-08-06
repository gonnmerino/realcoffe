<x-layouts.app :title="__('Disponibilidad y Horarios')">
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
              Gestión de disponibilidad
            </h3>
            <p class="text-sm text-zinc-400">
              {{ count($availabilities) }} rangos horarios registrados
            </p>
          </div>

          <div class="flex flex-row gap-4">
            <a
              class="px-3 py-1.5 rounded-lg border cursor-pointer border-zinc-600 hover:border-zinc-500 hover:bg-zinc-700 transition text-sm text-white"
              href="{{ route('availability.create') }}">
              Nuevo Rango
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
              <th class="px-6 py-4">Día / Fecha</th>
              <th class="px-6 py-4">Horario</th>
              <th class="px-6 py-4">Estado</th>
              <th class="px-6 py-4 text-right">Acciones</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-zinc-700">
            @php
              $dayNames = [
                0 => 'Domingo',
                1 => 'Lunes',
                2 => 'Martes',
                3 => 'Miércoles',
                4 => 'Jueves',
                5 => 'Viernes',
                6 => 'Sábado',
              ];
            @endphp

            @forelse($availabilities as $availability)
              <tr class="hover:bg-zinc-700/40 transition">

                <td class="px-6 py-4">
                  @if($availability->specific_date)
                    @php $parsed = \Carbon\Carbon::parse($availability->specific_date); @endphp
                    <div class="font-medium text-white">
                      {{ $dayNames[$parsed->dayOfWeek] }}
                      <span class="text-xs text-zinc-400">({{ $parsed->format('d/m/Y') }})</span>
                    </div>
                    <div class="text-xs text-yellow-300">Fecha puntual</div>
                  @else
                    <div class="font-medium text-white">
                      {{ $dayNames[$availability->day_of_week] ?? 'Día ' . $availability->day_of_week }}
                    </div>
                    <div class="text-xs text-zinc-500">
                      Todos los {{ strtolower($dayNames[$availability->day_of_week] ?? '') }}s
                    </div>
                  @endif
                </td>

                <td class="px-6 py-4">
                    <span class="text-zinc-300 text-sm font-medium font-mono">
                      {{ \Carbon\Carbon::parse($availability->open_time)->format('H:i') }} hs
                      &ndash;
                      {{ \Carbon\Carbon::parse($availability->close_time)->format('H:i') }} hs
                    </span>
                </td>

                <td class="px-6 py-4">
                  @if($availability->is_closed)
                    <span class="px-3 py-1 rounded-full text-xs bg-red-500/15 text-red-400">
                        Cerrado
                      </span>
                  @else
                    <span class="px-3 py-1 rounded-full text-xs bg-green-500/15 text-green-400">
                        Habilitado
                      </span>
                  @endif
                </td>

                <td class="px-6 py-4 text-right space-x-2">
                  <form
                    action="{{ route('availability.destroy', $availability->id) }}"
                    method="POST"
                    class="inline-block"
                    onsubmit="return confirm('¿Eliminar este rango?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-3 py-1.5 rounded-lg cursor-pointer bg-red-900/60 text-white hover:bg-red-900 transition text-sm">
                      Eliminar
                    </button>
                  </form>

                  <a href="{{ route('availability.edit', $availability->id) }}"
                     class="px-3 py-1.5 rounded-lg border cursor-pointer border-zinc-600 hover:border-zinc-500 hover:bg-zinc-700 transition text-sm text-white">
                    Editar
                  </a>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="px-6 py-10 text-center text-zinc-500 text-sm">
                  Aún no hay horarios o fechas registradas.
                </td>
              </tr>
            @endforelse
            </tbody>
          </table>
        </div>
      </div>
        <div class="mt-6">
          {{ $availabilities->links() }}
        </div>
    </div>
  </div>
</x-layouts.app>
