@props(['data' => []])
<x-card title="Education Data">
    <a href="{{ route('educations.create') }}" class="btn btn-success">Add new</a>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Institution</th>
                <th>Major</th>
                <th>IPK</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if ($data->isEmpty())
                <tr class="bg-light">
                    <td colspan="5" class="fw-bold text-center text-dark">Data is empty</td>
                </tr>
            @else
                @foreach ($data as $key => $item)
                    <tr>
                        <td>{{ $data->firstItem() + $key }}</td>
                        <td>{{ $item->institution }}</td>
                        <td>{{ $item->major }}</td>
                        <td>{{ $item->ipk }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a class="btn btn-sm btn-info"
                                    href="{{ route('educations.edit', ['education' => $item->id]) }}"
                                    aria-expanded="false">
                                    <span>
                                        <i class="ti ti-pencil"></i>
                                    </span>
                                </a>
                                <form action="{{ route('educations.delete', ['education' => $item->id]) }}"
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
    {{ $data->links() }}
</x-card>
