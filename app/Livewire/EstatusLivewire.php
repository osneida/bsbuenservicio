<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class EstatusLivewire extends Component
{

    public function mount()
    {

    }

    public function sofDelete($id){
        User::find($id)->softDeleted();
        return redirect(route('admin.usuarios.index'))->with('danger', 'Usuario desactivado con éxito');
    }

    public function forceDelete($id){
        User::find($id)->forceDelete();
        return redirect(route('admin.usuarios.index'))->with('danger', 'Usuario eliminado con éxito');
    }

    public function render()
    {
        return view('livewire.estatus-livewire');
    }
}
