<x-section.form submit="save">
    <x-slot name="title">
        Member Information
    </x-slot>

    <x-slot name="description">
        Additional information for members.
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <div class="space-y-6">
                <div wire:ignore>
                    <x-form.label for="bio" value="Biography" />
                    <x-form.textarea id="bio" name="bio" wire:model.defer="bio"></x-form.textarea>
                    <x-form.input-error for="bio" class="mt-2" />
                </div>

                <div class="flex justify-between gap-6">
                    <div class="w-1/2">
                        <div class="col-span-6 sm:col-span-4">
                            <x-form.label for="city" value="City" />
                            <x-form.input id="city" type="text" class="mt-1 block w-full" wire:model="city" />
                            <x-form.input-error for="email" class="mt-2" />
                        </div>
                    </div>
                    <div class="w-1/2">
                        <x-form.label for="birthdate" value="Birthdate" />
                        <div class="relative max-w-sm">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                <x-icons.icon name="calendar" />
                            </div>
                            <input datepicker datepicker-format="yyyy-mm-dd" wire:model="birthdate" type="text" id="birthdate" name="birthdate" class="bg-gray-50 border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-white dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="Select date">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <x-slot name="actions">
        <div class="flex items-center space-x-2">
            <x-messages />
            <x-button.primary class="px-3 py-2 text-xs font-medium">
                Save
            </x-button.primary>
        </div>
    </x-slot>
</x-section.form>

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/datepicker.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>

    <script>
        ClassicEditor
        var ready = (callback) => {
            if (document.readyState != "loading") callback();
            else document.addEventListener("DOMContentLoaded", callback);
        }
        ready(() =>{
            ClassicEditor
                .create(document.querySelector('#bio'), {
                    ckfinder: {
                        uploadUrl: '{{ route('admin.member.upload', ['_token' => csrf_token()]) }}'
                    }
                })
                .then(editor => {
                    editor.model.document.on('change:data', () => {
                    @this.set('bio', editor.getData());
                    })
                    Livewire.on('reinit', () => {
                        editor.setData('', '')
                    })
                })
                .catch(error => {
                    console.error(error);
                });
        })

        document.getElementById("birthdate").addEventListener("changeDate", function (e) {
            Livewire.emit('changeDate', e.detail.datepicker.inputField.value)
        });
    </script>
@endpush
