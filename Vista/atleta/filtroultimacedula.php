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
$_SESSION['titulo']='Reporte de Atletas Filtrado por el Último Dígito de los Documentos de Identidad';
$form='';
$cata='';
$boton='';
$form.='<form name="atleta" method="post" action="../../Controlador/AtletaController.php?accion=filtroultimodigito">';
$form.='<table>';
$form.='<tr>';
$form.='<td>Ingrese el terminal de los Documentos de Identidad a buscar:</td>';
$form.='<td><input  type="text" class="cajasdetexto"  name="primer" pattern="[0-9]{1}" title="Solo un dígito, Por favor rellenar con el formato correcto. Si es pasaporte solo colocar los números" onkeypress="return solonumeros(event)" onpaste="return false" required></td>';
$form.='<td> <input type="submit" class="botonmodal" value="Buscar"> </td>';
$form.='</tr>';
$form.='</table>';
$form.='</form>';






$diccionario = array 
(
	'PERFIL' => $perfil,
	'TITULO'=>'Filtrar por Último Dígito del Documento de Identidad',
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
