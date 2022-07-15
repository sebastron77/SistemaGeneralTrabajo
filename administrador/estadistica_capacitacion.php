<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Estadísticas de Capacitaciones';
require_once('includes/load.php');

$user = current_user();
$nivel_user = $user['user_level'];
// page_require_area(7);
if ($nivel_user <= 3) {
  page_require_level(3);
}
if ($nivel_user == 5) {
  page_require_level_exacto(5);
}
if ($nivel_user == 7) {
  page_require_level_exacto(7);
}

// if ($nivel_user > 3 && $nivel_user < 7) :
//   redirect('home.php');
// endif;
if ($nivel_user > 7) :
  redirect('home.php');
endif;
$total_capacitacion = count_by_capacitacion('capacitaciones');
$total_conferencia = count_by_conferencia('capacitaciones');
$total_curso = count_by_curso('capacitaciones');
$total_taller = count_by_taller('capacitaciones');
$total_platica = count_by_platica('capacitaciones');
$total_diplomado = count_by_diplomado('capacitaciones');
$total_foro = count_by_foro('capacitaciones');

$total_presencial = count_by_presencial('capacitaciones');
$total_en_linea = count_by_en_linea('capacitaciones');
$total_hibrido = count_by_hibrido('capacitaciones');

?>

<?php include_once('layouts/header.php'); ?>

<!-- Debemos de tener Canvas en la página -->
<center>
  <h2 style="margin-top: -10px;">Estadística de Capacitaciones (Por tipo de evento)</h2>
  <div class="row" style="display: flex; justify-content: center; align-items: center;">
    <div class="col-md-6" style="width: 40%; height: 20%;">
      <canvas id="myChart"></canvas>
      <!-- Incluímos Chart.js -->
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

      <!-- Añadimos el script a la página -->

      <script>
        var yValues = [<?php echo $total_capacitacion['total']; ?>, <?php echo $total_conferencia['total']; ?>, <?php echo $total_curso['total']; ?>, 
                        <?php echo $total_taller['total']; ?>, <?php echo $total_platica['total']; ?>, <?php echo $total_diplomado['total']; ?>, <?php echo $total_foro['total']; ?>];

        const ctx = document.getElementById('myChart');
        const myChart = new Chart(ctx, {
          type: 'bar',
          data: {
            labels: ['Capacitación', 'Conferencia', 'Curso', 'Taller', 'Platica', 'Diplomado', 'Foro'],
            datasets: [{
              label: 'Capacitaciones por tipo de evento',
              data: yValues,
              backgroundColor: [
                '#60A685',
                '#91D9B7',
                '#ACF2D1',
                '#01401C',
                '#2F734C',
                '#015948',
                '#02A686'
              ],
              borderColor: [
                '#467860',
                '#71A88E',
                '#709E89',
                '#012912',
                '#204F35',
                '#014033',
                '#018066'
              ],
              borderWidth: 2
            }]
          },
          options: {
            legend: {
              display: false
            },
            // El salto entre cada valor de Y
            ticks: {
              min: 0,
              max: 6000,
              stepSize: 1
            },

          }
        });
      </script>

    </div>

    <div class="col-md-6" style="width: 350px; height: 200px;">
      <!-- Debemos de tener Canvas en la página -->
      <canvas id="miGrafo"></canvas>

      <!-- Incluímos Chart.js -->
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

      <!-- Añadimos el script a la página -->
      <script>
        var yValues = [<?php echo $total_capacitacion['total']; ?>, <?php echo $total_conferencia['total']; ?>, <?php echo $total_curso['total']; ?>, 
                        <?php echo $total_taller['total']; ?>, <?php echo $total_platica['total']; ?>, <?php echo $total_diplomado['total']; ?>, <?php echo $total_foro['total']; ?>];
        const ctx2 = document.getElementById('miGrafo');
        const miGrafo = new Chart(ctx2, {
          type: 'pie',
          data: {
            labels: ['Capacitación', 'Conferencia', 'Curso', 'Taller', 'Platica', 'Diplomado', 'Foro'],
            datasets: [{
              data: yValues,
              backgroundColor: [
                '#60A685',
                '#91D9B7',
                '#ACF2D1',
                '#01401C',
                '#2F734C',
                '#015948',
                '#02A686'
              ],
              hoverOffset: 4
            }]
          },
          options: {
            legend: {
              display: false
            },
            // El salto entre cada valor de Y
            ticks: {
              min: 0,
              max: 6000,
              stepSize: 1
            },
          }
        });
      </script>

      <!-- Renderizamos la gráfica -->
      <script>
        const miGrafo = new Chart(
          document.getElementById('miGrafo'),
          config
        );
      </script>
    </div>
  </div>
</center>
<!-- <div style="margin-top: 120px;"> -->
<hr style="margin-top: 120px; height:2px;border-width:0;background-color:#aaaaaa">
<!-- </div> -->



<center>
  <h2 style="margin-top: -10px;">Estadística de Capacitaciones (Por modalidad)</h2>
  <div class="row" style="display: flex; justify-content: center; align-items: center;">
    <div class="col-md-6" style="width: 50%; height: 20%;">
      <canvas id="gVulnerableB"></canvas>
      <!-- Incluímos Chart.js -->
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

      <!-- Añadimos el script a la página -->

      <script>
        var yValues = [<?php echo $total_presencial['total']; ?>, <?php echo $total_en_linea['total']; ?>, <?php echo $total_hibrido['total']; ?>];

        const ctx3 = document.getElementById('gVulnerableB');
        const gVulnerableB = new Chart(ctx3, {
          type: 'bar',
          data: {
            labels: ['Presencial', 'En línea', 'Híbrido'],
            datasets: [{
              label: 'Capacitaciones por modalidad',
              data: yValues,
              backgroundColor: [
                '#143C8C', '#398CBF', '#1F598C'
              ],
              borderColor: [
                '#0D285E', '#2C6A91', '#174269'
              ],
              borderWidth: 2
            }]
          },
          options: {
            legend: {
              display: false
            },
            // El salto entre cada valor de Y
            ticks: {
              min: 0,
              max: 10000,
              stepSize: 10
            },

          }
        });
      </script>

    </div>

    <div class="col-md-6" style="width: 420px; height: 250px;">
      <!-- Debemos de tener Canvas en la página -->
      <canvas id="gVulnerableC"></canvas>

      <!-- Incluímos Chart.js -->
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

      <!-- Añadimos el script a la página -->
      <script>
        var yValues = [<?php echo $total_presencial['total']; ?>, <?php echo $total_en_linea['total']; ?>, <?php echo $total_hibrido['total']; ?>];

        const ctx4 = document.getElementById('gVulnerableC');
        const gVulnerableC = new Chart(ctx4, {
          type: 'pie',
          data: {
            labels: ['Presencial', 'En línea', 'Híbrido'],

            datasets: [{
              data: yValues,
              backgroundColor: [
                '#143C8C', '#398CBF', '#1F598C'
              ],
              hoverOffset: 4
            }]
          },
          options: {
            legend: {
              display: false
            },
            // El salto entre cada valor de Y
            ticks: {
              min: 0,
              max: 6000,
              stepSize: 1
            },
          }
        });
      </script>

      <!-- Renderizamos la gráfica -->
      <script>
        const miGrafo = new Chart(
          document.getElementById('miGrafo'),
          config
        );
      </script>
    </div>
  </div>
</center>

<hr style="margin-top: 140px; height:2px;border-width:0;background-color:#aaaaaa">

<?php include_once('layouts/footer.php'); ?>