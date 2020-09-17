<?php
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
                <h2>Nuevo usuario</h2>
             </div>
            <div class="col-md-12 pdtop-1">
                <table style="height: 100%; width:100%;" class="table table-sm">
                    <tbody>
                        <tr >
                            <td style="width: 5px;"><em><strong>&nbsp;Nombre del Usuario</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="text" name="userRName" id="userRName" class="form-control f50" placeholder="Juan" require>
                            </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Apellido del usuario</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="text" name="userLN" id="userLN" class="form-control f50" placeholder="Perez" require>
                            </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Nombre de Usuario</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="text" name="userName" id="userName" class="form-control f50" placeholder="PerezJ" require>
                            </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Contraseña</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="text" name="userPsw" id="userPsw" class="form-control f50" placeholder="*********" require>
                            </td>
                          </tr>
                          <tr>
                            <td style="width: 5px;"><em><strong>&nbsp;Nivel de acceso</strong></em></td>
                            <td style="width: 172px;">&nbsp;
                              <input type="number" name="userlvl" id="userlvl" class="form-control f50" placeholder="1" require>
                            </td>
                          </tr>

                        </tbody>

                      </table>
                      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#confirmCreate">Crear Usuario</button>
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
                            <p>Usted esta a punto de crear este usuario, ¿Desea continuar?</p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="button" onclick="createUser()" class="btn btn-primary">Continuar</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

<script>
    function createUser(){
        if(!$('#userRName').val() || !$('#userLN').val() || !$('#userName').val() || !$('#userPsw').val() || !$('#userlvl').val()){
            alert("Aun faltan algunos datos para poder proceder con la creacion del usuario");
        }else{
            $.ajax({
            type: "POST",
            url: "../queries/newUserC.php",
            data: {
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