<x-auth-app>
    <x-card title="Detail Project">
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
        <a href="{{ route('projects.employee.create') }}" class="btn btn-success">Add new employee</a>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Status</th>
                    <th>Notes</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if (is_null($project->employees))
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
                            <td>
                                <div class="d-flex gap-1">
                                    <a class="btn btn-sm btn-info"
                                        href="{{ route('projects.employee.edit', ['employee' => $item->id]) }}"
                                        aria-expanded="false">
                                        <span>
                                            <i class="ti ti-pencil"></i>
                                        </span>
                                    </a>
                                    <form action="{{ route('projects.employee.delete', ['employee' => $item->id]) }}"
                                        method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-sm btn-danger confirm-delete">
                                            <span>
                                                <i class="ti ti-trash"></i>
                                            </span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </x-card>
</x-auth-app>
