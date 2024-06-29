<x-auth-app>
    @push('style')
        <link rel="stylesheet" href="{{ asset('css/dataTables.dataTables.css') }}">
    @endpush
    <x-card title="Manage Employee Data">
        <a href="{{ route('employees.create') }}" class="btn btn-success mb-4">Add new employee</a>
        <table class="table" id="employeeTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>NIP</th>
                    <th>Fullname</th>
                    <th>Position</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $key => $employee)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $employee->nip ?? 'NIP is not set' }}</td>
                        <td>{{ $employee->fullname }}</td>
                        <td>
                            @if (empty($employee->user->roles))
                                <span class="text-warning fw-bold">Position is not set</span>
                            @else
                                @foreach ($employee->user->roles as $role)
                                    <div class="btn btn-sm btn-info">
                                        <span>{{ $role->name }}</span>
                                    </div>
                                @endforeach
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a class="btn btn-sm btn-info"
                                    href="{{ route('employees.edit', ['employee' => $employee->id]) }}"
                                    aria-expanded="false" title="Edit User Data">
                                    <span>
                                        <i class="ti ti-pencil"></i>
                                    </span>
                                </a>
                                <form action="{{ route('employees.delete', ['employee' => $employee->id]) }}"
                                    method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        message="this data will be gone forever" id="btn-confirm">
                                        <span>
                                            <i class="ti ti-trash"></i>
                                        </span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-card>
    @push('script')
        <script src="{{ asset('js/dataTables.js') }}"></script>
        <script>
            $('#employeeTable').DataTable({
                order: [
                    [2, 'asc']
                ]
            });
        </script>
    @endpush
</x-auth-app>
