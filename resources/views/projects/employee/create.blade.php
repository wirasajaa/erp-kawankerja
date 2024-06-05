<x-auth-app>
    <x-card title="Add new employee to project">
        <form action="{{ route('projects.employee.store') }}" method="post">
            @csrf
            <div class="row mb-md-3">
                <div class="col-md-6 mb-3 mb-md-0">
                    <x-label-input for="inputEmployee">Employee</x-label-input>
                    <x-select-input name="employee_id" id="inputEmployee">
                        @if (empty($employees))
                            <option value="">No employee data</option>
                        @else
                            @foreach ($employees as $employee)
                                <option
                                    value="{{ $employee->id }}"{{ $employee->id == old('employee_id') ? ' selected' : '' }}>
                                    {{ $employee->fullname . ' | ' . $employee->user->roles->first()->name }}</option>
                            @endforeach
                        @endif
                    </x-select-input>
                </div>
                <div class="col-md-6 mb-3 mb-md-0">
                    <x-label-input>Status</x-label-input>
                    <div class="d-flex gap-2">
                        <div class="form-check">
                            <input
                                class="form-check-input @error('status')
                                {{ 'is-invalid' }}
                            @enderror"
                                type="radio" name="status" id="active"
                                value="ACTIVE"{{ old('status') == 'ACTIVE' ? 'checked' : '' }}>
                            <label class="form-check-label" for="active">Active</label>
                        </div>
                        <div class="form-check">
                            <input
                                class="form-check-input @error('status')
                            {{ 'is-invalid' }}
                        @enderror"
                                type="radio" name="status" id="nonactive"
                                value="NON_ACTIVE"{{ old('status') == 'NON_ACTIVE' ? 'checked' : '' }}>
                            <label class="form-check-label" for="nonactive">Non Active</label>
                        </div>
                    </div>
                    @error('status')
                        <span class="text-danger fs-2">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="mb-3">
                <x-label-input for="inputNote">Notes</x-label-input>
                <textarea name="notes" id="inputNote" cols="30" rows="2" class="form-control">{{ old('notes') }}</textarea>
            </div>
            <button type="submit" class="btn btn-success">Save</button>
        </form>
    </x-card>
</x-auth-app>
