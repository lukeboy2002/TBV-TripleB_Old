<?php

namespace App\Livewire\Admin\Users;

use App\Models\Permission;
use App\Models\User;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class All extends Component
{
    use WithPagination;

    public $delete_id;

    #[Url(history:true)]
    public $search ='';

    #[Url(history:true)]
    public $sortBy = 'created_at';

    #[Url(history:true)]
    public $sortDir = 'DESC';

    #[Url()]
    public $perPage = 10;

    public function updatedSearch(){
        $this->resetPage();
    }

    public function delete(User $user){
        $user->delete();
        session()->flash('success', 'User deleted successfully');
    }

    public function setSortBy($sortByField){

        if($this->sortBy === $sortByField){
            $this->sortDir = ($this->sortDir == "ASC") ? 'DESC' : "ASC";
            return;
        }

        $this->sortBy = $sortByField;
        $this->sortDir = 'DESC';
    }

    public function render()
    {
        return view('livewire.admin.users.all', [
            'users' => User::search($this->search)
                ->leftJoin('model_has_roles as role', 'id', '=', 'role.model_id')
                ->leftJoin('roles', 'role.role_id', '=', 'roles.id') // Join the roles table
                ->select('users.*', 'roles.name as role_name') // Select the role name
                ->orderBy($this->sortBy,$this->sortDir)
                ->withTrashed()
                ->paginate($this->perPage)
        ]);
    }
}
