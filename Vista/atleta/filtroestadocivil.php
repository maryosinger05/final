<?php
session_start();
if(empty($_SESSION['nombre']))
{
	header('Location: ../Persona/InicioSesion.php');
}



if(empty($_REQUEST['accion']))
{
	header("Location: ../menuv/menuv.php?accion=validado");
}



$perfil = $_SESSION['nombre']." ".$_SESSION['apellido'];
$_SESSION['titulo']='Reporte de Atletas Filtrado por Estado Cívil';
$form='';
$cata='';
$boton='';
$form.='<form name="atleta" method="post" action="../../Controlador/AtletaController.php?accion=filtroestadocivil">';
$estadocivil.="<select name='primer' required>";
$estadocivil.= "<option value=''>Seleccione un estado civil</option>";
$estadocivil.= "<option>SOLTERO/A</option>";
$estadocivil.= "<option>CASADO/A</option>";
$estadocivil.= "<option>DIVORCIADO/A</option>";
$estadocivil.= "<option>VIUDO/A</option>";
$estadocivil.= "</select>";
$form.='<table>';
$form.='<tr>';
$form.='<td>Ingrese el estado cívil</td>';
$form.='<td>'.$estadocivil.'</td>';
$form.='<td> <input type="submit" class="botonmodal" value="Buscar"> </td>';
$form.='</tr>';
$form.='</table>';
$form.='</form>';






$diccionario = array 
(
	'PERFIL' => $perfil,
	'TITULO'=>'Filtrar por Estado Cívil',
	'CATALOGO'=>$cata,
	'BOTONREG'=>$boton,
	'FORMULARIO'=>$form, 	
	'MENU'=>$_SESSION['menu']
);
$template = file_get_contents('../Plantilla/ventanamodal.html');
foreach ($diccionario as $clave=>$valor)
{
	$template = str_replace("{".$clave."}", $valor, $template);
}
print $template;
?>
