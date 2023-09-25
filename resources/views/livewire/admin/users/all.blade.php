<div>
    <x-messages />
    <div class="flex justify-between items-center space-x-4 pb-4 pt-2">
        <div class="flex items-center">
            <x-search/>
        </div>
    </div>
    @if (!$users->isEmpty())
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3"></th>
                @include('livewire.includes.sortable-th',[
                    'name' => 'username',
                     'displayName' => 'Name'
                ])
                @include('livewire.includes.sortable-th',[
                    'name' => 'email',
                     'displayName' => 'Email'
                ])
                @include('livewire.includes.sortable-th',[
                    'name' => 'model_id',
                     'displayName' => 'Role'
                ])
                @include('livewire.includes.sortable-th',[
                    'name' => 'logged_in',
                     'displayName' => 'Logged in'
                ])
                <th scope="col" class="px-6 py-3">
                    Last login time
                </th>
                <th scope="col" class="px-6 py-3 flex justify-end">
                    Action
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr wire:key="{{$user->id}}"
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="{{ $user->username }}" class="h-10 w-auto rounded-full" >
                    </th>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $user->username }}
                    </th>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $user->email }}
                    </th>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $user->role_name }}
                    </th>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        @if( $user->logged_in =='1' )
                            <i class="fa-regular fa-circle-check text-green-600 fa-xl"></i>
                        @else
                            <i class="fa-regular fa-circle-xmark text-red-700 fa-xl"></i>
                        @endif
                    </th>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        @if($user->last_login_time)
                            {{ $user->getLastLoginTime() }}
                        @else
                            <p>not available</p>
                        @endif
                    </th>
                    <td class="px-6 py-4 text-right space-x-2">
                        @if ($user->trashed())
                            @role('admin')
                            <x-link.primary href="{{ route('admin.users.trashed.restore' , $user->id) }}" class="px-2.5 py-2.5 text-xs font-medium">Restore</x-link.primary>
                            <x-link.btn-danger href="{{ route('admin.users.trashed.destroy' , $user->id) }}" class="px-2.5 py-2.5 text-xs font-medium">Force Delete</x-link.btn-danger>
                            @endrole
                            @role('member')
                            <span class="px-2.5 py-2.5 text-xs font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition ease-in-out duration-150">Deleted</span>
                            @endrole
                        @else
                        <x-link.btn-primary
                            href="{{ route('admin.users.edit' , $user) }}"
                            class="px-2.5 py-2.5 text-xs font-medium"><i class="fa-solid fa-pen-to-square"></i>
                        </x-link.btn-primary>

                        <x-button.danger type="button"
                                         class="px-2.5 py-2.5 text-xs font-medium"
                                         onclick="confirm('Are you sure you want to delete {{ $user->username }} ?') || event.stopImmediatePropagation()"
                                         wire:click="delete({{ $user->id }})">
                            <i class="fa-solid fa-trash-can"></i>
                        </x-button.danger>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="py-4 px-3">
            <x-items-per-page/>
        </div>
        <div class="px-4 py-4">
            {{ $users->links() }}
        </div>
    @else
        <div class="flex flex-col justify-center items-center h-40 space-y-4">
            <div class="text-orange-500"><i class="fa-regular fa-circle-xmark fa-2xl"></i></div>
            <p class="text-xl font-bold tracking-tight text-gray-700 dark:text-white">No records found</p>
        </div>
    @endif

    {{--    DELETE MODAL--}}
{{--    <div id="popup-delete" wire:ignore.self tabindex="-1" class="hidden">--}}
{{--        <x-modal.default>--}}
{{--            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-delete">--}}
{{--                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">--}}
{{--                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>--}}
{{--                </svg>--}}
{{--                <span class="sr-only">Close modal</span>--}}
{{--            </button>--}}
{{--            <div class="p-6 text-center">--}}
{{--                <svg class="mx-auto mb-4 text-red-700 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">--}}
{{--                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>--}}
{{--                </svg>--}}
{{--                <h3 class="mb-5 text-lg font-normal text-gray-700 dark:text-white">Are you sure you want to delete this role?</h3>--}}
{{--                <x-button.danger data-modal-hide="popup-delete" type="button" wire:click="delete" class="px-2.5 py-2.5 text-xs font-medium">--}}
{{--                    Delete--}}
{{--                </x-button.danger>--}}
{{--                <x-button.secondary data-modal-hide="popup-delete" type="button" class="px-2.5 py-2.5 text-xs font-medium">--}}
{{--                    Cancel--}}
{{--                </x-button.secondary>--}}
{{--            </div>--}}
{{--        </x-modal.default>--}}
{{--    </div>--}}
</div>

{{--@push('script')--}}
{{--    <script>--}}
{{--        window.addEventListener('hide:popup-delete', function () {--}}
{{--            $('#popup-delete').modal('hide');--}}
{{--        })--}}
{{--    </script>--}}
{{--@endpush--}}
