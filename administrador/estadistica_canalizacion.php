<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Estadísticas de Canalizaciones';
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
$total_orien_mujer = count_by_id_mujerC('orientacion_canalizacion', 2);
$total_orien_hombre = count_by_id_hombreC('orientacion_canalizacion', 2);
$total_orien_lgbt = count_by_id_lgbtC('orientacion_canalizacion', 2);

$total_gv_lgbt = count_by_comLgC('orientacion_canalizacion', 2);
$total_der_mujer = count_by_derMujC('orientacion_canalizacion', 2);
$total_nna = count_by_nnaC('orientacion_canalizacion', 2);
$total_disc = count_by_discC('orientacion_canalizacion', 2);
$total_mig = count_by_migC('orientacion_canalizacion', 2);
$total_vih = count_by_vihC('orientacion_canalizacion', 2);
$total_gi = count_by_giC('orientacion_canalizacion', 2);
$total_perio = count_by_perioC('orientacion_canalizacion', 2);
$total_ddh = count_by_ddhC('orientacion_canalizacion', 2);
$total_am = count_by_amC('orientacion_canalizacion', 2);
$total_int = count_by_intC('orientacion_canalizacion', 2);
$total_otros = count_by_otrosC('orientacion_canalizacion', 2);
$total_na = count_by_naC('orientacion_canalizacion', 2);

$total_asesorv = count_by_asesorvC('orientacion_canalizacion', 2);
$total_asistentev = count_by_asistentevC('orientacion_canalizacion', 2);
$total_comp = count_by_compC('orientacion_canalizacion', 2);
$total_escrito = count_by_escritoC('orientacion_canalizacion', 2);
$total_vt = count_by_vtC('orientacion_canalizacion', 2);
$total_ve = count_by_veC('orientacion_canalizacion', 2);
$total_cndh = count_by_cndhC('orientacion_canalizacion', 2);
?>

<?php include_once('layouts/header.php'); ?>

<!-- Debemos de tener Canvas en la página -->
<center>
  <h2 style="margin-top: -10px;">Estadística de Canalizaciones (Por género)</h2>
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
            labels: ['Hombres', 'Mujeres', 'LGBTIQ+'],
            datasets: [{
              label: 'Orientaciones por Género',
              data: yValues,
              backgroundColor: [
                '#F05E32',
                '#1F914D',
                '#3446FA'
              ],
              borderColor: [
                '#91391F',
                '#166937',
                '#1F2891'
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
            labels: ['Hombres', 'Mujeres', 'LGBTIQ+'],
            datasets: [{
              data: yValues,
              backgroundColor: [
                '#F05E32',
                '#1F914D',
                '#3446FA'
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
  <h2 style="margin-top: -10px;">Estadística de Canalizaciones (Por grupo vulnerable)</h2>
  <div class="row">
    <div class="col-md-6" style="width: 50%; height: 20%;">
      <canvas id="gVulnerableB"></canvas>
      <!-- Incluímos Chart.js -->
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

      <!-- Añadimos el script a la página -->

      <script>
        var yValues = [<?php echo $total_gv_lgbt['total']; ?>, <?php echo $total_der_mujer['total']; ?>, <?php echo $total_nna['total']; ?>, <?php echo $total_disc['total']; ?>,
          <?php echo $total_mig['total']; ?>, <?php echo $total_vih['total']; ?>, <?php echo $total_gi['total']; ?>, <?php echo $total_perio['total']; ?>,
          <?php echo $total_ddh['total']; ?>, <?php echo $total_am['total']; ?>, <?php echo $total_int['total']; ?>, <?php echo $total_otros['total']; ?>, <?php echo $total_na['total']; ?>
        ];

        const ctx3 = document.getElementById('gVulnerableB');
        const gVulnerableB = new Chart(ctx3, {
          type: 'bar',
          data: {
            labels: ['Comunidad LGBTIQ+', 'Derecho de las mujeres', 'Niñas, niños y adolescentes', 'Personas con discapacidad', 'Personas migrantes', 'Personas que viven con VIH SIDA', 'Grupos indígenas', 'Periodistas',
              'Defensores de los derechos humanos', 'Adultos mayores', 'Internos', 'Otros', 'No Aplica'
            ],
            datasets: [{
              label: 'Orientaciones por Grupo Vulnerable',
              data: yValues,
              backgroundColor: [
                '#584DB3', '#FFDC57', '#3E75EA', '#99FEA3', '#427085', '#FA8865', '#E0293F', '#D0EB5A', '#FF5846', '#7972E7', '#00DDEA', '#E66DFB', '#6084EB'
              ],
              borderColor: [
                '#3C357A', '#A87E00', '#234387', '#63A66A', '#425BA1', '#A85B43', '#91449E', '#9AAD42', '#963429', '#5852A8', '#00A0A8', '#8A1926', '#253F4A'
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
        var yValues = [<?php echo $total_gv_lgbt['total']; ?>, <?php echo $total_der_mujer['total']; ?>, <?php echo $total_nna['total']; ?>, <?php echo $total_disc['total']; ?>,
          <?php echo $total_mig['total']; ?>, <?php echo $total_vih['total']; ?>, <?php echo $total_gi['total']; ?>, <?php echo $total_perio['total']; ?>,
          <?php echo $total_ddh['total']; ?>, <?php echo $total_am['total']; ?>, <?php echo $total_int['total']; ?>, <?php echo $total_otros['total']; ?>, <?php echo $total_na['total']; ?>
        ];
        const ctx4 = document.getElementById('gVulnerableC');
        const gVulnerableC = new Chart(ctx4, {
          type: 'pie',
          data: {
            labels: ['Comunidad LGBTIQ+', 'Derecho de las mujeres', 'Niñas, niños y adolescentes', 'Personas con discapacidad', 'Personas migrantes', 'Personas que viven con VIH SIDA', 'Grupos indígenas', 'Periodistas',
              'Defensores de los derechos humanos', 'Adultos mayores', 'Internos', 'Otros', 'No Aplica'
            ],
            datasets: [{
              data: yValues,
              backgroundColor: [
                '#99FEA3', '#3E75EA', '#FFDC57', '#584DB3', '#6084EB', '#FA8865', '#E66DFB', '#D0EB5A', '#FF5846', '#7972E7', '#00DDEA', '#E0293F', '#427085'
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



<center>
  <h2 style="margin-top: -10px;">Estadística de Canalizaciones (Por medio de presentación)</h2>
  <div class="row">
    <div class="col-md-6" style="width: 50%; height: 20%;">
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
                '#155A7D', '#BA323B', '#AE65BC', '#FEE05A', '#39EBCF', '#3C71FE', '#E66E27'
              ],
              borderColor: [
                '#0D354A', '#631B20', '#683D70', '#A39039', '#27A18E', '#234091', '#A14D23'
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
            responsive:true
          }
        });
      </script>

    </div>

    <div class="col-md-6" style="width: 420px; height: 250px;">
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
                '#155A7D', '#BA323B', '#AE65BC', '#FEE05A', '#39EBCF', '#3C71FE', '#E66E27'
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