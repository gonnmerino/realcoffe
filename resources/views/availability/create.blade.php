<x-layouts.app :title="__('Nuevo Rango Horario')">
  <x-slot name="header">
  </x-slot>

  <div class="py-8">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

      <div class="mb-4">
        <a href="{{ route('availability.index') }}" class="text-sm text-zinc-400 hover:text-white transition-colors flex items-center gap-1">
          <x-lucide-arrow-left class="w-4 h-4 inline" />
          Volver a la lista
        </a>
      </div>

      <div class="bg-zinc-800 border border-zinc-700 rounded-xl shadow-sm overflow-hidden">
        <div class="border-b border-zinc-700 px-6 py-4">
          <h3 class="text-lg font-semibold text-white">
            Crear Rango de Disponibilidad
          </h3>
          <p class="text-sm text-zinc-400">
            Define el día/fecha y las horas en que el local estará abierto para recibir pedidos.
          </p>
        </div>

        <form
          action="{{ route('availability.store') }}"
          method="POST"
          class="p-6 space-y-6"
          x-data="{
            type: '{{ old('rule_type', 'day') }}',
            day: '{{ old('day_of_week', '') }}',
            date: '{{ old('specific_date', '') }}',
            setType(newType) {
              this.type = newType;
              if (newType === 'day') {
                this.date = '';
              } else {
                this.day = '';
              }
            }
          }">
          @csrf

          <input type="hidden" name="rule_type" :value="type">

          <div>
            <label class="block text-sm font-medium text-zinc-300 mb-2">
              Tipo de regla
            </label>
            <div class="grid grid-cols-2 gap-3 mb-4">
              <button
                type="button"
                @click="setType('day')"
                :class="type === 'day' ? 'border-[#D4A870] bg-zinc-900 text-white' : 'border-zinc-700 bg-zinc-900/50 text-zinc-400 hover:bg-zinc-700/30'"
                class="py-2.5 px-4 rounded-lg border text-sm font-medium transition cursor-pointer text-center">
                Día de la semana (Recurrente)
              </button>
              <button
                type="button"
                @click="setType('date')"
                :class="type === 'date' ? 'border-[#D4A870] bg-zinc-900 text-white' : 'border-zinc-700 bg-zinc-900/50 text-zinc-400 hover:bg-zinc-700/30'"
                class="py-2.5 px-4 rounded-lg border text-sm font-medium transition cursor-pointer text-center">
                Fecha específica (Puntual)
              </button>
            </div>

            <div x-show="type === 'day'">
              <label for="day_of_week" class="block text-sm font-medium text-zinc-300 mb-1">
                Día de la semana
              </label>
              <select
                name="day_of_week"
                id="day_of_week"
                x-model="day"
                class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-4 py-2 text-sm text-white focus:outline-none focus:ring-2"
                style="--tw-ring-color:#D4A870;">
                <option value="" disabled>Selecciona un día</option>
                <option value="1">Lunes</option>
                <option value="2">Martes</option>
                <option value="3">Miércoles</option>
                <option value="4">Jueves</option>
                <option value="5">Viernes</option>
                <option value="6">Sábado</option>
                <option value="0">Domingo</option>
              </select>
              @error('day_of_week')
              <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>

            <div x-show="type === 'date'" x-cloak>
              <label for="specific_date" class="block text-sm font-medium text-zinc-300 mb-1">
                Fecha
              </label>
              <input
                type="date"
                name="specific_date"
                id="specific_date"
                x-model="date"
                class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-4 py-2 text-sm text-white focus:outline-none focus:ring-2 color-scheme-dark"
                style="--tw-ring-color:#D4A870;">
              @error('specific_date')
              <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label for="open_time" class="block text-sm font-medium text-zinc-300 mb-1">
                Hora de Apertura
              </label>
              <input
                type="time"
                name="open_time"
                id="open_time"
                value="{{ old('open_time', '09:00') }}"
                required
                class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-4 py-2 text-sm text-white focus:outline-none focus:ring-2"
                style="--tw-ring-color:#D4A870;">
              @error('open_time')
              <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="close_time" class="block text-sm font-medium text-zinc-300 mb-1">
                Hora de Cierre
              </label>
              <input
                type="time"
                name="close_time"
                id="close_time"
                value="{{ old('close_time', '18:00') }}"
                required
                class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-4 py-2 text-sm text-white focus:outline-none focus:ring-2"
                style="--tw-ring-color:#D4A870;">
              @error('close_time')
              <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <div class="flex items-center space-x-3">
            <input
              type="checkbox"
              name="is_closed"
              id="is_closed"
              value="1"
              {{ old('is_closed') ? 'checked' : '' }}
              class="w-4 h-4 rounded border-zinc-700 bg-zinc-900 text-[#D4A870] focus:ring-0 focus:ring-offset-0 cursor-pointer">
            <label for="is_closed" class="text-sm font-medium text-zinc-300 cursor-pointer select-none">
              Marcar este rango como CERRADO (excepción/bloqueo)
            </label>
            @error('is_closed')
            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="pt-4 border-t border-zinc-700 flex justify-end space-x-3">
            <a
              href="{{ route('availability.index') }}"
              class="px-4 py-2 rounded-lg border border-zinc-600 hover:border-zinc-500 hover:bg-zinc-700 transition text-sm text-white font-medium">
              Cancelar
            </a>

            <button
              type="submit"
              class="px-4 py-2 rounded-lg font-semibold transition text-sm cursor-pointer shadow-sm"
              style="background:#D4A870;color:#221813;">
              Guardar Horario
            </button>
          </div>

        </form>
      </div>

    </div>
  </div>
</x-layouts.app>
