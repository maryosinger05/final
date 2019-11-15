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
$_SESSION['titulo']='Reporte de Atletas Filtrado por Genero';
$form='';
$cata='';
$boton='';
$form.='<form name="atleta" method="post" action="../../Controlador/AtletaController.php?accion=filtrosexo">';
$sexo ="<select name='primer' required>";
$sexo.="<option value=''>Seleccione un sexo</option>";
$sexo.= "<option>F</option>";
$sexo.= "<option>M</option>";
$sexo.="</select>";

$form.='<table>';
$form.='<tr>';
$form.='<td>Ingrese el genero</td>';
$form.='<td>'.$sexo.'</td>';
$form.='<td> <input type="submit" class="botonmodal" value="Buscar"> </td>';
$form.='</tr>';
$form.='</table>';
$form.='</form>';






$diccionario = array 
(
	'PERFIL' => $perfil,
	'TITULO'=>'Filtrar por Genero',
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
