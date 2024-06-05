<x-auth-app>
    @push('style')
        <link rel="stylesheet" href="{{ asset('css/dataTables.dataTables.css') }}">
    @endpush
    <x-card title="Manage Schedule">
        @canany(['super-admin'])
            <a href="{{ route('meetings.create', []) }}" class="btn btn-success mb-4">Create new schedule</a>
        @endcanany
        <table class="table" id="meetingTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Project</th>
                    <th>Date</th>
                    <th>Duration</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($meetings->isEmpty())
                    <tr>
                        <td colspan="6" class="fw-bold text-dark text-center bg-secondary-subtle">Not have schedule
                        </td>
                    </tr>
                @else
                    @foreach ($meetings as $key => $meeting)
                        <tr>
                            <td>{{ $meetings->firstItem() + $key }}</td>
                            <td>{{ $meeting->project->name }}</td>
                            <td>{{ readDate($meeting->meeting_date) }}</td>
                            <td>{{ readTime($meeting->meeting_start) . ' - ' . readTime($meeting->meeting_end) }}</td>
                            <td>{{ $meeting->description }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    @canany(['is-admin', 'is-level2', 'is-pic-project'], $meeting->project->id)
                                        <a class="btn btn-sm btn-warning"
                                            href="{{ route('meetings.edit', ['meeting' => $meeting->id]) }}"
                                            aria-expanded="false">
                                            <span>
                                                <i class="ti ti-pencil"></i>
                                            </span>
                                        </a>
                                        <a class="btn btn-sm btn-info"
                                            href="{{ route('meetings.preview', ['meeting' => $meeting->id]) }}"
                                            aria-expanded="false">
                                            <span>
                                                <i class="ti ti-eye"></i>
                                            </span>
                                        </a>
                                    @endcanany
                                    <a class="btn btn-sm btn-primary"
                                        href="{{ route('meetings.preview-only', ['meeting' => $meeting->id]) }}"
                                        aria-expanded="false">
                                        <span>
                                            <i class="ti ti-report-search"></i>
                                        </span>
                                    </a>
                                    @canany(['is-admin', 'is-level2', 'is-pic-project'], $meeting->project->id)
                                        <form action="{{ route('meetings.delete', ['meeting' => $meeting->id]) }}"
                                            method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger confirm-delete">
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
            $('#example').DataTable({
                order: [
                    [2, 'asc']
                ]
            });
        </script>
    @endpush
</x-auth-app>
