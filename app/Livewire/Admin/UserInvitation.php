<?php

namespace App\Livewire\Admin;

use App\Mail\DeleteUserInvitation;
use App\Models\Invitation;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class UserInvitation extends Component
{
    use WithPagination;

    #[Rule(['required', 'string', 'email', 'unique:users,email', 'unique:invitations,email'])]
    public $email;

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

    public function create() {
        $this->validateOnly('email');

        $invitation = Invitation::create([
            'email' => $this->email,
            'invited_by' => current_user()->username,
            'invited_date' => now()
        ]);

        $invitation->generateInvitationToken();
        $invitation->save();

        $mailData = [
            'title' => 'U have a invitation from TripleB',
            'link' => $invitation->getLink(),
            'invited_by' => current_user()->username,
            'invited_date' => now()
        ];

        Mail::to($this->email)->send(new \App\Mail\UserInvitation($mailData));

        $this->reset('email');
        session()->flash('success', 'Invitation to register successfully requested. A mail is been send to '.$invitation->email);

    }

    public function delete(Invitation $invitation){
        $mailData = [
            'title' => 'Your invitation has been Revoked',
        ];

        Mail::to($invitation->get('email'))->send(new DeleteUserInvitation($mailData));

        session()->flash('success', 'Invitation deleted successfully. A mail is been send to '.$invitation->email);

        $invitation->delete();
        $this->resetPage();
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
        return view('livewire.admin.user-invitation', [
            'invitations' => Invitation::search($this->search)
                ->orderBy($this->sortBy,$this->sortDir)
                ->paginate($this->perPage)
        ]);
    }
}
