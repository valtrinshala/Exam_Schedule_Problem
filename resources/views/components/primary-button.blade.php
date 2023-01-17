@php($class = 'inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-400 hover:bg-indigo-500 focus:outline-none focus:border-indigo-400 focus:shadow-outline-primary active:bg-indigo-400 transition duration-150 ease-in-out')

@if($href ?? false)
    <a {{ $attributes->merge(['class' => $class]) }}>{{ $value ?? $slot ?? null }}</a>
@else
    <button
        {{ $attributes->merge(['type' => 'submit', 'class' => $class]) }}>
        {{ $value ?? $slot ?? null }}
    </button>
@endif
