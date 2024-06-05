<x-auth-app>
    <x-card title="Add new education">
        <form action="{{ route('educations.store') }}" method="post">
            @csrf
            <div class="row mb-md-3">
                <div class="col-md-6 mb-3 mb-md-0">
                    <x-label-input for="inputLevel">Education Level</x-label-input>
                    <x-select-input name="education_level" id="inputRelation">
                        @foreach ($educations as $item)
                            <option value="{{ $item }}"{{ $item == old('education_level') ? 'selected' : '' }}>
                                {{ $item }}
                            </option>
                        @endforeach
                    </x-select-input>
                </div>
                <div class="col-md-6 mb-3 mb-md-0">
                    <x-label-input for="inputInstitution">Institution Name</x-label-input>
                    <x-text-input name="institution" type="text" id="inputInstitution"
                        value="{{ old('institution') }}" />
                </div>
            </div>
            <div class="row mb-md-3">
                <div class="col-md-6 mb-3 mb-md-0">
                    <x-label-input for="inputMajor">Major</x-label-input>
                    <x-text-input name="major" type="text" id="inputMajor" value="{{ old('major') }}" />
                </div>
                <div class="col-md-6 mb-3 mb-md-0">
                    <x-label-input for="inputIPK">IPK</x-label-input>
                    <x-text-input name="ipk" type="number" id="inputIPK" value="{{ old('ipk') }}" />
                </div>
            </div>
            <div class="row mb-md-3">
                <div class="col-md-6 mb-3 mb-md-0">
                    <x-label-input for="inputDateStart">Date Start</x-label-input>
                    <x-text-input name="date_start" type="date" id="inputDateStart"
                        value="{{ old('date_start') }}" />
                </div>
                <div class="col-md-6 mb-3 mb-md-0">
                    <x-label-input for="inputDateEnd">Date End</x-label-input>
                    <x-text-input name="date_end" type="date" id="inputDateEnd" value="{{ old('date_end') }}" />
                </div>
            </div>
            <button type="submit" class="btn btn-success">Save</button>
        </form>
    </x-card>
</x-auth-app>
