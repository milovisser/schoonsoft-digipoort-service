<div>


    <div class="flex items-center justify-between">
        <flux:heading size="lg">{{ __('XBRL berichten') }}</flux:heading>

        <flux:input class="w-42! max-w-42!" type="date" wire:model.debounce.300ms="dateFrom" />
    </div>
    <flux:table>
            <flux:table.columns>
                <flux:table.column>{{ __('Gebruiker') }}</flux:table.column>
                <flux:table.column>{{ __('Message UUID') }}</flux:table.column>
                <flux:table.column>{{ __('Message Type') }}</flux:table.column>
                <flux:table.column>{{ __('Status') }}</flux:table.column>
                <flux:table.column>{{ __('Created At') }}</flux:table.column>
            </flux:table.columns>
            <flux:table.rows>

            @foreach ($xbrlMessages as $xbrlMessage)
                <flux:table.row wire:key="xbrl-message-{{ $xbrlMessage->id }}">
                    <flux:table.cell>{{ $xbrlMessage->user->name }}</flux:table.cell>
                    <flux:table.cell>{{ $xbrlMessage->message_uuid }}</flux:table.cell>
                    <flux:table.cell>{{ $xbrlMessage->message_type }}</flux:table.cell>
                    <flux:table.cell>{{ $xbrlMessage->status }}</flux:table.cell>
                    <flux:table.cell>{{ $xbrlMessage->created_at->format('d-m-Y H:i') }}</flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</div>
