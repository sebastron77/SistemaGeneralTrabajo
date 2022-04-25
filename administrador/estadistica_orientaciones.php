<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Página de Inicio';
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
$total_orien_mujer = count_by_id_mujer('orientacion_canalizacion');
$total_orien_hombre = count_by_id_hombre('orientacion_canalizacion');
$total_orien_lgbt = count_by_id_lgbt('orientacion_canalizacion');
?>

<?php include_once('layouts/header.php'); ?>

<!-- Debemos de tener Canvas en la página -->
<center>
  <h2 style="margin-top: -10px;">Orientaciones</h2>
  <div class="row">
    <div class="col-md-6" style="width: 40%; height: 20%;">
      <canvas id="myChart"></canvas>
      <!-- Incluímos Chart.js -->
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

      <!-- Añadimos el script a la página -->

      <script>
        var yValues = [<?php echo $total_orien_hombre['total']; ?>, <?php echo $total_orien_mujer['total']; ?>, <?php echo $total_orien_lgbt['total']; ?>];

        const ctx = document.getElementById('myChart');
        const myChart = new Chart(ctx, {
          type: 'bar',
          data: {
            labels: ['Hombres', 'Mujeres', 'LGBT'],
            datasets: [{
              label: 'Orientaciones por Género',
              data: yValues,
              backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)'
              ],
              borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)'
              ],
              borderWidth: 1
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

    <div class="col-md-6" style="width: 250px; height: 100px;">
      <!-- Debemos de tener Canvas en la página -->
      <canvas id="miGrafo"></canvas>

      <!-- Incluímos Chart.js -->
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

      <!-- Añadimos el script a la página -->
      <script>
        var yValues = [<?php echo $total_orien_hombre['total']; ?>, <?php echo $total_orien_mujer['total']; ?>, <?php echo $total_orien_lgbt['total']; ?>];
        const ctx2 = document.getElementById('miGrafo');
        const miGrafo = new Chart(ctx2, {
          type: 'pie',
          data: {
            labels: ['Hombres', 'Mujeres', 'LGBT'],
            datasets: [{
              data: yValues,
              backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)'
              ],
              hoverOffset: 4
            }]
          },options: {
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
<div style="margin-top: 120px;">
  <hr  style="height:2px;border-width:0;background-color:#aaaaaa">
</div>
<?php include_once('layouts/footer.php'); ?>