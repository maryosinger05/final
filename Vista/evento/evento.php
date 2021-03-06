<?php
session_start();
if(empty($_SESSION['nombre']))
	{
		header('Location: ../Persona/InicioSesion.php');
	}
if($_GET['accion']=="actualizar")
{
	header("Location: ../../Controlador/EventoController.php?accion=buscatodos");
}

if(empty($_REQUEST['accion']))
{
	header("Location: ../menuv/menuv.php?accion=validado");
}

$perfil = $_SESSION['nombre']." ".$_SESSION['apellido'];
$form='';
$cata='';
$boton='';
$todos = $_SESSION['coño'];
$select = "<select name='id_disciplina' required>";
$select.= "<option>Seleccione un tipo</option>";
foreach($todos as $t)
{
	$select.= "<option value=".$t['id'].">".$t['disciplina']."</option>";	
}
$select.= "</select>";

$todostd = $_SESSION['municipio'];
$municipio = "<select name='id_municipio' required>";
$municipio.= "<option>Seleccione un municipio</option>";
foreach($todostd as $t)
{
$municipio.= "<option value=".$t['id'].">".$t['descrips']."</option>";	
}
$municipio.= "</select>";

$parroquia = "<select name='id_parroquia' required>";
$parroquia.= "<option>Seleccione una parroquia</option>";
$todospa = $_SESSION['parroquia'];
foreach($todospa as $t)
{
$parroquia.= "<option value=".$t['id']." class='mun".$t['id_municipio']."'>".$t['descrip']."</option>";	
}
$parroquia.= "</select>";

$todoslo = $_SESSION['tipo_logro'];
$tipo = "<select name='tipo' required>";
$tipo.= "<option>Seleccione un tipo de evento</option>";
foreach($todoslo as $t)
{
	$tipo.= "<option value=".$t['tipo_logro'].">".$t['tipo_logro']."</option>";	
}

$tipo.= "</select>";



$form.='<form name="regevento" method="post" action="../../Controlador/EventoController.php?accion=registrar">';
$form.='<table>';
$form.='<tr>';
$form.='<td>Nombre:</td>';
$form.='<td><input id="" type="text" class="cajasdetexto" name="nombre" maxlenght="9" onkeypress="return caracteres(event)" required></td>';
$form.='</tr>';
$form.='<tr>';
$form.='<td>Disciplina:</td>';
$form.='<td>'.$select.'</td>';
$form.='</tr>';
$form.='<tr>';
$form.='<td>Municipio:</td>';
$form.='<td>'.$municipio.'</td>';
$form.='</tr>';
$form.='<tr>';
$form.='<td>Parroquia:</td>';
$form.='<td>'.$parroquia.'</td>';
$form.='</tr>';
$form.='<tr>';
$form.='<td>Fecha de Inicio (yyyy-mm-dd):</td>';
$form.='<td><input type="text" name="fecha_inicio" class="date" id="fecha1" onblur="valFechas()"  pattern="([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))" max="'.date("Y-m-d").'" value="'.date("Y-m-d").'" onkeypress="return solonumerosguion(event)" onpaste="return false" required></td>';
$form.='</tr>';
$form.='<tr>';
$form.='<td>Fecha de Cierre (yyyy-mm-dd):</td>';
$form.='<td><input type="text" name="fecha_cierre" class="date" id="fecha2" onblur="valFechas()"  pattern="([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))" max="'.date("Y-m-d").'" value="'.date("Y-m-d").'" onkeypress="return solonumerosguion(event)" onpaste="return false" required></td>';
$form.='</tr>';
$form.='<tr>';
$form.='<td>Cantidad de Participantes:</td>';
$form.='<td><input id="" type="text" class="date" name="canti" size="3" onkeypress="return solonumeros(event)" onpaste="return false" pattern="([1-9]{1})([0-9]{1,})*" required></td>';
$form.='</tr>';
$form.='<tr>';
$form.='<td>N° de Participantes por Equipo:</td>';
$form.='<td><input id="" type="text" class="date" name="parti" size="3" onkeypress="return solonumeros(event)" onpaste="return false" pattern="([1-9]{1})([0-9]{1,})*" required></td>';
$form.='</tr>';
$form.='<tr>';
$form.='<tr>';
$form.='<td>Tipo de Evento:</td>';
$form.='<td>'.$tipo.'</td>';
$form.='</tr>';
$form.='<tr>';
$form.='<td>Descripción:</td>';
$form.='<td><textarea rows="5" cols="20" name="descripcion" id="descripcion" class="cajasdetexto" maxlenght="9" required></textarea></td>';
$form.='</tr>';

$form.='</table>';
$form.=' <input type="submit" value="Registrar" id="submit" name="BtRegistrar">';
$form.='</form>';



$diccionario = array 
(
	'PERFIL' => $perfil,
	'TITULO'=>'Evento',
	'CATALOGO'=>'',
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