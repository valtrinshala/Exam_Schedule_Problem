<thead class="bg-white">
<x:table.tr>
    @foreach($fields ?? [] as $key=>$name)
        <x:table.th :is-first="$loop->first">

            {{ $name }}

            @if(is_string($key))
                <a href="#" wire:click.prevent="sortItems('{{ $key }}')"
                   class="flex items-center gap-1">

                    <span>{{ $name }}</span>

                    <div class="flex items-center">
                        <x:icons.arrow-up
                            class="{{$sortField === $key && $sortDirection === 'desc' ? 'text-black' : '' }} -mt-1 w-3 cursor-pointer text-gray-400"/>

                        <x:icons.arrow-down
                            class="{{$sortField === $key && $sortDirection === 'asc' ? 'text-black' : '' }} mt-1 -ml-1.5 w-3 cursor-pointer text-gray-400"/>
                    </div>
                </a>
            @endif

        </x:table.th>
    @endforeach

    {{ $slot }}

</x:table.tr>
</thead>
