@props(['data' => []])
<x-card title="Family Data">
    <a href="{{ route('family.create') }}" class="btn btn-success">Add new</a>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Relation</th>
                <th>Gender</th>
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
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->relationship }}</td>
                        <td>{{ $item->gender }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a class="btn btn-sm btn-info" href="{{ route('family.edit', ['family' => $item->id]) }}"
                                    aria-expanded="false">
                                    <span>
                                        <i class="ti ti-pencil"></i>
                                    </span>
                                </a>
                                <form action="{{ route('family.delete', ['family' => $item->id]) }}" method="post">
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
