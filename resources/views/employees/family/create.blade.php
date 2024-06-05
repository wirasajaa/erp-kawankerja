<x-auth-app>
    <x-card title="Add new family">
        <form action="{{ route('family.store', []) }}" method="post">
            @csrf
            <div class="row mb-md-3">
                <div class="col-md-6 mb-3 mb-md-0">
                    <x-label-input for="inputIdentity">Identity Number</x-label-input>
                    <x-text-input name="identity_number" type="text" id="inputIdentity"
                        value="{{ old('identity_number') }}" />
                </div>
                <div class="col-md-6 mb-3 mb-md-0">
                    <x-label-input for="inputName">Name</x-label-input>
                    <x-text-input name="name" type="text" id="inputName" value="{{ old('name') }}" />
                </div>
            </div>
            <div class="row mb-md-3">
                <div class="col-md-6 mb-3 mb-md-0">
                    <x-label-input for="inputRelation">Relations</x-label-input>
                    <x-select-input name="relationship" id="inputRelation">
                        @foreach ($relations as $item)
                            <option
                                value="{{ $item->value }}"{{ $item->value == old('relationship') ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </x-select-input>
                </div>
                <div class="col-md-6 mb-3 mb-md-0">
                    <x-label-input>Gender</x-label-input>
                    <div class="d-flex gap-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" id="Male"
                                value="MALE"{{ old('gender') == 'MALE' ? 'checked' : '' }}>
                            <label class="form-check-label" for="Male">MALE</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" id="Female"
                                value="FEMALE"{{ old('gender') == 'FEMALE' ? 'checked' : '' }}>
                            <label class="form-check-label" for="Female">FEMALE</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-md-3">
                <div class="col-md-6 mb-3 mb-md-0">
                    <x-label-input for="inputBirthday">Birthday</x-label-input>
                    <x-text-input name="birthday" id="inputBirthday" type="date" value="{{ old('birthday') }}" />
                </div>
                <div class="col-md-6 mb-3 mb-md-0">
                    <x-label-input for="inputBirthplace">Birthplace</x-label-input>
                    <x-text-input name="birthplace" id="inputBirthplace" type="text" value="{{ old('birthplace') }}"
                        placeholder="Jakarta" />
                </div>
            </div>
            <button class="btn btn-success" type="submit">Save</button>
        </form>
    </x-card>
</x-auth-app>
