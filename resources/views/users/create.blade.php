<x-auth-app>
    <x-card title="Add New User Account">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="row mb-md-3">
                <div class="col-md-6 mb-3 mb-md-0">
                    <x-label-input for="inputUname">Username</x-label-input>
                    <x-text-input name="username" id="inputUname" placeholder="jhone_one23" value="{{ old('username') }}"
                        type="text" />
                </div>
                <div class="col-md-6 mb-3 mb-md-0">
                    <x-label-input for="inputEmail">Email</x-label-input>
                    <x-text-input name="email" id="inputEmail" placeholder="jhone_one23" value="{{ old('email') }}"
                        type="email" />
                </div>
            </div>
            <div class="mb-3">
                <x-label-input for="inputRole">Role Type</x-label-input>
                <x-select-input name="role_name" id="inputRole">
                    @if ($role_options->isEmpty())
                        <option>No Options</option>
                    @else
                        @foreach ($role_options as $option)
                            <option value="{{ $option }}"{{ old('role_name') == $option ? ' selected' : '' }}>
                                {{ $option }}</option>
                        @endforeach
                    @endif
                </x-select-input>
            </div>
            <div class="mb-3">
                <x-label-input for="inputEmployee">Employee Data</x-label-input>
                <x-select-input name="employee_id" id="inputEmployee">
                    @if (count((array) $employee_options) < 1)
                        <option>No Options</option>
                    @else
                        @foreach ($employee_options as $option)
                            <option
                                value="{{ $option->id }}"{{ old('employee_id') == $option->id ? ' selected' : '' }}>
                                {{ $option->title_front . ' ' . $option->fullname . ' ' . $option->title_back }}
                            </option>
                        @endforeach
                    @endif
                </x-select-input>
            </div>
            <div class="mb-3">
                <x-label-input for="inputPass">Password</x-label-input>
                <x-text-input type="password" name="password" id="inputRole" value="{{ old('password') }}"
                    placeholder="********" helper="{!! 'default password is \'' . config('app.default_password') . '\'' !!} " />
            </div>
            <div class="mb-3">
                <x-label-input for="inputPass">Password</x-label-input>
                <x-text-input type="password" name="confirm_password" id="inputRole" value="{{ old('password') }}"
                    placeholder="********" />
            </div>
            <button class="btn btn-success" type="submit">Save</button>
        </form>
    </x-card>
</x-auth-app>
