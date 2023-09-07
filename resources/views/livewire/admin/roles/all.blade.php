<div>
    <div class="flex justify-between items-center space-x-4 pb-4 pt-2">
        <div class="flex items-center">
            <x-search/>
        </div>
        <div class="pr-2">
            <x-link.btn-primary href="{{ route('admin.roles.create') }}" class="px-5 py-2.5 text-sm font-medium">New
                permission
            </x-link.btn-primary>
        </div>
    </div>

    @if (!$roles->isEmpty())
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                @include('livewire.includes.sortable-th',[
                    'name' => 'name',
                     'displayName' => 'Name'
                ])
                <th scope="col" class="px-6 py-3 flex justify-end">
                    Action
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($roles as $role)
                <tr wire:key="{{$role->id}}"
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $role->name }}
                    </th>
                    <td class="px-6 py-4 text-right">
                        <x-button.danger
                            type="button"
                            onclick="confirm('Are you sure you want to delete {{ $role->name }} ?') || event.stopImmediatePropagation()"
                            wire:click="delete({{ $role->id }})"
                            class="px-2.5 py-2.5 text-xs font-medium">
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
            {{ $roles->links() }}
        </div>
    @else
        <div class="flex flex-col justify-center items-center h-40 space-y-4">
            <div class="text-orange-500"><i class="fa-regular fa-circle-xmark fa-2xl"></i></div>
            <p class="text-xl font-bold tracking-tight text-gray-700 dark:text-white">No records found</p>
        </div>
    @endif
</div>
