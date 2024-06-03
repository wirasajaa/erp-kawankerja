<x-auth-app>
    <x-card title="Edit Role Data">
        <form action="{{ route('roles.update', ['role' => $role->id]) }}" method="POST">
            @csrf
            @method('put')
            <div class="mb-3">
                <x-label-input for="inputName">Name</x-label-input>
                <x-text-input name="name" id="inputName" placeholder="Fullstack Developer"
                    value="{{ old('name', $role->name) }}" type="text" />
            </div>
            <x-label-input>Permissions</x-label-input>
            <div class="row mb-4">
                @foreach ($permissions as $key => $permission)
                    <div class="col-6 col-md-3">
                        <div class="form-check">
                            <input class="form-check-input{{ $errors->has('permissions') ? ' is-invalid' : '' }}"
                                type="checkbox"
                                id="{{ 'input' . $key }}"{{ collect(old('permissions', $role->permissions))->contains($permission['name']) ? 'checked' : '' }}
                                name="permissions[]" value="{{ $permission['name'] }}">
                            <label class="form-check-label" for="{{ 'input' . $key }}">
                                {{ $permission['name'] }}
                            </label>
                        </div>
                    </div>
                @endforeach
                @error('permissions')
                    <p class="text-danger mt-2">{{ $message }}</p>
                @enderror
            </div>
            <button class="btn btn-success" type="submit">Save</button>
        </form>
    </x-card>
</x-auth-app>
