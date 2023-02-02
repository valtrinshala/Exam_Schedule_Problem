<div class="space-y-8">

    <x-import-file-input/>

    {{--    @if(!filled($file))--}}
    {{--        <div class="flex justify-center items-center bg-gray-50 m-12">--}}
    {{--            <div class="text-lg mt-2">--}}
    {{--                <p> Upload JSON File for Data Aggregation</p>--}}
    {{--                <ul class="list-disc mt-2">--}}
    {{--                    <li>Only valid JSON files accepted</li>--}}
    {{--                    <li>Exam schedule data will be aggregated</li>--}}
    {{--                    <li>Data will be summarized based on pre-defined rules</li>--}}
    {{--                </ul>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    @endif--}}

    <div class="flex flex-col gap-2 w-full max-h-screen">
        @if(filled($courses))
            <div class="border-b border-gray-200 ">
                <x:table.table>
                    <x:slot name="header">
                        <div class="flex flex-wrap pt-2 px-4 gap-2 items-center pb-2">
                            <div class="text-gray-500 flex gap-2">
                                <p class="hidden md:block">
                                    Courses
                                </p>
                            </div>

                            <label class="ml-auto">
                                <x:input class="border-0 bg-gray-100 w-72 pt-2 " type="search"
                                         wire:model.debounce.500="query"
                                         placeholder="Search table..."/>
                            </label>

                            <x-primary-button type="button" wire:click="export">
                                Export
                            </x-primary-button>

                            <x-secondary-button type="button" wire:click="clear">
                                Clear
                            </x-secondary-button>
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
