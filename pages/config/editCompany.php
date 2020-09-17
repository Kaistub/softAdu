<?php
include '../conn/conn.php';
if(session_id() == '') {
 session_start();}
 if (!$_SESSION['user']) {
   header("Location: /");
}
if ($_SESSION['LevelAccess'] != 3) {
  header("Location: /");
}



$sql_company='SELECT * FROM company;';
$result_company =  $conn->query($sql_company);
$row = mysqli_fetch_assoc($result_company);

$id= $row['company_id'];
$rz = $row['company_rz'];
$rfc = $row['company_rfc'];
$address = $row['company_address'];
$city = $row['company_city'];
$state = $row['company_state'];
$country = $row['company_country'];
$branchoffice = $row['company_branchoffice'];

mysqli_close($conn);

?>

<div class="col-md-12">
    <form>
        <div class="card">
            <div class="col-md-10 pdtop-0 text-left">
                <h2>Modificar datos de la empresa</h2>
             </div>
            <div class="col-md-12 pdtop-1">
                <table style="height: 100%; width:100%;" class="table table-sm">
                    <tbody>
                    <tr >
                            <td style="width: 5px;"><em><strong>&nbsp;Razon social</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="text" name="rz" id="rz" class="form-control f50" placeholder="" value="<?php echo $rz ?>" require>
                            </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;RFC</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="text" name="rfc" id="rfc" class="form-control f50" placeholder="" value="<?php echo $rfc ?>" require>
                            </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Direccion</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="text" name="address" id="address" class="form-control f50" placeholder="" value="<?php echo $address ?>" require>
                            </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Ciudad</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="text" name="city" id="city" class="form-control f50" placeholder="" value="<?php echo $city ?>" require>
                            </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Estado</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="text" name="state" id="state" class="form-control f50" placeholder="1" value="<?php echo $state ?>" require>
                            </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Pais</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="text" name="country" id="country" class="form-control f50" placeholder="1" value="<?php echo $country ?>" require>
                            </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Oficina</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="text" name="branchoffice" id="branchoffice" class="form-control f50" placeholder="1" value="<?php echo $branchoffice ?>" require>
                            </td>
                          </tr>

                        </tbody>

                      </table>
                      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#confirmCreate">Modificar la compañia</button>
                      <!-- Modal -->
                    <div class="modal fade" id="confirmCreate" tabindex="-1" role="dialog" aria-labelledby="confirmCreate" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Verificacion</h5>
                            <button type="" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <p>Usted esta a punto modificar la informacion de la compañia, ¿Desea continuar?</p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="button" onclick="modificarCompany()" class="btn btn-primary">Continuar</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

<script>
    function modificarCompany(){
        if(!$('#rz').val() || !$('#rfc').val() || !$('#address').val() || !$('#city').val() || !$('#state').val() || !$('#country').val() || !$('#branchoffice').val()){
            alert("Aun faltan algunos datos para poder proceder con la edicion de la compañia");
        }else{
            $.ajax({
            type: "POST",
            url: "../queries/editCompany.php",
            data: {
                company_id:'<?php echo $id?>',
                company_rz:$('#rz').val(),
                company_rfc:$('#rfc').val(),
                company_address:$('#address').val(),
                company_city:$('#city').val(),
                company_state:$('#state').val(),
                company_country:$('#country').val(),
                company_branchoffice:$('#branchoffice').val()
                
            },
            success: function (data) {
                $('#product_updated').html(data);
                document.location.href='../config/config.php';
            }
        });
        } 
            
    }
</script>