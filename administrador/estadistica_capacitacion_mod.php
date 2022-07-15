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

$total_presencial = count_by_presencial('capacitaciones');
$total_en_linea = count_by_en_linea('capacitaciones');
$total_hibrido = count_by_hibrido('capacitaciones');

?>

<?php include_once('layouts/header.php'); ?>
<a href="tabla_estadistica_capacitacion.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
  Regresar
</a><br><br>
<center>
  <button id="btnCrearPdf" style="margin-top: -60px;" class="btn btn-pdf btn-md">Guardar en PDF</button>
  <div id="prueba">
    <center>
      <h2 style="margin-top: 10px;">Estadística de Capacitaciones (Por modalidad)</h2>
    </center>
    <div class="row" style="display: flex; justify-content: center; align-items: center; margin-left:-70px;">
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
    </div>
    <div class="row" style="display: flex; justify-content: center; align-items: center;">
      <div class="col-md-6" style="margin-top: 5%;">
        <table class="table table-bordered table-striped">
          <thead>
            <tr style="height: 10px;" class="info">
              <th class="text-center" style="width: 70%;">Modalidad</th>
              <th class="text-center" style="width: 30%;">Cantidad</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Presencial</td>
              <?php if ($total_presencial['total'] != 0) { ?>
                <td class="text-center"><?php echo $total_presencial['total']; ?></td>
              <?php } else { ?>
                <td class="text-center">0</td>
              <?php } ?>
            </tr>
            <tr>
              <td>En línea</td>
              <?php if ($total_en_linea['total'] != 0) { ?>
                <td class="text-center"><?php echo $total_en_linea['total']; ?></td>
              <?php } else { ?>
                <td class="text-center">0</td>
              <?php } ?>
            </tr>
            <tr>
              <td>Híbrido</td>
              <?php if ($total_hibrido['total'] != 0) { ?>
                <td class="text-center"><?php echo $total_hibrido['total']; ?></td>
              <?php } else { ?>
                <td class="text-center">0</td>
              <?php } ?>
            </tr>
            <tr>
              <td style="text-align:right;"><b>Total</b></td>
              <td>
                <?php echo $total_presencial['total'] + $total_en_linea['total'] + $total_hibrido['total'];
                ?>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</center>

<?php include_once('layouts/footer.php'); ?>