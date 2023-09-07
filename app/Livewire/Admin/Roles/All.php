<?php

namespace App\Livewire\Admin\Roles;

use App\Models\Role;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class All extends Component
{
    use WithPagination;

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

    public function delete(Role $role) {
        $role->delete();
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
        return view('livewire.admin.roles.all', [
            'roles' => Role::search($this->search)
                ->orderBy($this->sortBy,$this->sortDir)
                ->paginate($this->perPage)
        ]);
    }
}
