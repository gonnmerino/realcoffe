<?php

namespace App\Http\Controllers;

use App\Models\StoreSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AvailabilityController extends Controller
{
  public function index()
  {
    $availabilities = StoreSchedule::orderByRaw('specific_date IS NOT NULL ASC')
      ->orderBy('day_of_week')
      ->orderBy('open_time')
      ->paginate(7);

    return view('availability.index', compact('availabilities'));
  }

  public function create()
  {
    return view('availability.create');
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'rule_type'     => 'required|in:day,date',
      'day_of_week'   => 'required_if:rule_type,day|nullable|integer|between:0,6',
      'specific_date' => 'required_if:rule_type,date|nullable|date',
      'open_time'     => 'required|date_format:H:i',
      'close_time'    => 'required|date_format:H:i|after:open_time',
      'is_closed'     => 'nullable|boolean',
    ]);
    DB::transaction(function () use ($validated, $request) {
      StoreSchedule::create([
        'open_time'     => $validated['open_time'],
        'close_time'    => $validated['close_time'],
        'day_of_week'   => $request->rule_type === 'day'  ? $validated['day_of_week']   : null,
        'specific_date' => $request->rule_type === 'date' ? $validated['specific_date'] : null,
        'is_closed'     => $request->boolean('is_closed'),
      ]);
    });

    return redirect()->route('availability.index')
      ->with('success', 'Rango horario guardado correctamente.');
  }

  public function edit($id)
  {
    $schedule = StoreSchedule::findOrFail($id);

    return view('availability.edit', compact('schedule'));
  }

  public function update(Request $request, $id)
  {
    $schedule = StoreSchedule::findOrFail($id);

    $validated = $request->validate([
      'rule_type'     => 'required|in:day,date',
      'day_of_week'   => 'required_if:rule_type,day|nullable|integer|between:0,6',
      'specific_date' => 'required_if:rule_type,date|nullable|date',
      'open_time'     => 'required|date_format:H:i',
      'close_time'    => 'required|date_format:H:i|after:open_time',
      'is_closed'     => 'nullable|boolean',
    ]);

    $schedule->update([
      'open_time'     => $validated['open_time'],
      'close_time'    => $validated['close_time'],
      'day_of_week'   => $request->rule_type === 'day'  ? $validated['day_of_week']   : null,
      'specific_date' => $request->rule_type === 'date' ? $validated['specific_date'] : null,
      'is_closed'     => $request->boolean('is_closed'),
    ]);

    return redirect()->route('availability.index')
      ->with('success', 'Rango horario actualizado correctamente.');
  }

  public function destroy($id)
  {
    $schedule = StoreSchedule::findOrFail($id);
    $schedule->delete();

    return redirect()->route('availability.index')
      ->with('success', 'Rango horario eliminado correctamente.');
  }
}
