<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;

class User extends Component
{
    public $name;
    public $selected_user_id;
    public $updateUserMode = false;

    protected $listeners = ["resetModalForm", "deleteUserAction"];

    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public function resetModalForm()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->nama = null;
    }

    public function editUser($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $this->selected_user_id = $user->id;
        $this->name = $user->name;
        $this->updateUserMode = true;
        $this->resetErrorBag();
        $this->dispatchBrowserEvent("showUserModal");
    }

    public function deleteUser($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $this->dispatchBrowserEvent("deleteUser", [
            "title" => "Apakah anda yakin ?",
            "html" => "Anda ingin menghapus <b>" . $user->name . "</b>",
            "id" => $id,
        ]);
    }

    public function render()
    {
        return view("livewire.admin.users", [
            "users" => \App\Models\User::paginate(5),
        ]);
    }
}
