<?php 
//Include connection file 
include '../conn/conn.php';
if(session_id() == '') {
 session_start();}
 if (!$_SESSION['user']) {
   header("Location: /");
}
mysqli_close($conn);
?>

<div class="col-md-12">
    <form>
    <div class="card">
        <div class="col-md-10 pdtop-0 text-left">
              <h2>Nueva medida</h2>
            </div>
            <div class="col-md-12 pdtop-1">
              <table style="height: 100%; width:100%;" class="table table-sm">
                <tbody>
                  <tr >
                  <tr>
                    <td style="width: 5px;"><em><strong>&nbsp;Nombre de medida</strong></em></td>
                    <td style="width: 172px;">&nbsp;
                      <input type="text" name="measure_name" id="measure_name" class="form-control f50" placeholder="Kg" require>
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 5px;"><em><strong>&nbsp;Descripcion de la medida</strong></em></td>
                    <td style="width: 172px;">&nbsp;
                      <input type="text" name="measure_desc" id="measure_desc" class="form-control f50" placeholder="Kilogramos">
                    </td>
                  </tr>

                </tbody>

              </table>
              <button type="button" class="btn btn-primary btn-sm" onclick="newM()">Agregar medida</button>
            </div>
    </div>
    </form>
    </div>
      