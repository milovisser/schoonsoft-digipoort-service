<div>
    <flux:heading size="lg">{{ __('Gebruikers') }}</flux:heading>
    <flux:table>
        <flux:table.rows>
            @foreach ($users as $user)
                <flux:table.row>
                    <flux:table.cell>{{ $user->name }}</flux:table.cell>
                    <flux:table.cell>{{ $user->email }}</flux:table.cell>
                    <flux:table.cell>{{ $user->lastApiToken?->token }}</flux:table.cell>

                    <flux:table.cell>{{ $user->created_at->format('d-m-Y H:i') }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:button variant="primary" size="sm" icon="eye" wire:click="createToken({{ $user->id }})">{{ __('Create Token') }}</flux:button>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</div>
