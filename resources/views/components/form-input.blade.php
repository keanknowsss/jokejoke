{{--
    Attributes to add: HTML input attributes
--}}

@props(['name', 'type' => 'text'])

@php
    $error_class = $errors->has($name) ? 'input-error' : '';
@endphp

@if ($type == 'password')
    <div x-data="{ showPassword: false }" class="password-field">
        <input :type="showPassword ? 'text' : 'password'" name={{ $name }}
            {{ $attributes->merge(['class' => "form-input $error_class"]) }}>
        <button type="button" @click="showPassword = !showPassword">
            <i x-show="showPassword" class="fa-regular fa-eye"></i>
            <i x-show="!showPassword" class="fa-regular fa-eye-slash"></i>
        </button>
    </div>
@elseif ($type === 'file')
    <input type="file" name="{{ $name }}" {{  $attributes->merge() }}>
@elseif ($type === 'textarea')
    <textarea name="{{ $name }}" {{ $attributes->merge(['class' => "form-input {$error_class}"]) }}></textarea>
@else
    <input name={{ $name }} type={{ $type }}
        {{ $attributes->merge(['class' => "form-input $error_class"]) }} />
@endif
