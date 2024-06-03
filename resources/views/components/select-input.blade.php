<select
    {{ $attributes->merge(['class' => $errors->has($attributes->get('name')) ? 'form-select is-invalid' : 'form-select']) }}>
    {{ $slot }}
</select>
@error($attributes->get('name'))
    <div class="invalid-feedback">
        {{ $message }}
    </div>
@enderror
