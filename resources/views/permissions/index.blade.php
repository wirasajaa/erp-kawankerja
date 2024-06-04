<x-auth-app>
    @push('style')
        <link rel="stylesheet" href="{{ asset('css/dataTables.dataTables.css') }}">
    @endpush
    <x-card title="Manage Permission Data">
        <a href="{{ route('permissions.create') }}" class="btn btn-success">Create New Permission</a>
        <table id="example" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Roles</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($permissions as $permission)
                    <tr>
                        <td>{{ $permission->name }}</td>
                        <td style="white-space: nowrap;">
                            <div class="d-flex gap-1 flex-wrap" style="max-width: 100%;">
                                @foreach ($permission->roles as $role)
                                    <div class="btn btn-sm btn-info">
                                        <span>{{ $role->name }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('permissions.edit', ['permission' => $permission->name]) }}"
                                    class="btn btn-warning btn-sm" title="edit data">
                                    <span><i class="ti ti-pencil fs-4"></i></span>
                                </a>
                                <form action="{{ route('permissions.delete', ['permission' => $permission->id]) }}"
                                    method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger btn-sm" title="delete data"
                                        message="this data will be gone forever" id="btn-confirm">
                                        <span><i class="ti ti-trash fs-4"></i></span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>Name</th>
                    <th>Roles</th>
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
