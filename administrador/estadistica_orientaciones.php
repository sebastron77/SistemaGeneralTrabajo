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
            labels: ['Hombres', 'Mujeres', 'LGBTTTIQA'],
            datasets: [{
              label: 'Orientaciones por Género',
              data: yValues,
              backgroundColor: [
                '#2AB5BD',
                '#5643FA',
                '#2ABD71'
              ],
              borderColor: [
                '#1A7378',
                '#322791',
                '#197043'
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
            labels: ['Hombres', 'Mujeres', 'LGBTTTIQA'],
            datasets: [{
              data: yValues,
              backgroundColor: [
                '#2AB5BD',
                '#5643FA',
                '#2ABD71'
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
        var yValues = [<?php echo $total_gv_lgbt['total']; ?>, <?php echo $total_der_mujer['total']; ?>, <?php echo $total_nna['total']; ?>, <?php echo $total_disc['total']; ?>,
          <?php echo $total_mig['total']; ?>, <?php echo $total_vih['total']; ?>, <?php echo $total_gi['total']; ?>, <?php echo $total_perio['total']; ?>,
          <?php echo $total_ddh['total']; ?>, <?php echo $total_am['total']; ?>, <?php echo $total_int['total']; ?>, <?php echo $total_otros['total']; ?>, <?php echo $total_na['total']; ?>
        ];

        const ctx3 = document.getElementById('gVulnerableB');
        const gVulnerableB = new Chart(ctx3, {
          type: 'bar',
          data: {
            labels: ['Comunidad LGBTTTIQA', 'Derecho de las mujeres', 'Niñas, niños y adolescentes', 'Personas con discapacidad', 'Personas migrantes', 'Personas que viven con VIH SIDA', 'Grupos indígenas', 'Periodistas',
              'Defensores de los derechos humanos', 'Adultos mayores', 'Internos', 'Otros', 'No Aplica'
            ],
            datasets: [{
              label: 'Orientaciones por Grupo Vulnerable',
              data: yValues,
              backgroundColor: [
                '#99FEA3', '#3E75EA', '#FFDC57', '#584DB3', '#6084EB', '#FA8865', '#E66DFB', '#D0EB5A', '#FF5846', '#7972E7', '#00DDEA', '#E0293F', '#427085'
              ],
              borderColor: [
                '#63A66A', '#234387', '#A87E00', '#3C357A', '#425BA1', '#A85B43', '#91449E', '#9AAD42', '#963429', '#5852A8', '#00A0A8', '#8A1926', '#253F4A'
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
            labels: ['Comunidad LGBTTTIQA', 'Derecho de las mujeres', 'Niñas, niños y adolescentes', 'Personas con discapacidad', 'Personas migrantes', 'Personas que viven con VIH SIDA', 'Grupos indígenas', 'Periodistas',
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
  <h2 style="margin-top: -10px;">Estadística de Orientaciones (Por medio de presentación)</h2>
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