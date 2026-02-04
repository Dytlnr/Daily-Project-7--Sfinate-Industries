@props([
    'type' => 'text',
    'name',
    'id' => $name,
    'label' => null,
    'value' => '',
    'required' => false,
    'placeholder' => '',
])

<div class="mb-4">
    @if ($label)
        <x-input-label :for="$id" :value="$label" />
    @endif

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $id }}"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge([
            'class' => 'w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white'
        ]) }}
    >

    <x-input-error :messages="$errors->get($name)" class="mt-1" />
</div>
