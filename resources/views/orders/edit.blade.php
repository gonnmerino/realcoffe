<x-layouts.app :title="__('Cambiar Estado de Pedido')">
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Estado del Pedido') }}
    </h2>
  </x-slot>

  <h2 class="text-7xl font-bold italic">Pedido de #{{ $order->user->name }}</h2>

  <div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div
          class="md:col-span-2 bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
          <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-bold">Cambiar Estado</h3>
            <a href="{{ route('orders.index') }}" class="text-sm text-zinc-400 hover:text-zinc-200 transition-colors">
              &larr; Volver a la lista
            </a>
          </div>

          <form action="{{ route('orders.update', $order->id)}}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            @php
              $lastChange = $order->purchase_order_history->last();
              $currentStatusString = $lastChange?->order_status ?? 'Pendiente';

              $statusStyles = [
                'Cancelado' => ['label' => 'Cancelado', 'class' => 'text-red-400'],
                'Pendiente' => ['label' => 'Pendiente', 'class' => 'text-orange-300'],
                'En preparación' => ['label' => 'En preparación', 'class' => 'text-yellow-300'],
                'Disponible' => ['label' => 'Disponible', 'class' => 'text-emerald-400'],
                'Entregado' => ['label' => 'Entregado', 'class' => 'text-green-400'],
              ];

              $status = $statusStyles[$currentStatusString] ?? ['label' => $currentStatusString, 'class' => 'text-zinc-300'];

              $totalProductsCount = $order->product_purchase_order?->sum('quantity') ?? 0;
            @endphp

            <div>
              <label class="block text-sm font-medium text-zinc-300 mb-3">Seleccionar nuevo estado</label>
              <div class="space-y-2">
                @foreach($statuses as $value => $label)
                  <label
                    class="relative flex items-center cursor-pointer group select-none py-3 px-4 rounded-lg border transition-all duration-200 border-zinc-700/50 bg-zinc-900/30 hover:bg-zinc-700/10">

                    <input
                      type="radio"
                      name="order_status"
                      value="{{ $value }}"
                      {{ old('order_status', $currentStatusString) == $value ? 'checked' : '' }}
                      class="sr-only peer">

                    <div class="w-4 h-4 rounded-full border-2 border-zinc-600 flex items-center justify-center transition-all duration-200
                      peer-checked:border-[#D4A870]">
                      <div
                        class="w-2 h-2 rounded-full bg-transparent peer-checked:bg-[#D4A870] transition-colors duration-200"></div>
                    </div>

                    <span
                      class="text-sm font-medium ml-3 transition-colors duration-200 group-hover:text-zinc-200">
                      {{ $label }}
                    </span>

                    <div
                      class="absolute inset-0 border border-transparent peer-checked:border-zinc-500 rounded-lg pointer-events-none transition-all duration-200"></div>
                  </label>
                @endforeach
              </div>

              @if(session()->has('error'))
              <p class="text-red-500 text-xs mt-2">{{ session('error') }}</p>
              @endif
            </div>

            <div>
              <label for="notes" class="block text-sm font-medium text-zinc-300 mb-1">Notas / Comentarios
                (Opcional)</label>
              <textarea name="notes" id="notes" rows="3" placeholder="Escribe un motivo o aclaración..."
                        class="w-full p-2 rounded-md border-zinc-700 bg-zinc-900 text-zinc-100 shadow-sm focus:border-zinc-500 focus:ring focus:ring-zinc-500/20 text-sm">{{ old('notes') }}</textarea>
              @error('notes')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>

            <div class="pt-4 border-t border-zinc-700/50 flex justify-end">
              <button type="submit"
                      class="px-4 py-2 bg-zinc-100 cursor-pointer hover:bg-zinc-200 text-zinc-900 font-semibold rounded-md transition-all shadow-sm">
                Actualizar Estado
              </button>
            </div>
          </form>
        </div>

        <div class="space-y-4">
          <div
            class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
            <h3 class="text-md font-bold mb-4 border-b border-zinc-700/50 pb-2">Última Actividad</h3>

            @if($lastChange)
              <div class="space-y-3">
                <div>
                  <span class="block text-xs text-zinc-500 uppercase font-semibold">Estado Actual</span>
                  <span class="text-sm font-semibold text-[#D4A870]">{{ $lastChange->order_status }}</span>
                </div>
                <div>
                  <span class="block text-xs text-zinc-500 uppercase font-semibold">Modificado por</span>
                  <span class="text-sm text-zinc-300">{{ $lastChange->user?->name ?? 'Sin datos de empleado' }}</span>
                </div>
                <div>
                  <span class="block text-xs text-zinc-500 uppercase font-semibold">Fecha y Hora</span>
                  <span class="text-sm text-zinc-300">{{ $lastChange->created_at->format('d/m/y H:i') }}</span>
                  <span class="block text-[11px] text-zinc-500">({{ $lastChange->created_at->diffForHumans(null, true) }})</span>
                </div>
              </div>
            @else
              <p class="text-xs text-zinc-500">No hay registros previos en el historial de esta orden.</p>
            @endif
          </div>

          <div
            class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
            <h3 class="text-md font-bold mb-4 border-b border-zinc-700/50 pb-2">Historial de Cambios</h3>

            <div class="relative pl-4 border-l-2 border-zinc-700 space-y-6">
              @forelse($order->purchase_order_history->reverse() as $history)
                <div class="relative">
                  <div
                    class="absolute -left-[21px] top-1.5 w-2 h-2 rounded-full bg-zinc-500 border border-zinc-800"></div>

                  <div class="flex flex-col">
                    <span class="text-xs font-semibold text-zinc-300">{{ $history->order_status }}</span>
                    <span
                      class="text-[11px] text-zinc-500">Por: {{ $history->user?->name ?? 'Sin datos de empleado' }}</span>
                    <span class="text-[10px] text-zinc-600">{{ $history->created_at->format('d/m/y H:i') }}</span>

                    @if($history->notes)
                      <p class="text-xs text-zinc-400 mt-1 italic bg-zinc-900/30 p-2 rounded border border-zinc-700/30">
                        "{{ $history->notes }}"
                      </p>
                    @endif
                  </div>
                </div>
              @empty
                <p class="text-xs text-zinc-500 pl-2">Sin historial registrado.</p>
              @endforelse
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</x-layouts.app>
