<?php
session_start();
require_once("../Modelo/discapacidad.php");
$discapacidad = new Discapacidad();
$discapacidad->setTabla("discapacidades");
switch($_REQUEST['accion'])
{
	case "buscatodos":
	{
		$todos = $discapacidad->getAll($tab);
		$_SESSION['catadisc'] = $todos;
		header("Location: ../Vista/discapacidad/discapacidad.php?accion=actual");
		break;
	}
	case "registrar":
	{
		if(isset($_REQUEST['BtRegistrar']))
		{
			$stdo = strtoupper($_POST['discapacidad']);
			$discapacidad->setDiscapacidad($stdo);
			$discapacidad->guardarDiscapacidad();
			header("Location: ../Vista/discapacidad/discapacidad.php?accion=actualizar");			
		}
		break;
	}
	case "eliminar":
	{
		$discapacidad->setId($_GET['id']);
		$discapacidad->deleteById($id);
		header("Location: ../Vista/discapacidad/discapacidad.php?accion=actualizar");		
		break;	
	}
	case 'seleccionar':
	{
		$discapacidad->setId($_GET['id']);
		$datos = $discapacidad->getById($id);
		$_SESSION['modidisc'] = $datos;
		header("Location: ../Vista/discapacidad/discapacidad.php?accion=ver_detalles&id=".$id);	
		break;	
	}
	case 'modificar':
	{
		if(isset($_REQUEST['BtModificar']))
		{
			$discapacidad->setId($_GET['id']);
			$stdo = strtoupper($_POST['discapacidad']);
			$discapacidad->setDiscapacidad($stdo);
			$discapacidad->modificarDiscapacidad($id);
			header("Location: ../Vista/discapacidad/discapacidad.php?accion=actualizar");
		}
		break;
	}
}
?>