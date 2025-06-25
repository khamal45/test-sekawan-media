<div class="overflow-x-auto">
    <table class="min-w-full bg-white border border-gray-200 rounded shadow-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="p-3 border-b">ID</th>
                <th class="p-3 border-b">Nama User</th>
                <th class="p-3 border-b">Kendaraan</th>
                <th class="p-3 border-b">Status</th>
                <th class="p-3 border-b">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($items as $item)
                <tr class="hover:bg-gray-50">
                    <td class="p-3 border-b">{{ $item->id }}</td>
                    <td class="p-3 border-b">{{ $item->user->name }}</td>
                    <td class="p-3 border-b">{{ $item->kendaraan->nama }}</td>
                    <td class="p-3 border-b">
                        <span
                            class="inline-block px-2 py-1 text-xs font-semibold rounded
                            @if ($item->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif ($item->status === 'approved') bg-green-100 text-green-800
                            @elseif ($item->status === 'rejected') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-700 @endif">
                            {{ ucfirst($item->status) }}
                        </span>
                    </td>
                    <td class="p-3 border-b space-x-2">
                        @if (in_array($status, ['pending', 'rejected']))
                            <form action="{{ route('approval.approve', $item->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                    class="bg-green-500 hover:bg-green-600 text-white text-sm px-3 py-1 rounded">Approve</button>
                            </form>
                        @endif

                        @if (in_array($status, ['pending', 'approved']))
                            <form action="{{ route('approval.reject', $item->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                    class="bg-red-500 hover:bg-red-600 text-white text-sm px-3 py-1 rounded">Reject</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center p-4 text-gray-500">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
