<div>
    <div @if($shouldPoll) wire:poll.5s="$refresh" @endif>

        <div class="flex items-center gap-4 mb-5">
            <div class="relative w-72">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <x:icons.search class="h-5 w-5 text-gray-400"/>
                </div>

                <x-input class="pl-10 w-full" wire:model.debounce.750="query" placeholder="Search..."/>
            </div>

{{--        <x:table>--}}
{{--            <x:thead :columns="['Name','Start At', 'Done At','Rows', 'Rows affected','Created At', '']"/>--}}
{{--            <tbody>--}}
{{--            @forelse($importFiles as $file)--}}
{{--                <x:tr :index="$loop->index">--}}
{{--                    <x:td>{{ $file->name ?? '-'}}</x:td>--}}
{{--                    <x:td>{{ $file->started_at?->format('d.m.Y, H:i') ?? '-'}}</x:td>--}}
{{--                    <x:td>{{ $file->done_at?->format('d.m.Y, H:i') ?? '-' }}</x:td>--}}
{{--                    <x:td>{{ number_format($file->rows) }}</x:td>--}}
{{--                    <x:td>--}}
{{--                        <div class="flex items-center justify-between w-32">--}}
{{--                           <span>--}}
{{--                               {{ number_format($file->rows_affected) }}--}}
{{--                           </span>--}}
{{--                            <div class="ml-5">--}}
{{--                                @if($file->done_at)--}}
{{--                                    <x:icons.check-circle-s class="w-5 h-5 text-green-500"/>--}}
{{--                                @elseif($file->started_at && !$file->done_at)--}}
{{--                                    <div class="text-primary-500 font-semibold">--}}
{{--                                        {{ $file->processedPercentage() }}%--}}
{{--                                    </div>--}}
{{--                                @elseif(!$file->started_at)--}}
{{--                                    <x:icons.clock-s class="w-5 h-5 text-yellow-500"/>--}}
{{--                                @endif--}}
{{--                            </div>--}}

{{--                        </div>--}}
{{--                    </x:td>--}}
{{--                    <x:td>{{ $file->created_at?->format('d.m.Y, H:i') }}</x:td>--}}
{{--                    <x:td class="flex justify-end space-x-2">--}}
{{--                        <x:link href="{{ $file->full_path }}" target="_blank">--}}
{{--                            Download--}}
{{--                        </x:link>--}}

{{--                        <x:delete-link item="{{ $file->id }}"/>--}}
{{--                    </x:td>--}}
{{--                </x:tr>--}}
{{--            @empty--}}
{{--                <x:tr>--}}
{{--                    <x:td colspan="100%">--}}
{{--                        There are no data.--}}
{{--                    </x:td>--}}
{{--                </x:tr>--}}
{{--            @endforelse--}}

{{--            </tbody>--}}
{{--        </x:table>--}}

{{--        <div class="mt-10">--}}
{{--            {{ $importFiles->links() }}--}}
{{--        </div>--}}
    </div>

{{--    <x:delete-item-modal/>--}}
</div>

</div>





