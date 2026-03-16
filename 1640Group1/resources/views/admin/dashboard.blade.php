@extends('layouts.app')

@section('content')

<h2 class="fw-bold text-center mb-4">Ideas Summary</h2>

<div class="row g-4">
    <div class="col-md-4">
        <div class="stat-card shadow-sm p-3 bg-white rounded">
            <canvas id="categoryChart"></canvas>
            <p class="chart-title text-center mt-3 fw-bold">Biểu đồ category đã đăng</p>
        </div>
    </div>

    <div class="col-md-8">
        <div class="stat-card shadow-sm p-3 bg-white rounded">
            <canvas id="staffChart"></canvas>
            <p class="chart-title text-center mt-3 fw-bold">Biểu đồ số lượng Staff đăng bài</p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

<script>
    // 1. BIỂU ĐỒ TRÒN (CATEGORY CHART)
    const categoryLabels = {!! $ideasByCategory->pluck('name')->toJson() !!};
    const categoryData = {!! $ideasByCategory->pluck('total')->toJson() !!};

    const categoryChart = new Chart(
        document.getElementById('categoryChart'),
        {
            type: 'pie',
            plugins: [ChartDataLabels],
            data: {
                labels: categoryLabels,
                datasets: [{
                    data: categoryData,
                    backgroundColor: ['#2b99d6', '#f6c23e', '#1cc88a', '#e74a3b', '#858796', '#36b9cc']
                }]
            },
            options: {
                plugins: {
                    datalabels: {
                        color: '#ffffff',
                        font: { weight: 'bold', size: 14 },
                        formatter: (value, context) => {
                            let sum = context.chart.data.datasets[0].data.reduce((a, b) => Number(a) + Number(b), 0);
                            let percentage = (value * 100 / sum).toFixed(1) + "%";
                            return percentage;
                        }
                    }
                }
            }
        }
    );

    // 2. BIỂU ĐỒ CỘT (STAFF CHART)
    const staffLabels = {!! $ideasByStaff->pluck('username')->toJson() !!};
    const staffData = {!! $ideasByStaff->pluck('total')->toJson() !!};

    const staffChart = new Chart(
        document.getElementById('staffChart'),
        {
            type: 'bar',
            data: {
                labels: staffLabels,
                datasets: [{
                    label: 'Số lượng bài đăng',
                    data: staffData,
                    backgroundColor: '#2b99d6'
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        }
    );
</script>

@endsection
