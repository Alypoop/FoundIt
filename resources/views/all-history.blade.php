<x-layout>
    <div class="container py-4">
        <a href="{{ url()->previous() }}" class="btn btn-danger mb-3">← Back</a>

        <h3>History of All Items</h3>

        @if ($histories->isEmpty())
            <p>No history available for any item.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Location</th>
                        <th>Action</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Changed By</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($histories as $history)
                        <tr>
                            <td>@if ($history->item)
                            <a href="{{ url('/item/' . $history->item->id) }}">{{ $history->item->title }}</a>
                            @else
                                Unknown
                            @endif
                            </td>
                            <td>{{ $history->item->location ?? 'Unknown' }}</td>
                            <td>{{ $history->action }}</td>
                            <td>{{ $history->changed_from }}</td>
                            <td>{{ $history->changed_to }}</td>
                            <td>{{ $history->changed_by }}</td>
                            <td>{{ $history->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-layout>