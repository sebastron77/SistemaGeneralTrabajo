<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Estadísticas de Capacitaciones';
require_once('includes/load.php');

$user = current_user();
$nivel_user = $user['user_level'];
// page_require_area(7);
if ($nivel_user <= 2) {
  page_require_level(2);
}
if ($nivel_user == 7) {
  page_require_level_exacto(7);
}
if ($nivel_user > 2 && $nivel_user < 7) :
  redirect('home.php');
endif;
if ($nivel_user > 7) :
  redirect('home.php');
endif;

$total_presencial = count_by_presencial('capacitaciones');
$total_en_linea = count_by_en_linea('capacitaciones');
$total_hibrido = count_by_hibrido('capacitaciones');

?>

<?php include_once('layouts/header.php'); ?>

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