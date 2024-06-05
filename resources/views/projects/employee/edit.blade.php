<x-auth-app>
    <x-card title="Employee Profile" class="bg-success-subtle">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <p class="mb-1">Username</p>
                    <h5><span class="fw-bold text-dark">{{ $employee->profile->user->username }}</span></h5>
                </div>
                <div class="mb-3">
                    <p class="mb-1">Email</p>
                    <h5><span class="fw-bold text-dark">{{ $employee->profile->user->email }}</span></h5>
                </div>
                <div class="mb-3">
                    <p class="mb-1">Position</p>
                    <h5><span class="fw-bold text-dark">{{ $employee->profile->user->roles->first()->name }}</span></h5>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <p class="mb-1">NIP</p>
                    <h5><span class="fw-bold text-dark">{{ $employee->profile->nip }}</span></h5>
                </div>
                <div class="mb-3">
                    <p class="mb-1">Fullname</p>
                    <h5><span
                            class="fw-bold text-dark">{{ $employee->profile->title_front . ' ' . $employee->profile->fullname . ' ' . $employee->profile->title_back }}</span>
                    </h5>
                </div>
                <div class="mb-3">
                    <p class="mb-1">Gender</p>
                    <h5><span class="fw-bold text-dark">{{ $employee->profile->gender }}</span></h5>
                </div>
            </div>
        </div>
    </x-card>
    <x-card title="Update employee data in project">
        <form action="{{ route('projects.employee.update', ['employee' => $employee->id]) }}" method="post">
            @csrf
            @method('put')
            <div class="mb-3">
                <x-label-input>Status</x-label-input>
                <div class="d-flex gap-2">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="active"
                            value="ACTIVE"{{ old('status', $employee->status) == 'ACTIVE' ? 'checked' : '' }}>
                        <label class="form-check-label" for="active">Active</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="nonactive"
                            value="NON_ACTIVE"{{ old('status', $employee->status) == 'NON_ACTIVE' ? 'checked' : '' }}>
                        <label class="form-check-label" for="nonactive">Non Active</label>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <x-label-input for="inputNote">Notes</x-label-input>
                <textarea name="notes" id="inputNote" cols="30" rows="2" class="form-control">{{ old('notes', $employee->notes) }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </x-card>
</x-auth-app>
