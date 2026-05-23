<label class="label-text" for="{{ $name }}">{{ $label }} 
    <span class="text-red-300 font-bold">{{ $required ? '*' : '' }}</span>
</label>

<input 
    id="{{ $name }}" 
    type="{{ $type }}"
    name="{{ $name }}" 
    placeholder="{{ $placeholder }}" 
    class="input @error($name) border-red-500 @enderror {{ $class }}"
    value="{{ old($name, $value ?? '') }}"
    autocomplete="off" 
    {{ $required ? 'required' : '' }}
/>

@error($name)
    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
@enderror