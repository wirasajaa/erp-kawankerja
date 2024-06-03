@props(['title' => 'Title is not set!'])
<div class="card">
    <div class="card-body">
        <h5 class="card-title fw-semibold mb-4">{{ $title }}</h5>
        {{ $slot }}
    </div>
</div>
