<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StoreSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StorefrontController extends Controller
{
  private function checkStoreOpen()
  {
    $now = Carbon::now();
    $currentDate = $now->toDateString();
    $currentDayOfWeek = $now->dayOfWeek;
    $currentTime = $now->toTimeString();

    $specialSchedule = StoreSchedule::where('specific_date', $currentDate)->first();

    if ($specialSchedule) {
      if ($specialSchedule->is_closed) {
        return ['isClosed' => true, 'message' => 'El local se encuentra cerrado hoy por excepción.'];
      }
      if ($currentTime < $specialSchedule->open_time || $currentTime > $specialSchedule->close_time) {
        $openTime = substr($specialSchedule->open_time, 0, 5);
        $closeTime = substr($specialSchedule->close_time, 0, 5);
        return ['isClosed' => true, 'message' => "Fuera de horario. Hoy abrimos de {$openTime} a {$closeTime}."];
      }
    } else {
      $regularSchedule = StoreSchedule::where('day_of_week', $currentDayOfWeek)
        ->whereNull('specific_date')
        ->first();

      if ($regularSchedule) {
        if ($regularSchedule->is_closed) {
          return ['isClosed' => true, 'message' => 'El local permanece cerrado los días como hoy.'];
        }
        if ($currentTime < $regularSchedule->open_time || $currentTime > $regularSchedule->close_time) {
          $nextOpenDay = null;
          $daysNames = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];

          for ($i = 1; $i <= 7; $i++) {
            $checkDayOfWeek = ($currentDayOfWeek + $i) % 7;
            $scheduleCheck = StoreSchedule::where('day_of_week', $checkDayOfWeek)
              ->whereNull('specific_date')
              ->first();

            if ($scheduleCheck && !$scheduleCheck->is_closed) {
              $dayName = ($i === 1) ? 'mañana' : 'el ' . $daysNames[$checkDayOfWeek];
              $openTime = substr($scheduleCheck->open_time, 0, 5);
              $closeTime = substr($scheduleCheck->close_time, 0, 5);
              $nextOpenDay = "{$dayName} de {$openTime} a {$closeTime}";
              break;
            }
          }

          $message = $nextOpenDay
            ? "Fuera de horario de atención. Abrimos {$nextOpenDay}."
            : "Fuera de horario de atención.";

          return ['isClosed' => true, 'message' => $message];
        }
      } else {
        return ['isClosed' => true, 'message' => 'No hay horarios de atención configurados para el día de hoy.'];
      }
    }

    return ['isClosed' => false, 'message' => ''];
  }

  public function index()
  {
    $products = Product::all();
    $schedule = $this->checkStoreOpen();

    return view('homepage', compact('products', 'schedule'));
  }

  public function add(Product $product)
  {
    $schedule = $this->checkStoreOpen();

    if ($schedule['isClosed']) {
      return back()->with('error', 'No se pueden añadir productos: ' . $schedule['message']);
    }

    $cart = session()->get('cart', []);

    if (isset($cart[$product->id])) {
      $cart[$product->id]['qty']++;
    } else {
      $cart[$product->id] = [
        'name' => $product->name,
        'price' => $product->price,
        'qty' => 1,
      ];
    }
    session()->put('cart', $cart);
    return back()->with('success', 'Producto agregado');
  }

  public function update(Request $request, $id)
  {
    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {
      if ($request->action === 'decrease') {
        $cart[$id]['qty']--;
        if ($cart[$id]['qty'] <= 0) unset($cart[$id]);
      } else {
        $cart[$id]['qty']++;
      }
    }
    session()->put('cart', $cart);
    return back();
  }
  public function remove($id)
  {
    $cart = session()->get('cart', []);
    unset($cart[$id]);
    session()->put('cart', $cart);

    return back();
  }

  public function checkout(Request $request){
    $cart = session()->get('cart', []);
    $schedule = $this->checkStoreOpen();

    return view('checkout', compact('cart', 'schedule'));
  }

}
