<x-auth-app>
    <x-card title="Build new project">
        <form action="{{ route('projects.store') }}" method="post">
            @csrf
            <div class="row mb-md-3">
                <div class="col-md-6 mb-3 mb-md-0">
                    <x-label-input for="inputName">Name</x-label-input>
                    <x-text-input name="name" id="inputName" type="text" value="{{ old('name') }}"
                        placeholder="ERP Kawan Kerja" />
                </div>
                <div class="col-md-6 mb-3 mb-md-0">
                    <x-label-input for="inputPIC">PIC</x-label-input>
                    <x-select-input name="pic" id="inputPIC">
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}"{{ old('pic') == $employee->id ? 'selected' : '' }}>
                                {{ $employee->fullname . ' | ' . $employee->user->roles->first()->name }}
                            </option>
                        @endforeach
                    </x-select-input>
                </div>
            </div>
            <div class="row mb-md-3">
                <div class="col-md-6 mb-3 mb-md-0">
                    <x-label-input for="inputStatus">Status</x-label-input>
                    <x-select-input name="status" id="inputStatus">
                        @foreach ($status_options as $item)
                            <option value="{{ $item->value }}"{{ old('status') == $item->value ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </x-select-input>
                </div>
                <div class="col-md-6 mb-3 mb-md-0">
                    <x-label-input for="inputCycle">Cycle</x-label-input>
                    <x-text-input name="cycle" id="inputCycle" type="number" step="1" min="0"
                        value="{{ old('cycle') }}" placeholder="1" />
                </div>
            </div>

            <div class="mb-3">
                <x-label-input for="inputDesc">Description</x-label-input>
                <textarea class="form-control" name="description" id="inputDesc" cols="30" rows="3">{{ old('description') }}</textarea>
            </div>
            <button type="submit" class="btn btn-success">Crate</button>
        </form>
    </x-card>
</x-auth-app>
