<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrder_History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;
use App\Models\StoreSchedule;
use Carbon\Carbon;

class OrderController extends Controller
{
  private array $allowedRoles = [
    'Cajero' => ['En preparación', 'Cancelado'],
    'Cocina' => ['Disponible', 'Cancelado'],
    'Cafeteria' => ['Entregado'],
    'Administrador' => ['Pendiente', 'En preparación', 'Disponible', 'Entregado', 'Cancelado']
  ];

  public function index()
  {
    $orders = PurchaseOrder::with([
      'latestHistory.user',
      'user',
      'product_purchase_order.product'
    ])->paginate(6);

    return view('orders.index', compact('orders'));
  }

  public function edit($id)
  {
    $order = PurchaseOrder::with([
      'latestHistory.user',
      'purchase_order_history' => function ($query) {
        $query->latest();
      },
      'user',
      'product_purchase_order.product'
    ])->findOrFail($id);

    $userRoleNames = auth()->user()->roles->pluck('name')->toArray();
    $allowedStatuses = [];

    foreach ($userRoleNames as $roleName) {
      if (isset($this->allowedRoles[$roleName])) {
        $allowedStatuses = array_merge($allowedStatuses, $this->allowedRoles[$roleName]);
      }
    }

    $allowedStatuses = array_unique($allowedStatuses);
    $statuses = array_combine($allowedStatuses, $allowedStatuses);

    return view('orders.edit', compact('order', 'statuses'));
  }

  public function update(Request $request, $id)
  {
    $order = PurchaseOrder::findOrFail($id);

    $request->validate([
      'order_status' => 'required|string',
      'notes' => 'nullable|string'
    ]);

    $newStatus = $request->order_status;
    $user = auth()->user();
    $userRoleNames = $user->roles->pluck('name')->toArray();

    $userAllowedStatuses = [];
    foreach ($userRoleNames as $roleName) {
      if (isset($this->allowedRoles[$roleName])) {
        $userAllowedStatuses = array_merge($userAllowedStatuses, $this->allowedRoles[$roleName]);
      }
    }

    $userAllowedStatuses = array_unique($userAllowedStatuses);
    $hasPermission = in_array($newStatus, $userAllowedStatuses);

    if (!$hasPermission) {
      $rolesText = strtoupper(implode(', ', $userRoleNames));
      $statusesText = strtoupper(implode(', ', $userAllowedStatuses));

      return back()->with('error', "Con tu rol ($rolesText) solo puedes cambiar a: $statusesText.");
    }

    $order->purchase_order_history()->create([
      'user_id' => $user->id,
      'order_status' => $newStatus,
      'notes' => $request->notes
    ]);

    return redirect()->route('orders.index')
      ->with('success', 'Orden actualizada correctamente');
  }

  public function store(Request $request)
  {
    $request->validate([
      'notes' => 'nullable|string|max:500',
    ]);

    $now = Carbon::now();
    $currentDate = $now->toDateString();
    $currentDayOfWeek = $now->dayOfWeek;
    $currentTime = $now->toTimeString();

    $specialSchedule = StoreSchedule::where('specific_date', $currentDate)->first();

    if ($specialSchedule) {
      if ($specialSchedule->is_closed) {
        return back()->with('error', 'El local se encuentra cerrado hoy por excepción.');
      }
      if ($currentTime < $specialSchedule->open_time || $currentTime > $specialSchedule->close_time) {
        return back()->with('error', "Fuera de horario. Hoy abrimos de {$specialSchedule->open_time} a {$specialSchedule->close_time}.");
      }
    } else {
      $regularSchedule = StoreSchedule::where('day_of_week', $currentDayOfWeek)
        ->whereNull('specific_date')
        ->first();

      if ($regularSchedule) {
        if ($regularSchedule->is_closed) {
          return back()->with('error', 'El local permanece cerrado los días como hoy.');
        }
        if ($currentTime < $regularSchedule->open_time || $currentTime > $regularSchedule->close_time) {
          return back()->with('error', "Fuera de horario de atención. Horario actual del local: {$regularSchedule->open_time} a {$regularSchedule->close_time}.");
        }
      } else {
        return back()->with('error', 'No hay horarios de atención configurados para el día de hoy.');
      }
    }

    $cart = session()->get('cart', []);

    if (empty($cart)) {
      return redirect()->route('homepage')->with('error', 'Tu carrito está vacío.');
    }

    $user = auth()->user();
    $totalPrice = array_reduce($cart, fn($sum, $item) => $sum + ($item['price'] * $item['qty']), 0);
    $pickupCode = 'RC-' . strtoupper(substr(uniqid(), -4));

    DB::transaction(function () use ($cart, $totalPrice, $pickupCode, $user, $request) {
      $order = PurchaseOrder::create([
        'user_id' => $user->id,
        'order_status' => 'Pendiente',
        'pickup_code' => $pickupCode,
        'total_price' => $totalPrice,
        'notes' => $request->notes,
      ]);

      foreach ($cart as $productId => $item) {
        $order->product_purchase_order()->create([
          'product_id' => $productId,
          'quantity' => $item['qty'],
          'price' => $item['price'],
        ]);
      }

      $order->purchase_order_history()->create([
        'user_id' => $user->id,
        'status' => 'Pendiente',
        'notes' => 'Pedido creado por el cliente desde la web.',
      ]);

      session()->forget('cart');
    });

    return redirect()->route('homepage')->with('success_order', 'Pedido realizado con exito!');
  }
}
