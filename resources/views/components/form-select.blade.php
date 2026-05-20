<div class="mb-3">
  <label class="label-text" for="{{ $name }}">{{ $label }}</label>
  <select class="select" name="{{ $name }}" id="{{ $name }}">

    <option value="">{{ $placeholder }}</option>

    @foreach ($options as $key => $label)
      <option value="{{ $key }}" {{ old($name, $value) == $key ? 'selected' : '' }}>
        {{ $label }}
      </option>
    @endforeach

  </select>
  @error($name)
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>
