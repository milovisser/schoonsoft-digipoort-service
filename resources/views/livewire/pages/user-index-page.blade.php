<div>
    <flux:heading size="lg">{{ __('Gebruikers') }}</flux:heading>
    <flux:table>
        <flux:table.rows>
            @foreach ($users as $user)
                <flux:table.row>
                    <flux:table.cell>{{ $user->name }}</flux:table.cell>
                    <flux:table.cell>{{ $user->email }}</flux:table.cell>
                    <flux:table.cell>{{ $user->created_at->format('d-m-Y H:i') }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:button variant="primary" size="sm" icon="eye" wire:click="createToken({{ $user->id }})">{{ __('Create Token') }}</flux:button>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>


    <flux:modal name="api-token-created" >
        <div class="space-y-6">
            <flux:heading>API token is aangemaakt</flux:heading>
            <div
                x-data="{ copied: false }"
                class="flex items-center gap-2"
            >
                <flux:text x-ref="token">{{ $token }}</flux:text>
                <flux:button
                icon="document-duplicate"
                    size="sm"
                    x-on:click="
                        navigator.clipboard.writeText($refs.token.innerText).then(() => {
                            copied = true;
                            setTimeout(() => copied = false, 2000);
                        });
                    "
                >
                    <span x-show="!copied">{{ __('Kopieer') }}</span>
                    <span x-show="copied">{{ __('Gekopieerd!') }}</span>
                </flux:button>
            </div>
            <flux:button variant="primary" wire:click="$dispatch('flux:close-modal', { name: 'api-token-created' })">Sluiten</flux:button>
        </div>
    </flux:modal>
</div>
