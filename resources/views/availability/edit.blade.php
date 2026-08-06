<x-layouts.app :title="__('Editar Rango Horario')">
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Editar Rango Horario') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">

        <div class="flex justify-between items-center mb-6">
          <h3 class="text-lg font-bold">Editar Rango</h3>
          <a href="{{ route('availability.index') }}" class="text-sm text-zinc-400 hover:text-zinc-200 transition-colors">
            &larr; Volver a la lista
          </a>
        </div>

        <form
          action="{{ route('availability.update', $schedule->id) }}"
          method="POST"
          class="space-y-4"
          x-data="{
            type: '{{ old('rule_type', $schedule->specific_date ? 'date' : 'day') }}',
            day: '{{ old('day_of_week', $schedule->day_of_week) }}',
            date: '{{ old('specific_date', $schedule->specific_date) }}',
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
          @method('PUT')

          <input type="hidden" name="rule_type" :value="type">

          <div>
            <label class="block text-sm font-medium text-zinc-300 mb-1">Tipo de regla</label>
            <div class="grid grid-cols-2 gap-3 mb-2">
              <button
                type="button"
                @click="setType('day')"
                :class="type === 'day'
                  ? 'border-zinc-500 bg-zinc-700 text-white'
                  : 'border-zinc-700 bg-zinc-900 text-zinc-400 hover:bg-zinc-800'"
                class="p-2 rounded-md border text-sm font-medium transition cursor-pointer text-center">
                Día de la semana
              </button>

              <button
                type="button"
                @click="setType('date')"
                :class="type === 'date'
                  ? 'border-zinc-500 bg-zinc-700 text-white'
                  : 'border-zinc-700 bg-zinc-900 text-zinc-400 hover:bg-zinc-800'"
                class="p-2 rounded-md border text-sm font-medium transition cursor-pointer text-center">
                Fecha específica
              </button>
            </div>
          </div>

          <div x-show="type === 'day'">
            <label for="day_of_week" class="block text-sm font-medium text-zinc-300 mb-1">Día de la semana</label>
            <select name="day_of_week" id="day_of_week" x-model="day"
                    class="w-full p-2 rounded-md border-zinc-700 bg-zinc-900 text-zinc-100 shadow-sm focus:border-zinc-500 focus:ring focus:ring-zinc-500/20">
              <option value="" disabled>Seleccionar día...</option>
              <option value="1">Lunes</option>
              <option value="2">Martes</option>
              <option value="3">Miércoles</option>
              <option value="4">Jueves</option>
              <option value="5">Viernes</option>
              <option value="6">Sábado</option>
              <option value="0">Domingo</option>
            </select>
            @error('day_of_week')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div x-show="type === 'date'" x-cloak>
            <label for="specific_date" class="block text-sm font-medium text-zinc-300 mb-1">Fecha</label>
            <input type="date" name="specific_date" id="specific_date" x-model="date"
                   class="w-full p-2 rounded-md border-zinc-700 bg-zinc-900 text-zinc-100 shadow-sm focus:border-zinc-500 focus:ring focus:ring-zinc-500/20">
            @error('specific_date')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label for="open_time" class="block text-sm font-medium text-zinc-300 mb-1">Hora de Apertura</label>
              <input type="time" name="open_time" id="open_time"
                     value="{{ old('open_time', \Carbon\Carbon::parse($schedule->open_time)->format('H:i')) }}" required
                     class="w-full p-2 rounded-md border-zinc-700 bg-zinc-900 text-zinc-100 shadow-sm focus:border-zinc-500 focus:ring focus:ring-zinc-500/20">
              @error('open_time')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="close_time" class="block text-sm font-medium text-zinc-300 mb-1">Hora de Cierre</label>
              <input type="time" name="close_time" id="close_time"
                     value="{{ old('close_time', \Carbon\Carbon::parse($schedule->close_time)->format('H:i')) }}" required
                     class="w-full p-2 rounded-md border-zinc-700 bg-zinc-900 text-zinc-100 shadow-sm focus:border-zinc-500 focus:ring focus:ring-zinc-500/20">
              @error('close_time')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <div class="pt-2">
            <label class="inline-flex items-center cursor-pointer">
              <input type="checkbox" name="is_closed" value="1"
                     {{ old('is_closed', $schedule->is_closed) ? 'checked' : '' }}
                     class="rounded border-zinc-700 bg-zinc-900 text-zinc-500 focus:ring-zinc-500/20 focus:ring-offset-zinc-800">
              <span class="ml-2 text-sm font-medium text-zinc-300">Marcar como día / horario CERRADO</span>
            </label>
            @error('is_closed')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="pt-4 flex justify-end">
            <button type="submit"
                    class="px-4 py-2 bg-zinc-100 cursor-pointer hover:bg-zinc-200 text-zinc-900 font-semibold rounded-md transition-all shadow-sm">
              Actualizar Horario
            </button>
          </div>
        </form>

      </div>
    </div>
  </div>
</x-layouts.app>
