@extends('layout.admin')

@section('title')Dashboard | CodeTechEvolution @stop

@section('styles')
<link href="{{ asset('admin/vendors/@coreui/chartjs/css/coreui-chartjs.css') }}" rel="stylesheet">
@stop

@section('metas')<meta name="csrf-token" content="{{ csrf_token() }}"> @stop

@section('bred1')Inicio @stop
@section('bred2')Dashbooard @stop

@section('contenido')
<div class="row">
  <div class="col-sm-6 col-lg-3">
    <div class="card mb-4 text-white bg-primary-gradient">
      <div class="card-body pb-0 d-flex justify-content-between align-items-start">
        <div>
          <div class="fs-4 fw-semibold">{{ $totalRegistrosUsu }} 
            <span class="fs-6 fw-normal">({{ number_format($porcentajeDiferenciaUsu->porcentaje_diferencia, 2, ',', '.') }}
            @if ($porcentajeDiferenciaUsu->porcentaje_diferencia>0)
            <i class="fa-duotone fa-arrow-up icon"></i>
            @else
            <i class="fa-duotone fa-arrow-down icon"></i>
            @endif)
            </span>
          </div>
          <div>Usuarios</div>
        </div>
      </div>
      <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
        <canvas class="chart" id="card-chart1" height="70"></canvas>
      </div>
    </div>
  </div>
  <!-- /.col-->
  <div class="col-sm-6 col-lg-3">
    <div class="card mb-4 text-white bg-info-gradient">
      <div class="card-body pb-0 d-flex justify-content-between align-items-start">
        <div>
          <div class="fs-4 fw-semibold">{{ $totalRegistrosEnt }} 
            <span class="fs-6 fw-normal">({{ number_format($porcentajeDiferenciaEnt->porcentaje_diferencia,2, ',', '.') }}
            @if ($porcentajeDiferenciaEnt->porcentaje_diferencia>0)
            <i class="fa-duotone fa-arrow-up icon"></i>
            @else
            <i class="fa-duotone fa-arrow-down icon"></i>
            @endif)
            </span></div>
          <div>Posts</div>
        </div>
      </div>
      <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
        <canvas class="chart" id="card-chart2" height="70"></canvas>
      </div>
    </div>
  </div>
  <!-- /.col-->
  <div class="col-sm-6 col-lg-3">
    <div class="card mb-4 text-white bg-warning-gradient">
      <div class="card-body pb-0 d-flex justify-content-between align-items-start">
        <div>
          <div class="fs-4 fw-semibold">{{ $totalRegistrosProd }} 
            <span class="fs-6 fw-normal">({{ number_format($porcentajeDiferenciaProd->porcentaje_diferencia,2, ',', '.') }}
            @if ($porcentajeDiferenciaProd->porcentaje_diferencia>0)
            <i class="fa-duotone fa-arrow-up icon"></i>
            @else
            <i class="fa-duotone fa-arrow-down icon"></i>
            @endif)
          </span></div>
          <div>Productos</div>
        </div>
      </div>
      <div class="c-chart-wrapper mt-3" style="height:70px;">
        <canvas class="chart" id="card-chart3" height="70"></canvas>
      </div>
    </div>
  </div>
  <!-- /.col-->
  <div class="col-sm-6 col-lg-3">
    <div class="card mb-4 text-white bg-danger-gradient">
      <div class="card-body pb-0 d-flex justify-content-between align-items-start">
        <div>
          <div class="fs-4 fw-semibold">{{ $totalRegistrosCur }} 
            <span class="fs-6 fw-normal">({{ number_format($porcentajeDiferenciaCur->porcentaje_diferencia,2, ',', '.') }}
              @if ($porcentajeDiferenciaCur->porcentaje_diferencia>0)
              <i class="fa-duotone fa-arrow-up icon"></i>
              @else
              <i class="fa-duotone fa-arrow-down icon"></i>
              @endif)
            </span></div>
          <div>Cursos</div>
        </div>
      </div>
      <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
        <canvas class="chart" id="card-chart4" height="70"></canvas>
      </div>
    </div>
  </div>
  <!-- /.col-->
