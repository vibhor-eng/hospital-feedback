@extends('layouts.master') 

@section('seo_title', 'Login')



@section('body_content')

<!-- partial -->
        <div class="main-panel">
        	
	          <div class="content-wrapper">
	          	<div class = "row">

		              <div class="col-md-4 stretch-card grid-margin">
		                <div class="card bg-gradient-info card-img-holder text-white">
		                  <div class="card-body">
		                    <!-- <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" /> -->
		                    <h4 class="font-weight-normal mb-3">Total Queries<i class="mdi mdi-chart-line mdi-24px float-end"></i>
		                    </h4>
		                    <h2 class="mb-5">{{ $total_patient_queries }}</h2>
		                    <!-- <h6 class="card-text">Increased by 60%</h6> -->
		                  </div>
		                </div>
		              </div>

		              <div class="col-md-4 stretch-card grid-margin">
		                <div class="card bg-gradient-danger card-img-holder text-white">
		                  <div class="card-body">
		                    <!-- <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" /> -->
		                    <h4 class="font-weight-normal mb-3">Total Resolved Queries<i class="mdi mdi-chart-line mdi-24px float-end"></i>
		                    </h4>
		                    <h2 class="mb-5">{{ $total_resolved_queries }}</h2>
		                    <!-- <h6 class="card-text">Increased by 60%</h6> -->
		                  </div>
		                </div>
		              </div>

		              <div class="col-md-4 stretch-card grid-margin">
		                <div class="card bg-gradient-info card-img-holder text-white">
		                  <div class="card-body">
		                    <!-- <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" /> -->
		                    <h4 class="font-weight-normal mb-3">Total Active Queries<i class="mdi mdi-chart-line mdi-24px float-end"></i>
		                    </h4>
		                    <h2 class="mb-5">{{ $total_active_queries }}</h2>
		                    <!-- <h6 class="card-text">Increased by 60%</h6> -->
		                  </div>
		                </div>
		              </div>

		        </div>

		 @if(count($resolved) > 0 || count($unresolved) > 0)
		        <div class="row">
		              <div class="col-md-6 grid-margin stretch-card">
		                <div class="card">
		                  <div class="card-body">
		                    <div class="clearfix">
		                      <h4 class="card-title float-start">2024 Resolved/Unresolved Data</h4>
		                      <div id="visit-sale-chart-legend" class="rounded-legend legend-horizontal legend-top-right float-end"></div>
		                    </div>
		                    <canvas id="visit-sale-chart" class="mt-4"></canvas>
		                  </div>
		                </div>
		              </div>
		              <!-- <div class="col-md-5 grid-margin stretch-card">
		                <div class="card">
		                  <div class="card-body">
		                    <h4 class="card-title">Traffic Sources</h4>
		                    <div class="doughnutjs-wrapper d-flex justify-content-center">
		                      <canvas id="traffic-chart"></canvas>
		                    </div>
		                    <div id="traffic-chart-legend" class="rounded-legend legend-vertical legend-bottom-left pt-4"></div>
		                  </div>
		                </div>
		              </div> -->
            		</div>
	            
	          </div>
	        @endif
	          
	          @include('layouts.blocks.footer')
          
        </div>
        

@endsection

