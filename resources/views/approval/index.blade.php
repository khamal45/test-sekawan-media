@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto p-4">
        <h1 class="text-2xl font-bold mb-6">Daftar Pemesanan Kendaraan</h1>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">{{ session('error') }}</div>
        @endif

        <div x-data="{ tab: 'pending' }">
            <div class="flex space-x-4 mb-4">
                <button @click="tab = 'pending'"
                    :class="tab === 'pending' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800'"
                    class="px-4 py-2 rounded">
                    Pending
                </button>
                <button @click="tab = 'approved'"
                    :class="tab === 'approved' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800'"
                    class="px-4 py-2 rounded">
                    Approved
                </button>
                <button @click="tab = 'rejected'"
                    :class="tab === 'rejected' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800'"
                    class="px-4 py-2 rounded">
                    Rejected
                </button>
            </div>

            <div x-show="tab === 'pending'">
                @include('approval.partials.table', ['items' => $pending, 'status' => 'pending'])
            </div>

            <div x-show="tab === 'approved'" x-cloak>
                @include('approval.partials.table', ['items' => $approved, 'status' => 'approved'])
            </div>

            <div x-show="tab === 'rejected'" x-cloak>
                @include('approval.partials.table', ['items' => $rejected, 'status' => 'rejected'])
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/alpinejs" defer></script>
@endpush
