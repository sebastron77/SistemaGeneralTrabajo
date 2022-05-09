<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Estadísticas de Orientaciones';
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
$total_orien_mujer = count_by_id_mujer('orientacion_canalizacion', 1);
$total_orien_hombre = count_by_id_hombre('orientacion_canalizacion', 1);
$total_orien_lgbt = count_by_id_lgbt('orientacion_canalizacion', 1);

$total_gv_lgbt = count_by_comLg('orientacion_canalizacion', 1);
$total_der_mujer = count_by_derMuj('orientacion_canalizacion', 1);
$total_nna = count_by_nna('orientacion_canalizacion', 1);
$total_disc = count_by_disc('orientacion_canalizacion', 1);
$total_mig = count_by_mig('orientacion_canalizacion', 1);
$total_vih = count_by_vih('orientacion_canalizacion', 1);
$total_gi = count_by_gi('orientacion_canalizacion', 1);
$total_perio = count_by_perio('orientacion_canalizacion', 1);
$total_ddh = count_by_ddh('orientacion_canalizacion', 1);
$total_am = count_by_am('orientacion_canalizacion', 1);
$total_int = count_by_int('orientacion_canalizacion', 1);
$total_otros = count_by_otros('orientacion_canalizacion', 1);
$total_na = count_by_na('orientacion_canalizacion', 1);

$total_asesorv = count_by_asesorv('orientacion_canalizacion', 1);
$total_asistentev = count_by_asistentev('orientacion_canalizacion', 1);
$total_comp = count_by_comp('orientacion_canalizacion', 1);
$total_escrito = count_by_escrito('orientacion_canalizacion', 1);
$total_vt = count_by_vt('orientacion_canalizacion', 1);
$total_ve = count_by_ve('orientacion_canalizacion', 1);
$total_cndh = count_by_cndh('orientacion_canalizacion', 1);
?>

<?php include_once('layouts/header.php'); ?>

<a href="tabla_estadistica_orientacion.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
  Regresar
</a><br><br>
<center>
  <h2 style="margin-top: -10px;">Estadística de Orientaciones (Por medio de presentación)</h2><br>
  <div class="row" style="display: flex; justify-content: center; align-items: center;">
    <div style="width:50%; float:left;">
      <!-- <div class="col-md-6" style="width: 50%; height: 20%;"> -->
      <canvas id="mPresentacion"></canvas>
      <!-- Incluímos Chart.js -->
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

      <!-- Añadimos el script a la página -->

      <script>
        var yValues = [<?php echo $total_asesorv['total']; ?>, <?php echo $total_asistentev['total']; ?>, <?php echo $total_comp['total']; ?>, <?php echo $total_escrito['total']; ?>,
          <?php echo $total_vt['total']; ?>, <?php echo $total_ve['total']; ?>, <?php echo $total_cndh['total']; ?>
        ];
        const ctx5 = document.getElementById('mPresentacion');
        const mPresentacion = new Chart(ctx5, {
          type: 'bar',
          data: {
            labels: ['Asesor Virtual', 'Asistente Virtual', 'Comparecencia', 'Escrito', 'Vía telefónica', 'Vía electrónica', 'Comisión Nacional de los Derechos Humanos'],
            datasets: [{
              label: 'Orientaciones por Medio de Presentación',
              data: yValues,
              backgroundColor: [
                '#7A8A28', '#9FC983', '#7DB37F', '#B4CCBD', '#354A45', '#195947', '#688C82'
              ],
              borderColor: [
                '#4C5719', '#73915E', '#577D59', '#728278', '#253330', '#0F362B', '#394D47'
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
            responsive: true
          }
        });
      </script>
    </div>
    <!-- </div> -->

    <!-- <div class="col-md-6" style="width: 420px; height: 250px;"> -->
    <div style="width:40%; float:right; margin-left: 50px">
      <!-- Debemos de tener Canvas en la página -->
      <canvas id="mPresentacionC"></canvas>

      <!-- Incluímos Chart.js -->
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

      <!-- Añadimos el script a la página -->
      <script>
        var yValues = [<?php echo $total_asesorv['total']; ?>, <?php echo $total_asistentev['total']; ?>, <?php echo $total_comp['total']; ?>, <?php echo $total_escrito['total']; ?>,
          <?php echo $total_vt['total']; ?>, <?php echo $total_ve['total']; ?>, <?php echo $total_cndh['total']; ?>
        ];
        const ctx6 = document.getElementById('mPresentacionC');
        const mPresentacionC = new Chart(ctx6, {
          type: 'pie',
          data: {
            labels: ['Asesor Virtual', 'Asistente Virtual', 'Comparecencia', 'Escrito', 'Vía telefónica', 'Vía electrónica', 'Comisión Nacional de los Derechos Humanos'],
            datasets: [{
              data: yValues,
              backgroundColor: [
                '#7A8A28', '#9FC983', '#7DB37F', '#B4CCBD', '#354A45', '#195947', '#688C82'
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
      <!-- </div> -->
    </div>
  </div>
</center>
<?php include_once('layouts/footer.php'); ?>