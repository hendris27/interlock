<x-app-layout title="Dashboard">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h2 style="font-size: 1.2rem; font-weight: 700; margin: 0;">Master Data List</h2>
        <a href="{{ route('master-data.create') }}" class="btn btn-primary">+ Add New</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Model Name</th>
                <th>Item Name</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($masterDataList as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->model_name }}</td>
                    <td>{{ $item->item_name }}</td>
                    <td>{{ $item->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('master-data.edit', ['master_datum' => $item->id]) }}" class="btn"
                            style="padding: 0.4rem 0.8rem; font-size: 0.7rem;">Edit</a>
                        <form action="{{ route('master-data.destroy', ['master_datum' => $item->id]) }}" method="POST"
                            style="display: inline;" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                style="padding: 0.4rem 0.8rem; font-size: 0.7rem;">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 2rem;">No data found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</x-app-layout>
