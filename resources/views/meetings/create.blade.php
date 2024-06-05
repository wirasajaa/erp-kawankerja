<x-auth-app>
    <x-card title="Create new schedule">
        <form action="{{ route('meetings.store') }}" method="post">
            @csrf
            <div class="mb-3">
                <x-label-input for="inputProject">Project</x-label-input>
                <x-select-input name="project_id" id="inputProject">
                    @if ($projects)
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}"{{ old('project_id') == $project->id ? 'selected' : '' }}>
                                {{ $project->name }}
                            </option>
                        @endforeach
                    @else
                        <option value="">
                            No selectable projects!
                        </option>
                    @endif
                </x-select-input>
            </div>
            <div class="row mb-md-3">
                <div class="col-md-4 mb-3 mb-md-0">
                    <x-label-input for="inputDate">Meeting Date</x-label-input>
                    <x-text-input name="meeting_date" type="date" id="inputDate" value="{{ old('meeting_date') }}" />
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <x-label-input for="inputStart">Meeting Start</x-label-input>
                    <x-text-input name="meeting_start" type="time" id="inputStart"
                        value="{{ old('meeting_start') }}" />
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <x-label-input for="inputEnd">Meeting End</x-label-input>
                    <x-text-input name="meeting_end" type="time" id="inputEnd" value="{{ old('meeting_end') }}" />
                </div>
            </div>
            <div class="mb-3">
                <x-label-input for="inputDesc">Description</x-label-input>
                <textarea name="description" id="inputDesc" cols="30" rows="3" class="form-control">{{ old('description') }}</textarea>
            </div>
            <button type="submit" class="btn btn-success">Save</button>
        </form>
    </x-card>
</x-auth-app>
