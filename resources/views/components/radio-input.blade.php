@props(['base_class' => 'form-check-input', 'form_label' => 'label is not set', 'old' => ''])
<div class="form-check">
    <input
        {{ $attributes->merge(['class' => $errors->has($attributes->get('name')) ? $base_class . ' is-invalid' : $base_class]) }}{{ old($attributes->get('name'), $old) == $attributes->get('value') ? 'checked' : '' }}>
    <label class="form-check-label" for="{{ $attributes->get('id') }}">
        {{ $form_label }}
    </label>
</div>
