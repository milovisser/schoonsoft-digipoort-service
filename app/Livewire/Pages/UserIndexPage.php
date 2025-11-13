<?php

namespace App\Livewire\Pages;

use App\Models\User;
use Flux\Flux;
use Livewire\Component;

class UserIndexPage extends Component
{
    public $showApiTokenCreatedModal = false;

    public $token;

    public function createToken($userId)
    {
        $user = User::find($userId);

        $this->token = $user->createToken('api-token')->plainTextToken;
        Flux::modal('api-token-created')->show();
    }

    public function render()
    {
        $users = User::orderBy('name')->get();

        return view('livewire.pages.user-index-page', compact('users'));
    }
}
