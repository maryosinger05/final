<?php
session_start();
if(empty($_SESSION['nombre']))
{
	header('Location: ../Persona/InicioSesion.php');
}

if($_GET['accion']=="actualizar")
{
	header("Location: ../../Controlador/AtletaController.php?accion=buscatodos1");
}

if(empty($_REQUEST['accion']))
{
	header("Location: ../menuv/menuv.php?accion=validado");
}

$perfil = $_SESSION['nombre']." ".$_SESSION['apellido'];
$form='';
$cata='';
$boton='';
$form.='<table>';
$form.='<tr>';
$form.='<td>Buscador:</td>';
$form.='<td><input id="searchTerm" type="text" class="cajasdetexto" onkeyup="doSearch()"></td>';
$form.='<td> <a href="datosp.php?accion=registrar"><input type="button" class="botonmodal" value="+ Atleta" title="Agregar un atleta"> </a></td>';
$form.='</tr>';
$form.='</table>';
$form.='<table>';
$form.='<tr>';
$form.='<td> <a href="generarreporte.php?accion=activos"><input type="button" class="botonmodal" value="Generar Reporte" name="activos" title="Generar Reporte"> </a></td>';
$form.='<td> <a href="consultaatleta1.php?accion=actualizar"><input type="button" class="botonmodal" value="Atletas Inactivos" title="Atletas Inactivos"> </a></td>';
$form.='<td> <a href="consultaatleta2.php?accion=actualizar"><input type="button" class="botonmodal" value="Atletas Gloriosos" title="Atletas Gloriosos"> </a></td>';
$form.='</tr>';
$form.='</table>';

if($_GET['accion']=="actual"&&!empty($_SESSION['cataatle']))
{
	$catalogo = $_SESSION['cataatle'];
	$reporte='';
	$cata.="<form name='catalog' action='../../Controlador/AtletaController.php?accion=registrar' method='post'>";
	$cata.="<table class=tabla-cat id=tabla>";

	$reporte.="<br><table class=tabla-cat id=tabla>";
	$reporte.="<table class=tabla-catb id=tabla>";
	
	$cata.="<tr><th>Cédula</th><th>Nombre</th><th>Apellido</th><th>Fecha de Nacimiento</th><th>Tipo Sanguineo</th><th>Mano Habil</th><th>Sexo</th><th>Peso</th><th>Altura</th><th>Talla</th><th>Calzado</th><th>Número de Teléfono</th><th colspan='4'>Acción</th></tr>";
	$reporte.="<tr><th>Cédula</th><th>Nombre</th><th>Apellido</th><th>Fecha de Nacimiento</th><th>Tipo Sanguineo</th><th>Mano Habil</th><th>Sexo</th><th>Peso</th><th>Altura</th><th>Talla</th><th>Calzado</th><th>Número de Teléfono</th></tr>";

	foreach($catalogo as $cat)
	{
		$cata.="<tr>";	
		$cata.="<td>".$cat['cedula']."</td>";	
		$cata.="<td>".$cat['nombre']."</td>";	
		$cata.="<td>".$cat['apellido']."</td>";	
		$cata.="<td>".$cat['f_nac']."</td>";	
		$cata.="<td>".$cat['tipos']."</td>";	
		$cata.="<td>".$cat['mano']."</td>";	
		$cata.="<td>".$cat['sexo']."</td>";	
		$cata.="<td>".$cat['peso']."</td>";
		$cata.="<td>".$cat['altura']."</td>";	
		$cata.="<td>".$cat['talla']."</td>";	
		$cata.="<td>".$cat['calzado']."</td>";	
		$cata.="<td>".$cat['n_tel']."</td>";	

		$cata.="<td><a href='../../Controlador/LogroController.php?accion=seleccionar&id=".$cat['id']."'>";
		$cata.="<img src='../imagenes1/logro1.png' width='15px' height='15px' title='Logros'></a></td>";
		$cata.="<td><a href='../../Controlador/AtletaController.php?accion=seleccionar&id=".$cat['id']."'>";	
		$cata.="<img src='../imagenes1/editar.png' width='15px' height='15px' title='Editar'></a></td>";
		$cata.="<td><a href='../../Controlador/AtletaController.php?accion=eliminar1&id=".$cat['id']."'>";	
		$cata.="<img src='../imagenes1/glorioso.png' width='18px' height='18px' title='Gloriosos'></a></td>";
		$cata.="<td><a href='../../Controlador/AtletaController.php?accion=eliminar&id=".$cat['id']."'>";	
		$cata.="<img src='../imagenes1/eliminar.png' width='15px' height='15px' title='Inhabilitar'></a></td>";	
		$cata.="</tr>";	

		$reporte.="<tr>";	
        $reporte.="<td>".$cat['cedula']."</td>";
        $reporte.="<td>".$cat['nombre']."</td>";
		$reporte.="<td>".$cat['apellido']."</td>";	
        $reporte.="<td>".$cat['f_nac']."</td>";	
        $reporte.="<td>".$cat['tipos']."</td>";	
        $reporte.="<td>".$cat['mano']."</td>";	
        $reporte.="<td>".$cat['sexo']."</td>";	
		$reporte.="<td>".$cat['peso']."</td>";
		$reporte.="<td>".$cat['altura']."</td>";	
		$reporte.="<td>".$cat['talla']."</td>";	
		$reporte.="<td>".$cat['calzado']."</td>";	
		$reporte.="<td>".$cat['n_tel']."</td>";	
		$reporte.="</tr>";
	}
	$cata.="</table><br>";

	$reporte.="<table class=obser>";
	$reporte.="<tr>";
	$reporte.="<td>Observaciones:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
	$reporte.="</tr>";
	$reporte.="</table>";

	$reporte.="</table>";
	
	$reporte.="</table><br>";

	$_SESSION['reporte']=$reporte;

}
if (empty($_SESSION['cataatle'])) {
	$cata.="no hay atletas registrados";
}


$diccionario = array 
(
	'PERFIL' => $perfil,
	'TITULO'=>'Atletas',
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