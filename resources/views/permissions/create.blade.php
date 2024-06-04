<x-auth-app>
    <x-card title="Add New Permission">
        <form action="{{ route('permissions.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <x-label-input for="inputName">Name</x-label-input>
                <x-text-input name="name" id="inputName" placeholder="action-model" value="{{ old('name') }}"
                    type="text" />
            </div>
            <button class="btn btn-success" type="submit">Save</button>
        </form>
    </x-card>
</x-auth-app>
