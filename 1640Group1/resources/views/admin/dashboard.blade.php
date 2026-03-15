@extends('layouts.app')

@section('content')

<h2 class="fw-bold text-center mb-4">Ideas Summary</h2>

<div class="row g-4">

<div class="col-md-4">

<div class="stat-card">

<canvas id="categoryChart"></canvas>

<p class="chart-title">Biểu đồ phân category đã đăng</p>

<div class="mt-3 small">
<p>Math: 35%</p>
<p>History: 25%</p>
<p>English: 40%</p>
</div>

</div>

</div>

<div class="col-md-8">

<div class="stat-card">

<canvas id="staffChart"></canvas>

<p class="chart-title">Biểu đồ số lượng Staff đăng bài</p>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const categoryChart = new Chart(
document.getElementById('categoryChart'),
{
type:'pie',
data:{
labels:['Math','History','English'],
datasets:[{
data:[35,25,40],
backgroundColor:['#2b99d6','#f6c23e','#1cc88a']
}]
}
});

const staffChart = new Chart(
document.getElementById('staffChart'),
{
type:'bar',
data:{
labels:['John','Anna','Mike','David'],
datasets:[{
label:'Posts',
data:[5,8,4,10],
backgroundColor:'#2b99d6'
}]
}
});

</script>

@endsection