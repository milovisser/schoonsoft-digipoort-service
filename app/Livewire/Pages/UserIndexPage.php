<?php

namespace App\Livewire\Pages;

use App\Models\User;
use Livewire\Component;

class UserIndexPage extends Component
{
    public function createToken($userId)
    {
        $user = User::find($userId);
        $user->createToken('api-token');
        $this->dispatch('token-created', $user->id);
        $this->dispatch('toast', [
            'title' => 'Token aangemaakt',
            'message' => 'De API token is aangemaakt voor de gebruiker ' . $user->name,
            'type' => 'success',
        ]);
    }

    public function render()
    {
        $users = User::with('lastApiToken')->get();

        return view('livewire.pages.user-index-page', compact('users'));
    }
}
