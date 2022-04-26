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

$total_gv_lgbt = count_by_comLg('orientacion_canalizacion');
$total_der_mujer = count_by_derMuj('orientacion_canalizacion');
$total_nna = count_by_nna('orientacion_canalizacion');
$total_disc = count_by_disc('orientacion_canalizacion');
$total_mig = count_by_mig('orientacion_canalizacion');
$total_vih = count_by_vih('orientacion_canalizacion');
$total_gi = count_by_gi('orientacion_canalizacion');
$total_perio = count_by_perio('orientacion_canalizacion');
$total_ddh = count_by_ddh('orientacion_canalizacion');
$total_am = count_by_am('orientacion_canalizacion');
$total_int = count_by_int('orientacion_canalizacion');
$total_otros = count_by_otros('orientacion_canalizacion');
$total_na = count_by_na('orientacion_canalizacion');
?>

<?php include_once('layouts/header.php'); ?>

<!-- Debemos de tener Canvas en la página -->
<center>
  <h2 style="margin-top: -10px;">Estadística de Orientaciones (Por género)</h2>
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
                '#E0716F',
                '#538EF5',
                '#F5EE77'
              ],
              borderColor: [
                '#E03C3B',
                '#2D5EBC',
                '#F5EE3F'
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
                '#E0716F',
                '#538EF5',
                '#F5EE77'
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
  <h2 style="margin-top: -10px;">Estadística de Orientaciones (Por grupo vulnerable)</h2>
  <div class="row">
    <div class="col-md-6" style="width: 50%; height: 20%;">
      <canvas id="gVulnerableB"></canvas>
      <!-- Incluímos Chart.js -->
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

      <!-- Añadimos el script a la página -->

      <script>
        var yValues = [<?php echo $total_gv_lgbt['total'];?>,<?php echo $total_der_mujer['total'];?>,<?php echo $total_nna['total'];?>,<?php echo $total_disc['total'];?>,
                        <?php echo $total_mig['total'];?>,<?php echo $total_vih['total'];?>,<?php echo $total_gi['total'];?>,<?php echo $total_perio['total'];?>,
                        <?php echo $total_ddh['total'];?>,<?php echo $total_am['total'];?>,<?php echo $total_int['total'];?>,<?php echo $total_otros['total'];?>,<?php echo $total_na['total'];?>];

        const ctx3 = document.getElementById('gVulnerableB');
        const gVulnerableB = new Chart(ctx3, {
          type: 'bar',
          data: {
            labels: ['Comunidad LGBTTTIQA', 'Derecho de las mujeres', 'Niñas, niños y adolescentes', 'Personas con discapacidad', 'Personas migrantes', 'Personas que viven con VIH SIDA', 'Grupos indígenas', 'Periodistas', 
                      'Defensores de los derechos humanos', 'Adultos mayores', 'Internos', 'Otros', 'No Aplica'],
            datasets: [{
              label: 'Orientaciones por Grupo Vulnerable',
              data: yValues,
              backgroundColor: [
                '#75FE58','#0147EB','#FFC000','#7D58FB','#4FE396','#FA8865','#FA57D5','#E3C644','#FE4C2D','#7972E7','#00DDEA','#FF1C01','#4473E3'
              ],
              borderColor: [
                '#4BA339','#001D61','#A87E00','#4D3699','#339161','#A85B43','#A3398A','#A89332','#B83821','#5852A8','#00A0A8','#A61100','#2D4D96'
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

    <div class="col-md-6" style="width: 420px; height: 250px;">
      <!-- Debemos de tener Canvas en la página -->
      <canvas id="gVulnerableC"></canvas>

      <!-- Incluímos Chart.js -->
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

      <!-- Añadimos el script a la página -->
      <script>
        var yValues = [<?php echo $total_gv_lgbt['total'];?>,<?php echo $total_der_mujer['total'];?>,<?php echo $total_nna['total'];?>,<?php echo $total_disc['total'];?>,
                        <?php echo $total_mig['total'];?>,<?php echo $total_vih['total'];?>,<?php echo $total_gi['total'];?>,<?php echo $total_perio['total'];?>,
                        <?php echo $total_ddh['total'];?>,<?php echo $total_am['total'];?>,<?php echo $total_int['total'];?>,<?php echo $total_otros['total'];?>,<?php echo $total_na['total'];?>];
        const ctx4 = document.getElementById('gVulnerableC');
        const gVulnerableC = new Chart(ctx4, {
          type: 'pie',
          data: {
            labels: ['Comunidad LGBTTTIQA', 'Derecho de las mujeres', 'Niñas, niños y adolescentes', 'Personas con discapacidad', 'Personas migrantes', 'Personas que viven con VIH SIDA', 'Grupos indígenas', 'Periodistas', 
                      'Defensores de los derechos humanos', 'Adultos mayores', 'Internos', 'Otros', 'No Aplica'],
            datasets: [{
              data: yValues,
              backgroundColor: [
                '#75FE58','#0147EB','#FFC000','#7D58FB','#4FE396','#FA8865','#FA57D5','#E3C644','#FE4C2D','#7972E7','#00DDEA','#FF1C01','#4473E3'
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