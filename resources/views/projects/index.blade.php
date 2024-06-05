<x-auth-app>
    @push('style')
        <link rel="stylesheet" href="{{ asset('css/dataTables.dataTables.css') }}">
    @endpush
    <x-card title="Manage Projects">
        <a href="{{ route('projects.create') }}" class="btn btn-success mb-4">Build new project</a>
        <table class="table" id="example">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>PIC</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if (empty($projects))
                    <tr>
                        <td colspan="5" class="fw-bold text-center text-dark">Data is empty</td>
                    </tr>
                @else
                    @foreach ($projects as $key => $project)
                        <tr>
                            <td>{{ $projects->firstItem() + $key }}</td>
                            <td>{{ $project->name }}</td>
                            <td>{{ @$project->lead->fullname ?? 'NOT SELECTED' }}</td>
                            <td>{{ $project->status . '|' . $project->cycle }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a class="btn btn-sm btn-info"
                                        href="{{ route('projects.edit', ['project' => $project->id]) }}"
                                        aria-expanded="false">
                                        <span>
                                            <i class="ti ti-pencil"></i>
                                        </span>
                                    </a>
                                    <a class="btn btn-sm btn-info"
                                        href="{{ route('projects.preview', ['project' => $project->id]) }}"
                                        aria-expanded="false">
                                        <span>
                                            <i class="ti ti-eye"></i>
                                        </span>
                                    </a>
                                    <a class="btn btn-sm btn-info"
                                        href="{{ route('projects.report', ['project' => $project->id]) }}"
                                        aria-expanded="false">
                                        <span>
                                            <i class="ti ti-report"></i>
                                        </span>
                                    </a>
                                    <form action="{{ route('projects.delete', ['project' => $project->id]) }}"
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
        {{ $projects->links() }}
    </x-card>
    @push('script')
        <script src="{{ asset('js/dataTables.js') }}"></script>
        <script>
            $('#example').DataTable();
        </script>
    @endpush
</x-auth-app>
