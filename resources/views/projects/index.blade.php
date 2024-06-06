<x-auth-app>
    @push('style')
        <link rel="stylesheet" href="{{ asset('css/dataTables.dataTables.css') }}">
    @endpush
    <x-card title="Manage Projects">
        @canany(['is-admin', 'is-hr'])
            <a href="{{ route('projects.create') }}" class="btn btn-success mb-4">Build new project</a>
        @endcanany
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
                            <td>{{ $key + $key + 1 }}</td>
                            <td>{{ $project->name }}</td>
                            <td>{{ @$project->lead->fullname ?? 'NOT SELECTED' }}</td>
                            <td>{{ $project->status . '|' . $project->cycle }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    @canany(['is-admin', 'is-hr'])
                                        <a class="btn btn-sm btn-primary"
                                            href="{{ route('projects.edit', ['project' => $project->id]) }}"
                                            aria-expanded="false" title="Update project">
                                            <span>
                                                <i class="ti ti-pencil"></i>
                                            </span>
                                        </a>
                                        <a class="btn btn-sm btn-warning"
                                            href="{{ route('projects.preview', ['project' => $project->id]) }}"
                                            aria-expanded="false" title="Detail project">
                                            <span>
                                                <i class="ti ti-eye"></i>
                                            </span>
                                        </a>
                                    @endcanany
                                    <a class="btn btn-sm btn-info"
                                        href="{{ route('projects.report', ['project' => $project->id]) }}"
                                        aria-expanded="false" title="Report project">
                                        <span>
                                            <i class="ti ti-report"></i>
                                        </span>
                                    </a>
                                    @canany(['is-admin', 'is-hr'])
                                        <form action="{{ route('projects.delete', ['project' => $project->id]) }}"
                                            method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger" id="btn-confirm"
                                                title="Delete project">
                                                <span>
                                                    <i class="ti ti-trash"></i>
                                                </span>
                                            </button>
                                        </form>
                                    @endcanany
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </x-card>
    @push('script')
        <script src="{{ asset('js/dataTables.js') }}"></script>
        <script>
            $('#example').DataTable();
        </script>
    @endpush
</x-auth-app>
