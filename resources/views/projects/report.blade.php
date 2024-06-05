<x-auth-app>
    <x-card title="Report Project">
        <h1 class="fw-bolder mt-3">{{ $project->name }}</h1>
        <h6>Created At {{ readDate($project->created_at) }}</h6>
        <div class="row align-items-center justify-content-between my-2">
            <div class="col">
                <h3>{{ $project->lead->fullname }}</h3>
            </div>
            <div class="col text-end">
                <p class="btn btn-warning btn-disabled">{{ $project->status . ' | ' . $project->cycle }}</p>
            </div>
        </div>
        <p>{{ $project->description }}</p>
        <hr>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Status</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                @if (count($project->employees) < 1)
                    <tr>
                        <td colspan="5" class="fw-bold text-center text-dark">Not have employees</td>
                    </tr>
                @else
                    @foreach ($project->employees as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->profile->fullname }}</td>
                            <td>{{ $item->profile->user->roles->first()->name }}</td>
                            <td><span
                                    class="rounded p-2 text-light{{ $item->status == 'ACTIVE' ? ' bg-success' : ' bg-dark' }}">{{ $item->status }}</span>
                            </td>
                            <td>{{ $item->notes }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <hr>
        <p class="fw-bolder text-primary">Meeting Schedules</p>
        @if (count($project->meetings) < 1)
            <p class="fw-bold text-center text-dark">Not have schedule</p>
        @else
            @foreach ($project->meetings as $meeting)
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h3 class="mb-3">{{ readDate($meeting->meeting_date) }} <span
                                    class="fs-3 rounded p-2 text-light {{ $meeting->status == 'DONE' ? ' bg-success' : ' bg-dark' }}">{{ $meeting->status }}</span>
                            </h3>
                            <p class="mb-1">Duration :
                                {{ $meeting->meeting_start . ' - ' . $meeting->meeting_end }}
                            </p>
                            <p class="fs-3">{{ $meeting->description }}</p>
                        </div>
                        <hr>
                        <p class="fw-bolder text-success">Meeting Absences</p>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Employee</th>
                                    <th>Status</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($project->meetings) < 1)
                                    <tr>
                                        <td colspan="5" class="fw-bold text-center text-dark">Not have absences
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($meeting->absences as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->profile->fullname }}</td>
                                            <td><span
                                                    class="rounded p-2 text-light{{ $item->status == 'PRESENT' ? ' bg-info' : ' bg-dark' }}">{{ $item->status }}</span>
                                            </td>
                                            <td>{{ $item->notes ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        @endif
    </x-card>
</x-auth-app>
