<?php

namespace App\Livewire\Pages;

use App\Models\XbrlMessage;
use Livewire\Component;

class XbrlMessagesIndexPage extends Component
{
    public $dateFrom;

    public function mount()
    {
        $this->dateFrom = now()->subDays(60)->format('Y-m-d');
    }

    public function render()
    {
        $xbrlMessages = XbrlMessage::with('user')->where('created_at', '>=', $this->dateFrom)->orderBy('created_at')->get();

        return view('livewire.pages.xbrl-messages-index-page', compact('xbrlMessages'));
    }
}
