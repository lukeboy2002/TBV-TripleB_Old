<?php

namespace App\Livewire\Profile;

use App\Models\Member;
use App\Models\User;
use Livewire\Component;

class UpdateMemberInformationForm extends Component
{
    public User $user;

    public Member $member;

    public $bio;

    public $city;

    public $birthdate;

    protected $rules = [
        'bio' => 'nullable|min:6',
        'city' => 'nullable|min:3',
        'birthdate' => 'nullable|date',
    ];

    protected $listeners = ['changeDate' => 'changeDate'];

    public function changeDate($date)
    {
        $this->birthdate = $date;
    }

    public function mount(User $user)
    {
        $member = $user->member()->firstOrNew();
        $this->bio = $member->bio;
        $this->city = $member->city;
        $this->birthdate = $member->birthdate;
    }

    public function render()
    {
        return view('profile.update-member-information-form');
    }

    public function save()
    {
        $this->validate();

        $member = $this->user->member()->firstOrNew();

        $member->user_id = $this->user->id;
        $member->bio = $this->bio;
        $member->city = $this->city;
        $member->birthdate = $this->birthdate;
        $member->save();

        session()->flash('success_small', 'User has been updated');
    }
}
