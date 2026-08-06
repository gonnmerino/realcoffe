<?php

use Livewire\Component;
use App\Models\User;

new class extends Component {
  public $userId;
  public $userEmail;
  public $userName;
  public $isOpen;

  protected $listeners = ['openDeleteModal' => 'open'];

  public function open($id, $email, $name)
  {
    $this->userId = $id;
    $this->userEmail = $email;
    $this->userName = $name;
    $this->isOpen = true;
  }

  public function close()
  {
    $this->isOpen = false;
    $this->reset(['userId', 'email']);
  }

  public function blockedUser()
  {
    $user = User::findOrFail($this->userId);
    if($user->is_active == false) {
      session()->flash('error', "Esta cuenta {$this->userEmail} ya estaba bloqueada.");
      return;
    }
    $user->is_active = false;
    $user->save();

    session()->flash('success', "La cuenta de {$this->userEmail} se bloqueo satisfactoriamente!");

    return redirect()->route('users.index');

  }
}; ?>

<div>
  @if($isOpen)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
      <div class="bg-zinc-800 text-zinc-100 p-6 rounded-lg border border-zinc-700 shadow-xl max-w-md w-full">
        @if (session()->has('error'))
          <div class="mb-4 p-4 bg-red-950/40 text-red-400 rounded-lg border border-red-900/50 text-sm">
            {{ session('error') }}
          </div>
        @endif
        <h3 class="text-lg font-bold text-zinc-100">¿Estás seguro?</h3>
        <p class="text-sm text-zinc-400 mt-2">
          Estás a punto de bloquear la cuenta de: <strong class="text-zinc-200">{{ $userName }}</strong>.
        </p>
        <div class="flex justify-end space-x-3 mt-6">
          <button type="button"
                  wire:click="$set('isOpen', false)"
                  class="px-4 py-2 bg-zinc-700 hover:bg-zinc-600 text-zinc-300 font-semibold rounded-md text-sm transition-colors cursor-pointer">
            Cancelar
          </button>
          <button type="button"
                  wire:click="blockedUser"
                  class="px-4 py-2 bg-zinc-100 hover:bg-zinc-200 text-zinc-900 font-semibold rounded-md text-sm transition-all cursor-pointer">
            Confirmar bloqueo
          </button>
        </div>
      </div>
    </div>
  @endif
</div>
