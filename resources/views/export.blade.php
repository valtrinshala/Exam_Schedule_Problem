<div>
    <div class="flex justify-center">
        <label
            class="w-64 h-40
        flex items-center justify-center bg-gray-50 rounded-md border border-primary-400 border-dashed">
            <x:folder-plus class="mx-auto w-6 text-primary-400"/>
            <input wire:model="file"
                   type="file"
                   class="sr-only"/>
        </label>
    </div>
    <div class="flex flex-col gap-2 w-full px-2 max-h-screen">
        @if(filled($file))
            <div class="border-b  border-gray-200  bg-white ">
                <x:table.table>
                    <x:slot name="header">
                        <div class="flex flex-wrap justify-between pt-2 px-2 gap-2 items-center pb-2">
                            <div class="text-gray-500 flex gap-2 w-8/12 min-w-max">
                                    <span class="hidden md:block">
                            Courses
                        </span>
                            </div>
                            <x:input class="border-0 bg-gray-100 w-72 pt-2 " type="search"
                                     wire:model.debounce.500="query"
                                     placeholder="Search table..."/>
                            <button wire:click="export"
                                    class="bg-transparent hover:bg-blue-500
                 text-blue-700 font-semibold hover:text-white
                  py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                                Export
                            </button>
                        </div>
                    </x:slot>
                    <x:table.thead :fields="$columns"/>

                    <x:table.tbody>
                        @foreach($this->filteredCourses as $course)
                            <x:table.tr class="cursor-pointer">
                                @foreach($this->defaultColumns as $key=>$column)
                                    <x:table.td>
                                        {{ $course[$key] ?? '' }}
                                    </x:table.td>
                                @endforeach

                                @for($i=0; $i<$maxPrimaryCount;$i++)
                                    <x:table.td>
                                        {{ $course['primary'][$i] ?? '-' }}
                                    </x:table.td>
                                @endfor

                                @for($i=0; $i<$maxSecondaryCount;$i++)
                                    <x:table.td>
                                        {{ $course['secondary'][$i] ?? '-' }}
                                    </x:table.td>
                                @endfor
                            </x:table.tr>
                        @endforeach
                    </x:table.tbody>
                </x:table.table>

            </div>
        @endif
    </div>

</div>
