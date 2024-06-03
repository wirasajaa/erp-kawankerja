<textarea
    {{ $attributes->merge(['class' => $errors->has($attributes->get('name')) ? 'form-control is-invalid' : 'form-control']) }}>{{ $value }}</textarea>
@isset($helper)
    <span class="text-sm text-primary">{{ $helper }}</span>
@endisset
@error($attributes->get('name'))
    <div class="invalid-feedback">
        {{ $message }}
    </div>
@enderror
