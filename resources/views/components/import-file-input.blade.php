<div class="flex justify-center">
    <div class="w-full">
        <form wire:submit.prevent="submit">
            <div class="overflow-hidden shadow sm:rounded-md">
                <div class="bg-white p-4">
                    <div class="grid grid-cols-6 gap-4">

                        <div class="col-span-6">
                            <label for="first-name" class="block text-sm font-medium text-gray-700">JSON
                                File</label>
                            <div class="mt-1">
                                <div x-data="{ isUploading: false, progress: 0 }"
                                     x-on:livewire-upload-start="isUploading = true"
                                     x-on:livewire-upload-finish="isUploading = false"
                                     x-on:livewire-upload-error="isUploading = false"
                                     x-on:livewire-upload-progress="progress = $event.detail.progress">
                                    <div>
                                        <div class="grid grid-cols-3 gap-6">
                                            <div class="col-span-3">
                                                <label for="file"
                                                       class="relative border-2 border-gray-300 border-dashed rounded-md px-6 pt-5 pb-6 flex justify-center">
                                                    <div class="space-y-1 text-center">
                                                        <svg wire:target="file"
                                                             wire:loading.remove="wire:loading.remove"
                                                             class="mx-auto h-12 w-12 text-gray-400"
                                                             stroke="currentColor" fill="none" viewBox="0 0 48 48"
                                                             aria-hidden="true">
                                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                                  stroke-width="2" stroke-linecap="round"
                                                                  stroke-linejoin="round"></path>
                                                        </svg>
                                                        <svg class="animate-spin hidden h-8 w-8 text-blue-500 mx-auto"
                                                             wire:target="file" wire:loading.class.remove="hidden"
                                                             xmlns="http://www.w3.org/2000/svg" fill="none"
                                                             viewBox="0 0 24 24">
                                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                                    stroke="currentColor" stroke-width="4"></circle>
                                                            <path class="opacity-75" fill="currentColor"
                                                                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                        </svg>
                                                        <div x-show="isUploading" style="display: none;">
                                                            <div class="w-full bg-gray-200 rounded-full my-2">
                                                                <div class="bg-blue-600 text-xs font-medium text-blue-100 text-center p-1 leading-none rounded-full"
                                                                     :style="'width: ' + (progress  > 20 ? progress: '20') +'%'"
                                                                     style="width: 20%"><span
                                                                            x-text="progress">0</span>%
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="flex text-sm text-gray-600">
                                                            <p class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                                <span>Upload JSON File</span>
                                                                <input id="file-upload" name="file-upload"
                                                                       type="file" class="sr-only">
                                                            </p>
                                                            <p class="pl-1">or drag and drop</p>
                                                        </div>
                                                        <p class="text-xs text-gray-500">
                                                            Only JSON files allowed up to <span
                                                                    class="text-red-500 font-medium">50MB</span>
                                                        </p>
                                                    </div>

                                                    <input type="file" id="file" wire:model="file"
                                                           wire:loading.attr="disabled"
                                                           class="absolute inset-0 h-full w-full opacity-0"
                                                           accept=".json">
                                                </label>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </form>
    </div>
</div>