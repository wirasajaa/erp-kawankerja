<x-auth-app>
    <x-card title="Edit Permission">
        <form action="{{ route('permissions.update', ['permission' => $permission->id]) }}" method="POST">
            @csrf
            @method('put')
            <div class="mb-3">
                <x-label-input for="inputName">Name</x-label-input>
                <x-text-input name="name" id="inputName" placeholder="action-model"
                    value="{{ old('name', $permission->name) }}" type="text" />
            </div>
            <button class="btn btn-success" type="submit">Update</button>
        </form>
    </x-card>
</x-auth-app>
