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


$user_id = $_POST['userid'];

$sql_user='SELECT * FROM user WHERE user_id='.$user_id.';';
$result_user =  $conn->query($sql_user);
$row = mysqli_fetch_assoc($result_user);

$name = $row['user_name'];
$lastName = $row['user_lastname'];
$userName = $row['user_username'];
$userPsw = $row['user_psw'];
$userlvl = $row['user_level'];

mysqli_close($conn);

?>

<div class="col-md-12">
    <form>
        <div class="card">
            <div class="col-md-10 pdtop-0 text-left">
                <h2>Nuevo usuario</h2>
             </div>
            <div class="col-md-12 pdtop-1">
                <table style="height: 100%; width:100%;" class="table table-sm">
                    <tbody>
                        <tr >
                            <td style="width: 5px;"><em><strong>&nbsp;Nombre del Usuario</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="text" name="userRName" id="userRName" class="form-control f50" placeholder="Juan" value="<?php echo $name ?>" require>
                            </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Apellido del usuario</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="text" name="userLN" id="userLN" class="form-control f50" placeholder="Perez" value="<?php echo $lastName ?>" require>
                            </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Nombre de Usuario</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="text" name="userName" id="userName" class="form-control f50" placeholder="PerezJ" value="<?php echo $userName ?>" require>
                            </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Contraseña</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="text" name="userPsw" id="userPsw" class="form-control f50" placeholder="*********"  require>
                            </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Nivel de acceso</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="number" name="userlvl" id="userlvl" class="form-control f50" placeholder="1" value="<?php echo $userlvl ?>" require>
                            </td>
                          </tr>

                        </tbody>

                      </table>
                      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#confirmCreate">Editar Usuario</button>
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
                            <p>Usted esta a punto modificar la informacion de este usuario, ¿Desea continuar?</p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="button" onclick="modificarUser()" class="btn btn-primary">Continuar</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

<script>
    function modificarUser(){
        if(!$('#userRName').val() || !$('#userLN').val() || !$('#userName').val() || !$('#userPsw').val() || !$('#userlvl').val()){
            alert("Aun faltan algunos datos para poder proceder con la creacion del usuario");
        }else{
            $.ajax({
            type: "POST",
            url: "../queries/editUser.php",
            data: {
                user_id:'<?php echo $user_id?>',
                user_rname:$('#userRName').val(),
                user_lname:$('#userLN').val(),
                user_name:$('#userName').val(),
                user_psw:$('#userPsw').val(),
                user_lvl:$('#userlvl').val()
                
            },
            success: function (data) {
                $('#product_updated').html(data);
                document.location.href='../config/config.php';
            }
        });
        } 
            
    }
</script>