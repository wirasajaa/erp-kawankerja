@props(['data' => []])
<x-card title="Certificates">
    <a href="{{ route('certificates.create') }}" class="btn btn-success">Add new</a>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Type</th>
                <th>Title</th>
                <th>Publish Date</th>
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
                        <td>{{ $item->type }}</td>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->publish_date }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a class="btn btn-sm btn-info"
                                    href="{{ route('certificates.edit', ['certificate' => $item->id]) }}"
                                    aria-expanded="false">
                                    <span>
                                        <i class="ti ti-pencil"></i>
                                    </span>
                                </a>
                                <form action="{{ route('certificates.delete', ['certificate' => $item->id]) }}"
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
