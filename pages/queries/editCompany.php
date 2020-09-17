<?php
include '../conn/conn.php';
if(session_id() == '') {
 session_start();}
 if (!$_SESSION['user']) {
   header("Location: /");
}


$id = $_POST['company_id'];
$rz = $_POST['company_rz'];
$rfc = $_POST['company_rfc'];
$address = $_POST['company_address'];
$city = $_POST['company_city'];
$state = $_POST['company_state'];
$country = $_POST['company_country'];
$branchoffice = $_POST['company_branchoffice'];


$sql_company = 'UPDATE company SET company_rz="'.$rz.'", company_rfc="'.$rfc.'" ,company_address="'.$address.'" ,company_city="'.$city.'" ,company_state="'.$state.'" ,company_country="'.$country.'" ,company_branchoffice="'.$branchoffice.'" WHERE company_id='.$id.';';
$result_company =  $conn->query($sql_company);

?>