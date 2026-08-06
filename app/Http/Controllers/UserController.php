<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\User_Role;
use App\Models\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
  public function index() {
    $users = User::paginate(8);
    $user_role = User_Role::all();
    $role = Role::all();
    return view('users.index', compact('users', 'user_role', 'role'));
  }

  public function edit($id) {
    $user = User::findOrFail($id);
    return view('users.edit', compact('user'));
  }

  public function update(Request $request, $id) {

    $user = User::findOrFail($id);
    $validated = $request->validate([
      'name' => 'required|max:255',
      'email' => 'required|max:255',
      'is_active' => 'nullable|boolean',
    ]);

    DB::transaction(function () use ($user, $request, $validated) {

      $user->update([
        'name' => $validated['name'],
        'email' => $validated['email'],
      ]);
      $user->is_active = !$request->has('is_active');
      $user->save();
    });

    return redirect()->route('users.index')->with('success', "Usuario {$user->email} actualizado!");
  }
}