</div>
<div class="card mb-4">
  <div class="card-body">
    <div class="d-flex justify-content-between">
      <div>
        <h4 class="card-title mb-0">Compras</h4>
        @php
          $primerMes = substr($totalComprasMesProd->first()->mes, 5);
          $ultimoMes = substr($totalComprasMesProd->last()->mes, 5);
          $primerAnio = substr($totalComprasMesProd->first()->mes, 0, 4);
          $ultimoAnio = substr($totalComprasMesProd->last()->mes, 0, 4);
        @endphp
        <div class="small text-medium-emphasis" id="range-dates">{{ strftime("%B", mktime(0, 0, 0, $primerMes, 1)) }} {{ $primerAnio }} - {{ strftime("%B", mktime(0, 0, 0, $ultimoMes, 1)) }} {{ $ultimoAnio }}</div>
      </div>
      <div class="btn-toolbar d-none d-md-block" role="toolbar" aria-label="Toolbar with buttons">
        <div class="btn-group btn-group-toggle mx-3" data-coreui-toggle="buttons">
          <input class="btn-check" id="option1" type="radio" name="options" autocomplete="off" onclick="verificarCheckbox1()">
          <label class="btn btn-outline-secondary" for="option1"> Day</label>
          <input class="btn-check" id="option2" type="radio" name="options" autocomplete="off" checked onclick="verificarCheckbox2()">
          <label class="btn btn-outline-secondary" for="option2"> Month</label>
          <input class="btn-check" id="option3" type="radio" name="options" autocomplete="off" onclick="verificarCheckbox3()">
          <label class="btn btn-outline-secondary" for="option3"> Year</label>
        </div>
      </div>
    </div>
    <div class="c-chart-wrapper" style="height:300px;margin-top:40px;">
      <canvas class="chart" id="main-chart" height="300"></canvas>
    </div>
  </div>
</div>
<div class="row row-cols-1 row-cols-md-2">
  <div class="col">
    <div class="card mb-4">
      <div class="card-header"><strong>Top 10 Productos más vendidos</strong></div>
      <div class="card-body">
        <div class="tab-content rounded-bottom">
          <div class="tab-pane p-3 active preview" id="preview-1004">
            <div class="c-chart-wrapper">
              <canvas id="canvas-5"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="card mb-4">
      <div class="card-header"><strong>Top 10 Cursos más vendidos</strong></div>
      <div class="card-body">
        <div class="tab-content rounded-bottom">
          <div class="tab-pane p-3 active preview" id="preview-1005">
            <div class="c-chart-wrapper">
              <canvas id="canvas-6"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@stop

