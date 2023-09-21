<div>
    <x-messages />
    <div class="flex justify-between items-center space-x-4 pb-4 pt-2">
        <div class="flex items-center">
            <x-search/>
        </div>
        <div class="pr-2">
            <x-link.btn-primary href="{{ route('admin.invitations.create') }}" class="px-5 py-2.5 text-sm font-medium">
                Invite User
            </x-link.btn-primary>
        </div>
    </div>
    @if (!$invitations->isEmpty())
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                @include('livewire.includes.sortable-th',[
                    'name' => 'email',
                     'displayName' => 'Email'
                ])
                @include('livewire.includes.sortable-th',[
                    'name' => 'invited_by',
                     'displayName' => 'Invited by'
                ])
                @include('livewire.includes.sortable-th',[
                    'name' => 'invited_date',
                     'displayName' => 'Date invitation'
                ])
                <th scope="col" class="px-6 py-3 flex justify-end">
                    Action
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($invitations as $invitation)
                <tr wire:key="{{$invitation->id}}"
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $invitation->email }}
                    </th>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $invitation->invited_by }}
                    </th>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $invitation->invited_date }}
                    </th>
                    <td class="px-6 py-4 text-right space-x-2">
                        <x-button.danger type="button"
                                         class="px-2.5 py-2.5 text-xs font-medium"
                                         onclick="confirm('Are you sure you want to delete the invitation to {{ $invitation->email }} ?') || event.stopImmediatePropagation()"
                                         wire:click="delete({{ $invitation->id }})">
                            <i class="fa-solid fa-trash-can"></i>
                        </x-button.danger>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="py-4 px-3">
            <x-items-per-page/>
        </div>
        <div class="px-4 py-4">
            {{ $invitations->links() }}
        </div>
    @else
        <div class="flex flex-col justify-center items-center h-40 space-y-4">
            <div class="text-orange-500"><i class="fa-regular fa-circle-xmark fa-2xl"></i></div>
            <p class="text-xl font-bold tracking-tight text-gray-700 dark:text-white">No records found</p>
        </div>
    @endif
</div>