@section('footer_custom_js')
<script type="text/javascript">
	(function ($) {
  'use strict';
  if ($("#visit-sale-chart").length) {
    const ctx = document.getElementById('visit-sale-chart');

    var graphGradient1 = document.getElementById('visit-sale-chart').getContext("2d");
    var graphGradient2 = document.getElementById('visit-sale-chart').getContext("2d");
    var graphGradient3 = document.getElementById('visit-sale-chart').getContext("2d");

    var gradientStrokeViolet = graphGradient1.createLinearGradient(0, 0, 0, 181);
    gradientStrokeViolet.addColorStop(0, '#3fc1a5');
    gradientStrokeViolet.addColorStop(1, '#075a68');
    var gradientLegendViolet = 'linear-gradient(to right, #3fc1a5, 1), #075a68)';

    var gradientStrokeBlue = graphGradient2.createLinearGradient(0, 0, 0, 360);
    gradientStrokeBlue.addColorStop(0, 'rgba(54, 215, 232, 1)');
    gradientStrokeBlue.addColorStop(1, 'rgba(177, 148, 250, 1)');
    var gradientLegendBlue = 'linear-gradient(to right, rgba(54, 215, 232, 1), rgba(177, 148, 250, 1))';

    var gradientStrokeRed = graphGradient3.createLinearGradient(0, 0, 0, 300);
    gradientStrokeRed.addColorStop(0, '#3FC19E');
    gradientStrokeRed.addColorStop(1, '#3FC19E');
    var gradientLegendRed = 'linear-gradient(to right, rgba(255, 191, 150, 1), rgba(254, 112, 150, 1))';
    const bgColor1 = "#075a68";
    const bgColor2 = ["rgba(54, 215, 232, 1"];
    const bgColor3 = "#3FC19E";

    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: <?php echo json_encode($months); ?>,
        datasets: [{
          label: "Resolved",
          borderColor: gradientStrokeViolet,
          backgroundColor: gradientStrokeViolet,
          fillColor: bgColor1,
          hoverBackgroundColor: gradientStrokeViolet,
          pointRadius: 0,
          fill: false,
          borderWidth: 1,
          fill: 'origin',
          data: <?php echo json_encode($resolved) ?>,
          barPercentage: 0.5,
          categoryPercentage: 0.5,
        },
        {
          label: "Unresolved",
          borderColor: gradientStrokeRed,
          backgroundColor: gradientStrokeRed,
          hoverBackgroundColor: gradientStrokeRed,
          fillColor: bgColor3,
          pointRadius: 0,
          fill: false,
          borderWidth: 1,
          fill: 'origin',
          data: <?php echo json_encode($unresolved) ?>,
          barPercentage: 0.5,
          categoryPercentage: 0.5,
        },
        // {
        //   label: "UK",
        //   borderColor: gradientStrokeBlue,
        //   backgroundColor: gradientStrokeBlue,
        //   hoverBackgroundColor: gradientStrokeBlue,
        //   fillColor: bgColor3,
        //   pointRadius: 0,
        //   fill: false,
        //   borderWidth: 1,
        //   fill: 'origin',
        //   data: [70, 10, 30, 40, 25, 50, 15, 30],
        //   barPercentage: 0.5,
        //   categoryPercentage: 0.5,
        // }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
        elements: {
          line: {
            tension: 0.4,
          },
        },
        scales: {
          y: {
            display: false,
            grid: {
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
            },
          },
          x: {
            display: true,
            grid: {
              display: false,
            },
          }
        },
        plugins: {
          legend: {
            display: false,
          }
        }
      },
      plugins: [{
        afterDatasetUpdate: function (chart, args, options) {
          const chartId = chart.canvas.id;
          var i;
          const legendId = `${chartId}-legend`;
          const ul = document.createElement('ul');
          for (i = 0; i < chart.data.datasets.length; i++) {
            ul.innerHTML += `
              <li>
                <span style="background-color: ${chart.data.datasets[i].fillColor}"></span>
                ${chart.data.datasets[i].label}
              </li>
            `;
          }
          // alert(chart.data.datasets[0].backgroundColor);
          return document.getElementById(legendId).appendChild(ul);
        }
      }]
    });
  }

  if ($("#traffic-chart").length) {
    const ctx = document.getElementById('traffic-chart');

    var graphGradient1 = document.getElementById("traffic-chart").getContext('2d');
    var graphGradient2 = document.getElementById("traffic-chart").getContext('2d');
    var graphGradient3 = document.getElementById("traffic-chart").getContext('2d');

    var gradientStrokeBlue = graphGradient1.createLinearGradient(0, 0, 0, 181);
    gradientStrokeBlue.addColorStop(0, '#3fc1a5');
    gradientStrokeBlue.addColorStop(1, '#075a68');
    var gradientLegendBlue = '#075a68, 1)';

    var gradientStrokeRed = graphGradient2.createLinearGradient(0, 0, 0, 50);
    gradientStrokeRed.addColorStop(0, '#3fc1a5');
    gradientStrokeRed.addColorStop(1, '#075a68');
    var gradientLegendRed = '#3fc1a5';

    var gradientStrokeGreen = graphGradient3.createLinearGradient(0, 0, 0, 300);
    gradientStrokeGreen.addColorStop(0, '#3fc1a5');
    gradientStrokeGreen.addColorStop(1, '#075a68');
    var gradientLegendGreen = '#075a68';

    // const bgColor1 = ["rgba(54, 215, 232, 1)"];
    // const bgColor2 = ["rgba(255, 191, 150, 1"];
    // const bgColor3 = ["rgba(6, 185, 157, 1)"];

    new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ['Search Engines 30%', 'Direct Click 30%', 'Bookmarks Click 40%'],
        datasets: [{
          data: [30, 30, 40],
          backgroundColor: [gradientStrokeBlue, gradientStrokeGreen, gradientStrokeRed],
          hoverBackgroundColor: [
            gradientStrokeBlue,
            gradientStrokeGreen,
            gradientStrokeRed
          ],
          borderColor: [
            gradientStrokeBlue,
            gradientStrokeGreen,
            gradientStrokeRed
          ],
          legendColor: [
            gradientLegendBlue,
            gradientLegendGreen,
            gradientLegendRed
          ]
        }]
      },
      options: {
        cutout: 50,
        animationEasing: "easeOutBounce",
        animateRotate: true,
        animateScale: false,
        responsive: true,
        maintainAspectRatio: true,
        showScale: true,
        legend: false,
        plugins: {
          legend: {
            display: false,
          }
        }
      },
      plugins: [{
        afterDatasetUpdate: function (chart, args, options) {
          const chartId = chart.canvas.id;
          var i;
          const legendId = `${chartId}-legend`;
          const ul = document.createElement('ul');
          for (i = 0; i < chart.data.datasets[0].data.length; i++) {
            ul.innerHTML += `
                <li>
                  <span style="background-color: ${chart.data.datasets[0].legendColor[i]}"></span>
                  ${chart.data.labels[i]}
                </li>
              `;
          }
          return document.getElementById(legendId).appendChild(ul);
        }
      }]
    });
  }

})(jQuery);
</script>
@endsection