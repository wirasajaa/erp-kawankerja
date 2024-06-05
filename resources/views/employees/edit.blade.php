<x-auth-app>
    @if (empty($employee->user))
        <div class="alert alert-danger" role="alert">
            <h1 class="text-danger">Employees do not have an account</h1>
            <p class="text-body-subtle">Connect employee data to the account to be able to access all features</p>
            <a href="{{ route('users.create') }}" class="btn btn-secondary">Create Account</a>
        </div>
    @else
        <x-card title="Account Profile" class="alert alert-success">
            <p>Account profile linked to the employee</p>
            <div class="d-flex justify-content-md-between align-items-md-center flex-column flex-md-row">
                <div class="mb-2 mb-md-0">
                    <p class="fs-4 mb-1 text-md-center">Username</p>
                    <h5 class="fw-bolder"> {{ $employee->user->username }}</h5>
                </div>
                <div class="mb-2 mb-md-0">
                    <p class="fs-4 mb-1 text-md-center">Email</p>
                    <h5 class="fw-bolder"> {{ $employee->user->email }}</h5>
                </div>
                <div class="mb-2 mb-md-0">
                    <p class="fs-4 mb-1 text-md-center">Role</p>
                    @foreach ($employee->user->roles as $role)
                        <h5 class="fw-bolder"> {{ $role->name }}</h5>
                    @endforeach
                </div>
            </div>
        </x-card>
    @endif
    <div class="accordion" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#employeeProfile" aria-expanded="false" aria-controls="employeeProfile">
                    Employee Profile
                </button>
            </h2>
            <div id="employeeProfile" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <x-card title="Edit employee profile">
                        <p class="">Update your employee profile information</p>
                        <form action="{{ route('employees.update', ['employee' => $employee->id]) }}" method="post">
                            @csrf
                            @method('put')
                            <div class="mb-3">
                                <x-label-input for="inputKtp">KTP Number</x-label-input>
                                <x-text-input name="ktp_number" id="inputKtp" type="text"
                                    value="{{ old('ktp_number', $employee->ktp_number) }}" />
                            </div>
                            <div class="row mb-md-3">
                                <div class="col-md-4 mb-3 mb-md-0">
                                    <x-label-input for="inputTitleFront">Title Front</x-label-input>
                                    <x-text-input name="title_front" id="inputTitleFront" type="text"
                                        value="{{ old('title_front', $employee->title_front) }}" placeholder="Dr." />
                                </div>
                                <div class="col-md-4 mb-3 mb-md-0">
                                    <x-label-input for="inputFullname">Fullname</x-label-input>
                                    <x-text-input name="fullname" id="inputFullname" type="text"
                                        value="{{ old('fullname', $employee->fullname) }}" placeholder="Jhone Christ" />
                                </div>
                                <div class="col-md-4 mb-3 mb-md-0">
                                    <x-label-input for="inputTitleBack">Title Back</x-label-input>
                                    <x-text-input name="title_back" id="inputTitleBack" type="text"
                                        value="{{ old('title_back', $employee->title_back) }}" placeholder="S.Pd" />
                                </div>
                            </div>
                            <div class="row mb-md-3">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <x-label-input for="inputNick">Nickname</x-label-input>
                                    <x-text-input name="nickname" id="inputNick" type="text"
                                        value="{{ old('nickname', $employee->nickname) }}" placeholder="Jhone" />
                                </div>
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <x-label-input for="inputWWA">Whatsapp Number</x-label-input>
                                    <x-text-input name="whatsapp_number" id="inputWWA" type="text"
                                        value="{{ old('whatsapp_number', $employee->whatsapp_number) }}"
                                        placeholder="Jhone" />
                                </div>
                            </div>
                            <div class="row mb-md-3">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <x-label-input for="inputBirthday">Birthday</x-label-input>
                                    <x-text-input name="birthday" id="inputBirthday" type="date"
                                        value="{{ old('birthday', $employee->birthday) }}" />
                                </div>
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <x-label-input for="inputBirthplace">Birthplace</x-label-input>
                                    <x-text-input name="birthplace" id="inputBirthplace" type="text"
                                        value="{{ old('birthplace', $employee->birthplace) }}" placeholder="Jakarta" />
                                </div>
                            </div>
                            <div class="row mb-md-3">
                                <div class="col-md-4 mb-3 mb-md-0">
                                    <x-label-input for="inputReligion">Religion</x-label-input>
                                    <x-select-input name="religion" id="inputReligion">
                                        @foreach ($religions as $item)
                                            <option
                                                value="{{ $item }}"{{ $item == old('religion', $employee->religion) ? 'selected' : '' }}>
                                                {{ str_replace('_', ' ', $item) }}
                                            </option>
                                        @endforeach
                                    </x-select-input>
                                </div>
                                <div class="col-md-4 mb-3 mb-md-0">
                                    <x-label-input for="inputMarital">Marital Status</x-label-input>
                                    <x-select-input name="marital_status" id="inputMarital">
                                        @foreach ($maritals as $item)
                                            <option
                                                value="{{ $item }}"{{ $item == old('marital_status', $employee->marital_status) ? 'selected' : '' }}>
                                                {{ str_replace('_', ' ', $item) }}
                                            </option>
                                        @endforeach
                                    </x-select-input>
                                </div>
                                <div class="col-md-4 mb-3 mb-md-0">
                                    <x-label-input for="inputBlood">Blood Type</x-label-input>
                                    <x-select-input name="blood_type" id="inputBlood">
                                        @foreach ($blood_type as $item)
                                            <option
                                                value="{{ $item }}"{{ $item == old('blood_type', $employee->blood_type) ? 'selected' : '' }}>
                                                {{ $item }}
                                            </option>
                                        @endforeach
                                    </x-select-input>
                                </div>
                            </div>
                            <div class="mb-3">
                                <x-label-input>Gender</x-label-input>
                                <div class="d-flex gap-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="Male"
                                            value="MALE"{{ old('gender', $employee->gender) == 'MALE' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="Male">MALE</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="Female"
                                            value="FEMALE"{{ old('gender', $employee->gender) == 'FEMALE' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="Female">FEMALE</label>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success">Update</button>
                        </form>
                    </x-card>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#familyTab" aria-expanded="false" aria-controls="familyTab">
                    Family Data
                </button>
            </h2>
            <div id="familyTab" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <x-layouts.family.table :data="$family" />
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#educationTab" aria-expanded="false" aria-controls="educationTab">
                    Education Data
                </button>
            </h2>
            <div id="educationTab" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <x-layouts.educations.table :data="$educations" />
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#certificateTab" aria-expanded="false" aria-controls="certificateTab">
                    Certificate Data
                </button>
            </h2>
            <div id="certificateTab" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <x-layouts.certificates.table :data="$certificates" />
                </div>
            </div>
        </div>
    </div>

</x-auth-app>
