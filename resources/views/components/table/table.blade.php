<div class="shadow rounded-lg bg-white  border border-gray-200">

    {{ $header ?? '' }}

    <div class="overflow-x-auto max-h-screen">
        <div class="inline-block min-w-full align-middle">
            <div class="shadow-sm px-2">
                <table
                    @class(['min-w-full divide-y divide-gray-200', 'border-t border-gray-200' => isset($header)])>

                    {{ $slot }}

                </table>
            </div>
        </div>
    </div>

</div>
