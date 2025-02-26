@props(['name'])

@error($name)
    <p class="text-sm text-red-500 mt-1 ms-1">{{ $message }}</p>
@enderror
