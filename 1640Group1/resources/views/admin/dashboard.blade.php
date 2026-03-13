<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Home | Academic Portal</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>

body{
font-family:'Inter',sans-serif;
background:#f4f7fe;
margin:0;
display:flex;
}

/* Sidebar */

.sidebar{
width:280px;
height:100vh;
background:white;
padding:20px;
position:fixed;
box-shadow:2px 0 10px rgba(0,0,0,0.05);
display:flex;
flex-direction:column;
}

.university-brand{
padding:20px 10px;
border-bottom:1px solid #f0f0f0;
margin-bottom:20px;
}

.nav-link{
color:#6c757d;
padding:12px 15px;
border-radius:10px;
margin-bottom:5px;
transition:0.3s;
display:flex;
align-items:center;
}

.nav-link i{
margin-right:12px;
font-size:1.2rem;
}

.nav-link:hover,
.nav-link.active{
background:#e9f2ff;
color:#2b99d6;
}

/* Main content */

.main-content{
margin-left:280px;
padding:40px;
width:calc(100% - 280px);
}

.top-bar{
display:flex;
justify-content:flex-end;
align-items:center;
margin-bottom:30px;
gap:20px;
}

.profile-img{
width:45px;
height:45px;
border-radius:50%;
object-fit:cover;
}

/* card */

.stat-card{
background:white;
padding:25px;
border-radius:15px;
box-shadow:0 4px 6px rgba(0,0,0,0.02);
transition:0.3s;
}

.stat-card:hover{
transform:translateY(-5px);
box-shadow:0 8px 15px rgba(0,0,0,0.05);
}

.chart-title{
text-align:center;
font-weight:600;
margin-top:15px;
}

</style>

</head>

<body>

<!-- Sidebar -->

<div class="sidebar">

<div class="university-brand">
<h5 class="fw-bold mb-0 text-primary">
<i class="bi bi-mortarboard-fill"></i> ACADEMIC
</h5>
<small class="text-muted">Student Management</small>
</div>

<nav class="nav flex-column flex-grow-1">

<a class="nav-link" href="{{ route('admin.dashboard') }}">
<i class="bi bi-speedometer2"></i> Dashboard
</a>

<a class="nav-link" href="{{ route('admin.socialmedia') }}">
<i class="bi bi-book"></i> Social Media management
</a>

<a class="nav-link" href="{{ route('admin.staffmanagement') }}">
<i class="bi bi-calendar-event"></i> Staff management
</a>

</nav>


<div class="mt-auto">
<a class="nav-link" href="/logout">
<i class="bi bi-box-arrow-left"></i> Logout
</a>
</div>

</div>

<!-- Main Content -->

<div class="main-content">

<!-- top profile -->

<div class="top-bar">

<div class="text-end me-2">
<p class="mb-0 fw-bold small">John Doe</p>
<small class="text-muted">Student ID: 2024001</small>
</div>

<img src="https://i.pravatar.cc/150?u=john" class="profile-img">

</div>

<h2 class="fw-bold text-center mb-4">Ideas Summary</h2>

<div class="row g-4">

<!-- PIE CHART -->

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

<!-- BAR CHART -->

<div class="col-md-8">

<div class="stat-card">

<canvas id="staffChart"></canvas>

<p class="chart-title">Biểu đồ số lượng Staff đăng bài</p>

</div>

</div>

</div>

</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

/* Category Pie Chart */

const categoryChart = new Chart(
document.getElementById('categoryChart'),
{
type:'pie',

data:{
labels:['Math','History','English'],

datasets:[{
data:[35,25,40],

backgroundColor:[
'#2b99d6',
'#f6c23e',
'#1cc88a'
]

}]
}

}
);


/* Staff Bar Chart */

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

},

options:{
scales:{
y:{
beginAtZero:true
}
}
}

}
);

</script>
</style>
