@props(['religions' => [], 'maritals' => [], 'blood_type' => [], 'url' => ''])

<form action="{{ $url }}" method="post">
    @csrf
    <div class="mb-3">
        <x-label-input for="inputKtp">KTP Number</x-label-input>
        <x-text-input name="ktp_number" id="inputKtp" type="text" value="{{ old('ktp_number') }}" />
    </div>
    <div class="row mb-md-3">
        <div class="col-md-4 mb-3 mb-md-0">
            <x-label-input for="inputTitleFront">Title Front</x-label-input>
            <x-text-input name="title_front" id="inputTitleFront" type="text" value="{{ old('title_front') }}"
                placeholder="Dr." />
        </div>
        <div class="col-md-4 mb-3 mb-md-0">
            <x-label-input for="inputFullname">Fullname</x-label-input>
            <x-text-input name="fullname" id="inputFullname" type="text" value="{{ old('fullname') }}"
                placeholder="Jhone Christ" />
        </div>
        <div class="col-md-4 mb-3 mb-md-0">
            <x-label-input for="inputTitleBack">Title Back</x-label-input>
            <x-text-input name="title_back" id="inputTitleBack" type="text" value="{{ old('title_back') }}"
                placeholder="S.Pd" />
        </div>
    </div>
    <div class="row mb-md-3">
        <div class="col-md-6 mb-3 mb-md-0">
            <x-label-input for="inputNick">Nickname</x-label-input>
            <x-text-input name="nickname" id="inputNick" type="text" value="{{ old('nickname') }}"
                placeholder="Jhone" />
        </div>
        <div class="col-md-6 mb-3 mb-md-0">
            <x-label-input for="inputWWA">Whatsapp Number</x-label-input>
            <x-text-input name="whatsapp_number" id="inputWWA" type="text" value="{{ old('whatsapp_number') }}"
                placeholder="Jhone" />
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
    <div class="row mb-md-3">
        <div class="col-md-4 mb-3 mb-md-0">
            <x-label-input for="inputReligion">Religion</x-label-input>
            <x-select-input name="religion" id="inputReligion">
                @foreach ($religions as $item)
                    <option value="{{ $item }}"{{ $item == old('religion') ? 'selected' : '' }}>
                        {{ str_replace('_', ' ', $item) }}
                    </option>
                @endforeach
            </x-select-input>
        </div>
        <div class="col-md-4 mb-3 mb-md-0">
            <x-label-input for="inputMarital">Marital Status</x-label-input>
            <x-select-input name="marital_status" id="inputMarital">
                @foreach ($maritals as $item)
                    <option value="{{ $item }}"{{ $item == old('marital_status') ? 'selected' : '' }}>
                        {{ str_replace('_', ' ', $item) }}
                    </option>
                @endforeach
            </x-select-input>
        </div>
        <div class="col-md-4 mb-3 mb-md-0">
            <x-label-input for="inputBlood">Blood Type</x-label-input>
            <x-select-input name="blood_type" id="inputBlood">
                @foreach ($blood_type as $item)
                    <option value="{{ $item }}"{{ $item == old('blood_type') ? 'selected' : '' }}>
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
    <button type="submit" class="btn btn-success">Save</button>
</form>
