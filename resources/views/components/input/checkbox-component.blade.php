<div class="form-check mt-4 form-inline">
    <label class="form-label"></label>
    <input 
        class="{{ $class }}" 
        type="checkbox" 
        name="{{ $name }}"
        value="1"
        {{ $data == true ? 'checked' : '' }}
    >
    <label class="form-check-label">{{ $label }}</label>
</div>