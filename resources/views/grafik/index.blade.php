@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Grafik Pemakaian Kendaraan Berdasarkan Status</h1>

        <div class="card">
            <div class="card-body">
                <canvas id="kendaraanStatusChart" height="120"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('kendaraanStatusChart').getContext('2d');

        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                        label: 'Pending',
                        backgroundColor: 'orange',
                        data: {!! json_encode($totalsPerStatus['pending']) !!}
                    },
                    {
                        label: 'Menunggu Approver 2',
                        backgroundColor: 'blue',
                        data: {!! json_encode($totalsPerStatus['menunggu approver 2']) !!}
                    },
                    {
                        label: 'Approved',
                        backgroundColor: 'green',
                        data: {!! json_encode($totalsPerStatus['approved']) !!}
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                }
            }
        });
    </script>
@endsection
