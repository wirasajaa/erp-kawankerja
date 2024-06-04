<x-auth-app>
    @push('style')
        <link rel="stylesheet" href="{{ asset('css/dataTables.dataTables.css') }}">
    @endpush
    <x-card title="Manage Role Data">
        <a href="{{ route('roles.create') }}" class="btn btn-success">Create New Account</a>
        <table id="example" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Permissions</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                    <tr>
                        <td>{{ $role->name }}</td>
                        <td style="white-space: nowrap;">
                            <div class="d-flex gap-1 flex-wrap" style="max-width: 100%;">
                                @foreach ($role->permissions as $permission)
                                    <div class="btn btn-sm btn-info">
                                        <span>{{ $permission->name }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                @if ($role->deleted_at == null)
                                    {{-- <a href="{{ route('roles.edit', ['role' => $role->id]) }}"
                                        class="btn btn-info btn-sm" title="view detail">
                                        <span><i class="ti ti-eye fs-4"></i></span>
                                    </a> --}}
                                    <a href="{{ route('roles.edit', ['role' => $role->name]) }}"
                                        class="btn btn-warning btn-sm" title="edit data">
                                        <span><i class="ti ti-pencil fs-4"></i></span>
                                    </a>
                                    <form action="{{ route('roles.delete', ['role' => $role->id]) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger btn-sm" title="delete data"
                                            message="this data will be gone forever" id="btn-confirm">
                                            <span><i class="ti ti-trash fs-4"></i></span>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>Name</th>
                    <th>Permissions</th>
                    <th>Action</th>
                </tr>
            </tfoot>
        </table>
    </x-card>
    @push('script')
        <script src="{{ asset('js/dataTables.js') }}"></script>
        <script>
            $('#example').DataTable();
        </script>
    @endpush
</x-auth-app>
