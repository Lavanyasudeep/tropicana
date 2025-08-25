@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Retail Inventory Management Dashboard</h1>
@stop

@section('content')
<div class="container-fluid" style="margin-top:30px;" >

    <!-- ✅ Info Boxes -->
    <div class="row">
        <div class="col-md-3">
            <x-adminlte-small-box title="$1.31M" text="Sales" icon="fas fa-dollar-sign text-white"
                theme="info" url="#" url-text="More info"/>
        </div>
        <div class="col-md-3">
            <x-adminlte-small-box title="29" text="Suppliers" icon="fas fa-truck text-white"
                theme="success" url="#" url-text="More info"/>
        </div>
        <div class="col-md-3">
            <x-adminlte-small-box title="97,383" text="Inventory Units" icon="fas fa-boxes text-white"
                theme="warning" url="#" url-text="More info"/>
        </div>
        <div class="col-md-3">
            <x-adminlte-small-box title="46,522" text="Upcoming Inventory" icon="fas fa-shipping-fast text-white"
                theme="danger" url="#" url-text="More info"/>
        </div>
    </div>

    <!-- ✅ Gauges -->
    <div class="row">
        @foreach ([
            ['id'=>'gauge1', 'title'=>'Days Inventory Outstanding', 'value'=>'16 Days'],
            ['id'=>'gauge2', 'title'=>'Average Lead Time', 'value'=>'2 Days'],
            ['id'=>'gauge3', 'title'=>'Sell Through Rate', 'value'=>'68.48%'],
            ['id'=>'gauge4', 'title'=>'Order Fill Rate', 'value'=>'97.50%'],
        ] as $gauge)
        <div class="col-md-3">
            <div class="card">
                <div class="card-header"><h5>{{ $gauge['title'] }}</h5></div>
                <div class="card-body text-center position-relative" style="height:250px">
                    <canvas id="{{ $gauge['id'] }}"></canvas>
                    <div class="position-absolute w-100 text-center font-weight-bold"
                         style="top:50%;left:50%;transform:translate(-50%,-50%)">
                         {{ $gauge['value'] }}
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- ✅ Charts -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><h5>Average Inventory Value by Category</h5></div>
                <div class="card-body">
                    <canvas id="barChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><h5>Returned Products by Category</h5></div>
                <div class="card-body">
                    <canvas id="treemapChart"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>
@stop

@section('js')
<!-- ✅ Chart.js libraries -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-chart-treemap"></script>

<script>
// ✅ Function to create gauges
function createGauge(id, value, max, color) {
    new Chart(document.getElementById(id), {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [value, max-value],
                backgroundColor: [color, '#e0e0e0'],
                borderWidth: 0
            }]
        },
        options: {
            cutout: '75%',
            plugins: { legend: { display: false }},
            rotation: -90,
            circumference: 180
        }
    });
}

// ✅ Gauges
createGauge('gauge1', 16, 30, '#36a2eb');
createGauge('gauge2', 2, 7, '#ffce56');
createGauge('gauge3', 68, 100, '#4bc0c0');
createGauge('gauge4', 98, 100, '#2ecc71');

// ✅ Bar Chart
new Chart(document.getElementById('barChart'), {
    type: 'bar',
    data: {
        labels: ['Confections', 'Beverages', 'Condiments', 'Seafood', 'Dairy Products', 'Grains/Cereals', 'Produce'],
        datasets: [{
            label: 'Inventory Value ($)',
            data: [1210000, 800630, 944400, 813450, 746740, 713290, 275120],
            backgroundColor: '#6c4ba5'
        }]
    },
    options: { responsive: true }
});

// ✅ Treemap Chart
new Chart(document.getElementById('treemapChart'), {
    type: 'treemap',
    data: {
        datasets: [{
            tree: [
                { category: 'Confections', value: 11 },
                { category: 'Beverages', value: 9 },
                { category: 'Dairy Products', value: 8 },
                { category: 'Seafood', value: 10 },
                { category: 'Condiments', value: 9 },
                { category: 'Grains/Cereals', value: 5 },
                { category: 'Produce', value: 5 },
            ],
            key: 'value',
            groups: ['category'],
            backgroundColor: (ctx) => {
                const colors = ['#ff9f40','#36a2eb','#ff6384','#9966ff','#4bc0c0','#c9cbcf','#7d5ba6'];
                return colors[ctx.index % colors.length];
            },
            borderWidth: 1,
            borderColor: 'white',
            labels: {
                display: true,
                align: 'center',
                formatter: (ctx) => ctx.raw._data.category + '\n' + ctx.raw.v + ' units'
            },
            font: {
                size: 14,
                weight: 'bold'
            },
            color: 'white'
        }]
    },
    options: { 
        plugins: { 
            legend: { display: false }
        }
    }
});

</script>
@stop