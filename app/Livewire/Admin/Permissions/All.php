<?php

namespace App\Livewire\Admin\Permissions;

use App\Models\Permission;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class All extends Component
{
    use WithPagination;

    public $delete_id;

    #[Url(history:true)]
    public $search ='';
//    Add to Model
//    public function scopeSearch($query, $value) {
//        $query->where('name', 'like', "%{$value}%")
//        ->orWhere('.....', 'like', "%{$value}%");
//    }
    #[Url(history:true)]
    public $sortBy = 'created_at';

    #[Url(history:true)]
    public $sortDir = 'DESC';

    #[Url()]
    public $perPage = 10;

    public function updatedSearch(){
        $this->resetPage();
    }

    public function delete(Permission $permission){
        $permission->delete();

        session()->flash('success', 'Role deleted successfully');
    }

//    public function setDeleteId($id) {
//        $this->delete_id = $id;
//    }
//
//    public function delete() {
//        $permission = Permission::where('id', $this->delete_id)->first();
//        $permission->delete();
//
//        session()->flash('success', 'Permission successfully deleted.');
//        $this->dispatch('hide:popup-delete');
//    }

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
        return view('livewire.admin.permissions.all', [
            'permissions' => Permission::search($this->search)
                ->orderBy($this->sortBy,$this->sortDir)
                ->paginate($this->perPage)
        ]);
    }
}
