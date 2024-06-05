<x-auth-app>
    <x-card title="Add new certificate">
        <form action="{{ route('certificates.store', []) }}" method="post">
            @csrf
            <div class="row mb-md-3">
                <div class="col-md-6 mb-3 mb-md-0">
                    <x-label-input for="inputSource">Source Certificate</x-label-input>
                    <x-select-input name="type" id="inputSource">
                        @foreach ($types as $item)
                            <option value="{{ $item->value }}"{{ $item->value == old('type') ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </x-select-input>
                </div>
                <div class="col-md-6 mb-3 mb-md-0">
                    <x-label-input for="inputNumber">Number Certificate</x-label-input>
                    <x-text-input name="number" id="inputNumber" type="text" value="{{ old('number') }}" />
                </div>
            </div>
            <div class="mb-3">
                <x-label-input for="inputTitle">Title</x-label-input>
                <x-text-input name="title" id="inputTitle" type="text" value="{{ old('title') }}" />
            </div>
            <div class="mb-3">
                <x-label-input for="inputDesc">Description</x-label-input>
                <textarea class="form-control" name="description" id="inputDesc" cols="30" rows="5">{{ old('description') }}</textarea>
            </div>
            <div class="row mb-md-3">
                <div class="col-md-4 mb-3 mb-md-0">
                    <x-label-input for="inputPublish">Publish Date</x-label-input>
                    <x-text-input name="publish_date" id="inputPublish" type="date"
                        value="{{ old('publish_date') }}" />
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <x-label-input for="inputDateStart">Date Start</x-label-input>
                    <x-text-input name="date_start" id="inputDateStart" type="date"
                        value="{{ old('date_start') }}" />
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <x-label-input for="inputDateEnd">Date End</x-label-input>
                    <x-text-input name="date_end" id="inputDateEnd" type="date" value="{{ old('date_end') }}" />
                </div>
            </div>
            <button type="submit" class="btn btn-success">Save</button>
        </form>
    </x-card>
</x-auth-app>
