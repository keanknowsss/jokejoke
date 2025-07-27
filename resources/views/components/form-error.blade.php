{{--
    Attributes to add: ['name']
--}}

@props(['name'])

@error($name)
    <p {{ $attributes->merge(['class' => 'text-sm text-red-500 mt-1 ms-1']) }}>{{ $message }}</p>
@enderror
