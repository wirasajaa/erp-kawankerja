<x-auth-app>
    @push('style')
        <link rel="stylesheet" href="{{ asset('css/dataTables.dataTables.css') }}">
    @endpush
    <x-card title="Manage User Data">
        <a href="{{ route('users.create') }}" class="btn btn-success">Create New Account</a>
        <table id="example" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Position</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <div class="d-flex">
                                @foreach ($user->roles as $role)
                                    <div class="btn btn-sm btn-info">
                                        <span>{{ $role->name }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                @if ($user->deleted_at == null)
                                    <a href="{{ route('users.edit', ['username' => $user->username]) }}"
                                        class="btn btn-info btn-sm" title="view detail">
                                        <span><i class="ti ti-eye fs-4"></i></span>
                                    </a>
                                    <a href="{{ route('users.edit', ['username' => $user->username]) }}"
                                        class="btn btn-warning btn-sm" title="edit data">
                                        <span><i class="ti ti-pencil fs-4"></i></span>
                                    </a>
                                    <form action="{{ route('users.delete', ['user' => $user->id]) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger btn-sm" title="delete data"
                                            message="this data will be gone forever" id="btn-confirm">
                                            <span><i class="ti ti-trash fs-4"></i></span>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('users.restore', ['user' => $user->id]) }}" method="post">
                                        @csrf
                                        @method('put')
                                        <button type="submit" class="btn btn-success btn-sm" title="restore data"
                                            message="this data will be restored" id="btn-confirm">
                                            <span><i class="ti ti-refresh fs-4"></i></span>
                                        </button>
                                    </form>
                                    <form action="{{ route('users.delete.permanent', ['user' => $user->id]) }}"
                                        method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-dark btn-sm" title="delete permanent"
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
                    <th>Username</th>
                    <th>Email</th>
                    <th>Position</th>
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
