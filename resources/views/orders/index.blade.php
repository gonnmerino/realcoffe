<x-layouts.app :title="__('Lista de pedidos')">
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-2xl font-bold text-white">
          Pedidos
        </h2>
        <p class="text-sm text-zinc-400 mt-1">
          Administra y realiza el seguimiento de las órdenes de compra.
        </p>
      </div>
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
              Lista de pedidos
            </h3>
            <p class="text-sm text-zinc-400">
              {{ count($orders) }} pedidos registrados
            </p>
          </div>
          <div class="flex flex-row gap-4">
            <select
              class="bg-zinc-900 border border-zinc-700 rounded-lg px-4 py-2 text-sm text-white focus:outline-none focus:ring-2"
              style="--tw-ring-color:#D4A870;">
              <option value="">Todos los estados</option>
              <option value="pendiente">Pendiente</option>
              <option value="en_preparacion">En preparación</option>
              <option value="listo">Listo para retirar</option>
              <option value="entregado">Entregado</option>
              <option value="cancelado">Cancelado</option>
            </select>

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
              <th class="px-6 py-4">Pedido</th>
              <th class="px-6 py-4">Cliente</th>
              <th class="px-6 py-4">Productos</th>
              <th class="px-6 py-4">Total</th>
              <th class="px-6 py-4">Estado</th>
              <th class="px-6 py-4 text-right">Acciones</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-zinc-700">
            @if(count($orders) > 0)
              @foreach($orders as $order)
                @php
                  $lastChange = $order->purchase_order_history->last();

                  $currentStatusString = $lastChange?->order_status ?? 'Pendiente';

                  $statusStyles = [
                    'Cancelado' => ['label' => 'Cancelado', 'class' => 'text-red-400'],
                    'Pendiente' => ['label' => 'Pendiente', 'class' => 'text-orange-300'],
                    'En preparación' => ['label' => 'En preparación', 'class' => 'text-yellow-300'],
                    'Listo para retirar' => ['label' => 'Listo para retirar', 'class' => 'text-blue-400'],
                    'Entregado' => ['label' => 'Entregado', 'class' => 'text-green-400'],
                  ];

                  $status = $statusStyles[$currentStatusString] ?? ['label' => $currentStatusString, 'class' => 'text-zinc-300'];
                  $totalProductsCount = $order->product_purchase_order?->sum('quantity') ?? 0;
                @endphp
                <tr class="hover:bg-zinc-700/40 transition">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center space-x-3">
                      <div class="w-10 h-10 rounded bg-zinc-900 border border-zinc-700 flex items-center justify-center flex-shrink-0 text-zinc-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.119-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                      </div>
                      <div>
                        <div class="font-medium text-white">
                          #{{ $order->pickup_code }}
                        </div>
                        @php

                        @endphp
                        <div class="text-xs text-zinc-500 mt-0.5">
                            Hace {{ $order->created_at->diffForHumans(null, true) }}
                        </div>
                      </div>
                    </div>
                  </td>

                  <td class="px-6 py-4">
                    <div class="font-medium text-white">
                      {{ $order->user->name }}
                    </div>
                    <div class="text-xs text-zinc-500">
                      {{ $order->user->email }}
                    </div>
                  </td>

                  <td class="px-6 py-4">
                    <div class="space-y-1">
                      @forelse($order->product_purchase_order as $detail)
                        <div class="flex items-center gap-1.5 text-zinc-300">
                            <span class="font-mono text-amber-400 font-medium">
                              {{ $detail->quantity }}×
                            </span>
                          <span class="truncate max-w-[220px]">
                              {{ $detail->product->name ?? 'Producto eliminado' }}
                            </span>
                        </div>
                      @empty
                        <span class="text-xs text-zinc-500">Sin productos asociados</span>
                      @endforelse
                    </div>
                    @if($totalProductsCount > 0)
                      <div class="text-xs text-zinc-500 mt-1.5">
                        {{ $totalProductsCount }} {{ $totalProductsCount === 1 ? 'producto' : 'productos' }} en total
                      </div>
                    @endif
                  </td>

                  <td class="px-6 py-4 whitespace-nowrap">
                      <span class="font-semibold text-lg" style="color:#D4A870;">
                        ${{ number_format($order->total_price, 2) }}
                      </span>
                  </td>

                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex flex-col">
                        <span class="font-semibold text-sm {{ $status['class'] }}">
                          {{ $status['label'] }}
                        </span>
                      <span class="text-xs text-zinc-500 mt-0.5">
                          Hace {{ $lastChange?->created_at?->diffForHumans(null, true) ?? $order->updated_at->diffForHumans(null, true) }}
                        </span>
                      @if($lastChange)
                        <span class="text-[10px] text-zinc-500">
                            por {{ $lastChange->user->name ?? 'Sistema' }}
                          </span>
                      @endif
                    </div>
                  </td>

                  <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">

                    <a href="{{route('orders.edit', $order->id)}}"
                      class="px-4 py-6 rounded-lg cursor-pointer transition text-sm font-semibold inline-block text-center"
                      style="background:#D4A870;color:#221813;">
                      Cambiar estado
                    </a>
                  </td>
                </tr>
              @endforeach
            @else
              <tr>
                <td colspan="6" class="px-6 py-10 text-center text-zinc-500 text-sm">
                  Aún no hay pedidos registrados.
                </td>
              </tr>
            @endif
            </tbody>
          </table>
        </div>
      </div>
        <div class="mt-6">
          {{ $orders->links() }}
        </div>
    </div>
  </div>
</x-layouts.app>