@section('scripts')
<script src="{{ asset('admin/vendors/chart.js/js/chart.min.js') }}"></script>
<script src="{{ asset('admin/vendors/@coreui/chartjs/js/coreui-chartjs.js') }}"></script>
<script src="{{ asset('admin/js/main.js') }}"></script>
<script>
  const cardChart1 = new Chart(document.getElementById('card-chart1'), {
    type: 'line',
    data: {
      labels: [
        @foreach ($registrosPorMesUsu as $usu)
        '{{ strftime("%B", mktime(0, 0, 0, $usu->mes, 1)) }}',
        @endforeach
      ],
      datasets: [{
        label: 'Usuarios',
        backgroundColor: 'transparent',
        borderColor: 'rgba(255,255,255,.55)',
        pointBackgroundColor: coreui.Utils.getStyle('--cui-primary'),
        data: [
          @foreach ($registrosPorMesUsu as $usu)
            {{ $usu->total_registros }},
          @endforeach
        ]
      }]
    },
    options: {
      plugins: {
        legend: {
          display: false
        }
      },
      maintainAspectRatio: false,
      scales: {
        x: {
          grid: {
            display: false,
            drawBorder: false
          },
          ticks: {
            display: false
          }
        },
        y: {
          min: -9,
          max: 70,
          display: false,
          grid: {
            display: false
          },
          ticks: {
            display: false
          }
        }
      },
      elements: {
        line: {
          borderWidth: 1,
          tension: 0.4
        },
        point: {
          radius: 4,
          hitRadius: 10,
          hoverRadius: 4
        }
      }
    }
  });
  const cardChart2 = new Chart(document.getElementById('card-chart2'), {
    type: 'line',
    data: {
      labels: [
        @foreach ($registrosPorMesEnt as $ent)
        '{{ strftime("%B", mktime(0, 0, 0, $ent->mes, 1)) }}',
        @endforeach
      ],
      datasets: [{
        label: 'Posts',
        backgroundColor: 'transparent',
        borderColor: 'rgba(255,255,255,.55)',
        pointBackgroundColor: coreui.Utils.getStyle('--cui-info'),
        data: [
          @foreach ($registrosPorMesEnt as $ent)
            {{ $ent->total_registros }},
          @endforeach
        ]
      }]
    },
    options: {
      plugins: {
        legend: {
          display: false
        }
      },
      maintainAspectRatio: false,
      scales: {
        x: {
          grid: {
            display: false,
            drawBorder: false
          },
          ticks: {
            display: false
          }
        },
        y: {
          min: -9,
          max: 39,
          display: false,
          grid: {
            display: false
          },
          ticks: {
            display: false
          }
        }
      },
      elements: {
        line: {
          borderWidth: 1
        },
        point: {
          radius: 4,
          hitRadius: 10,
          hoverRadius: 4
        }
      }
    }
  });
  const cardChart3 = new Chart(document.getElementById('card-chart3'), {
    type: 'line',
    data: {
      labels: [
        @foreach ($registrosPorMesProd as $prod)
        '{{ strftime("%B", mktime(0, 0, 0, $prod->mes, 1)) }}',
        @endforeach
      ],
      datasets: [{
        label: 'Productos',
        backgroundColor: 'rgba(255,255,255,.2)',
        borderColor: 'rgba(255,255,255,.55)',
        data: [
          @foreach ($registrosPorMesProd as $prod)
            {{ $prod->total_registros }},
          @endforeach
        ],
        fill: true
      }]
    },
    options: {
      plugins: {
        legend: {
          display: false
        }
      },
      maintainAspectRatio: false,
      scales: {
        x: {
          display: false
        },
        y: {
          display: false
        }
      },
      elements: {
        line: {
          borderWidth: 2,
          tension: 0.4
        },
        point: {
          radius: 0,
          hitRadius: 10,
          hoverRadius: 4
        }
      }
    }
  });
  const cardChart4 = new Chart(document.getElementById('card-chart4'), {
    type: 'bar',
    data: {
      labels: [
        @foreach ($registrosPorMesCur as $cur)
        '{{ strftime("%B", mktime(0, 0, 0, $cur->mes, 1)) }}',
        @endforeach
      ],
      datasets: [{
        label: 'Cursos',
        backgroundColor: 'rgba(255,255,255,.2)',
        borderColor: 'rgba(255,255,255,.55)',
        data: [
          @foreach ($registrosPorMesCur as $cur)
            {{ $cur->total_registros }},
          @endforeach
        ],
        barPercentage: 0.6
      }]
    },
    options: {
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false
        }
      },
      scales: {
        x: {
          grid: {
            display: false,
            drawTicks: false
          },
          ticks: {
            display: false
          }
        },
        y: {
          grid: {
            display: false,
            drawBorder: false,
            drawTicks: false
          },
          ticks: {
            display: false
          }
        }
      }
    }
  });

  var data1 = [];
  var data2 = [];
  var labelss = [];
  const dias = [
    @foreach ($totalComprasDíaProd as $compD)
      '{{ $compD->dia }}',
    @endforeach
  ];
  const meses = [
    @foreach ($totalComprasMesProd as $compM)
      '{{ $compM->mes }}',
    @endforeach
  ];
  const años = [
    @foreach ($totalComprasAñoProd as $compA)
      '{{ $compA->año }}',
    @endforeach
  ];
  const labels_dia = [
    @foreach ($totalComprasDíaProd as $compD)
      '{{ $compD->dia }}',
    @endforeach
  ];
  const labels_mes = [
    @foreach ($totalComprasMesProd as $compM)
      '{{ strftime("%B", mktime(0, 0, 0, substr($compM->mes, 5), 1)) }}',
    @endforeach
  ];
  const labels_año = [
    @foreach ($totalComprasAñoProd as $compA)
      '{{ $compA->año }}',
    @endforeach
  ];
  const data1D = [
    @foreach ($totalComprasDíaCur as $curD)
      {{ $curD->total }},
    @endforeach
  ];
  const data2D = [
    @foreach ($totalComprasDíaProd as $procD)
      {{ $procD->total }},
    @endforeach
  ];
  const data1M = [
    @foreach ($totalComprasMesCur as $curM)
      {{ $curM->total }},
    @endforeach
  ];
  const data2M = [
    @foreach ($totalComprasMesProd as $procM)
      {{ $procM->total }},
    @endforeach
  ];
  const data1A = [
    @foreach ($totalComprasAñoCur as $curA)
      {{ $curA->total }},
    @endforeach
  ];
  const data2A = [
    @foreach ($totalComprasAñoProd as $procA)
      {{ $procA->total }},
    @endforeach
  ];

  data1 = data1M;
  data2 = data2M;
  labelss = labels_mes;

  const mainChart = new Chart(document.getElementById('main-chart'), {
    type: 'line',
    data: {
      labels: labelss,
      datasets: [{
        label: 'Cursos',
        backgroundColor: coreui.Utils.hexToRgba(coreui.Utils.getStyle('--cui-success'), 15),
        borderColor: coreui.Utils.getStyle('--cui-success'),
        pointHoverBackgroundColor: '#fff',
        borderWidth: 2,
        data: data1,
        fill: true
      }, {
        label: 'Productos',
        backgroundColor: coreui.Utils.hexToRgba(coreui.Utils.getStyle('--cui-warning'), 15),
        borderColor: coreui.Utils.getStyle('--cui-warning'),
        pointHoverBackgroundColor: '#fff',
        borderWidth: 2,
        data: data2,
        fill: true
      }]
    },
    options: {
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false
        }
      },
      scales: {
        x: {
          grid: {
            drawOnChartArea: false
          }
        },
        y: {
          ticks: {
            beginAtZero: true,
            maxTicksLimit: 5,
            stepSize: Math.ceil(250 / 10),
            max: 250
          }
        }
      },
      elements: {
        line: {
          tension: 0.4
        },
        point: {
          radius: 0,
          hitRadius: 10,
          hoverRadius: 4,
          hoverBorderWidth: 3
        }
      }
    }
  });

  function cambiarFormatoFecha(fechaString) {
    var fecha = new Date(fechaString);
    var dia = fecha.getDate() + 1;
    var mes = fecha.getMonth() + 1;
    var anio = fecha.getFullYear();
    var mesest = [
      "enero", "febrero", "marzo", "abril", "mayo", "junio",
      "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"
    ];
    var nuevoFormato = dia + " de " + mesest[mes - 1] + " del " + anio;
    return nuevoFormato;
  }

  function verificarCheckbox1() {
    var checkbox = document.getElementById("option1");
    var range = document.getElementById("range-dates");
    if (checkbox.checked) {
      mainChart.data.labels = labels_dia;
      mainChart.data.datasets[0].data = data1D;
      mainChart.data.datasets[1].data = data2D;
      mainChart.update();
      var primerDia = dias[0];
      var ultimoDia = dias[dias.length - 1];
      primerDia = cambiarFormatoFecha(primerDia);
      ultimoDia = cambiarFormatoFecha(ultimoDia);
      range.textContent = primerDia + ' - ' + ultimoDia;
    } else {
        console.log('no hay grafico')
    }
  }

  function verificarCheckbox2() {
    var checkbox = document.getElementById("option2");
    var range = document.getElementById("range-dates");
    if (checkbox.checked) {
      mainChart.data.labels = labels_mes;
      mainChart.data.datasets[0].data = data1M;
      mainChart.data.datasets[1].data = data2M;
      mainChart.update();
      var primerMesU = meses[0];
      var ultimoMesU = meses[meses.length - 1];
      var pAño = primerMesU.substring(0,4);
      var pMes = primerMesU.substring(5);
      var uAño = ultimoMesU.substring(0,4);
      var uMes = ultimoMesU.substring(5);
      var mesest = [
        "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
        "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
      ];
      range.textContent = mesest[pMes-1] + ' ' + pAño + ' - ' + mesest[uMes-1] + ' ' + uAño;
    } else {
        console.log('no hay grafico')
    }
  }

  function verificarCheckbox3() {
    var checkbox = document.getElementById("option3");
    var range = document.getElementById("range-dates");
    if (checkbox.checked) {
      mainChart.data.labels = labels_año;
      mainChart.data.datasets[0].data = data1A;
      mainChart.data.datasets[1].data = data2A;
      mainChart.update();
      var primerAño = años[0];
      var ultimoAño = años[años.length - 1];
      range.textContent = primerAño + ' - ' + ultimoAño;
    } else {
        console.log('no hay grafico')
    }
  }
</script>
<script>
  const pieChart = new Chart(document.getElementById('canvas-5'), {
    type: 'pie',
    data: {
      labels: [
        @foreach ($ProductosTop as $topP)
        '{{ $topP->producto }}',
        @endforeach
      ],
      datasets: [{
        data: [
          @foreach ($ProductosTop as $topP)
          '{{ $topP->total }}',
          @endforeach
        ],
        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#FAA7A7', '#AE7CDD', '#F9BB54', '#7CDBDD', '#CCEE4C', '#B89D47']
      }]
    },
    options: {
      responsive: true
    }
  });
  const polarAreaChart = new Chart(document.getElementById('canvas-6'), {
    type: 'pie',
    data: {
      labels: [
        @foreach ($CursosTop as $topC)
        '{{ $topC->curso }}',
        @endforeach
      ],
      datasets: [{
        data: [
          @foreach ($CursosTop as $topC)
          '{{ $topC->total }}',
          @endforeach
        ],
        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#FAA7A7', '#AE7CDD', '#F9BB54', '#7CDBDD', '#CCEE4C', '#B89D47']
      }]
    },
    options: {
      responsive: true
    }
  });
</script>
@stop