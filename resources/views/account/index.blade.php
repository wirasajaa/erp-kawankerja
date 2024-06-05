<x-auth-app>
    <x-card title="My Account">
        <x-card title="Profile Information" class="shadow">
            <p class="mb-4">Update your profile information and email address</p>
            <form action="{{ route('accounts.change-profile', ['user' => auth()->user()->id]) }}" method="POST">
                @csrf
                @method('put')
                <div class="mb-3">
                    <x-label-input id="inputEmail">Email</x-label-input>
                    <x-text-input name="email" id="inputEmail" type="email"
                        value="{{ old('email', $user->email) }}" />
                </div>
                <div class="mb-3">
                    <x-label-input id="inputUName">Username</x-label-input>
                    <x-text-input name="username" id="inputUName" type="text"
                        value="{{ old('username', $user->username) }}" />
                </div>
                <button type="submit" class="btn btn-success confirm-change">Save</button>
            </form>
        </x-card>
    </x-card>
    <x-card title="Change Password" class="shadow">
        <p class="mb-4">Change your password if you forgot or your password is not secure anymore</p>
        <form action="{{ route('accounts.change-password', ['user' => auth()->user()->id]) }}" method="POST">
            @csrf
            @method('put')
            <div class="mb-3">
                <x-label-input id="inputPass">Password</x-label-input>
                <x-text-input name="password" id="inputPass" type="password" value="{{ old('password') }}"
                    aria-describedby="passwordHelp" />
            </div>
            <div class="mb-3">
                <x-label-input id="inputConfirmPass">Confirm Password</x-label-input>
                <x-text-input name="password_confirmation" id="inputConfirmPass" type="password"
                    value="{{ old('password_confirmation') }}" aria-describedby="passwordHelp" />
            </div>
            <button type="submit" class="btn btn-warning confirm-change">Change</button>
        </form>
    </x-card>
</x-auth-app>
