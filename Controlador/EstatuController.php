<?php
session_start();
ob_start();
require_once("../Modelo/estatu.php");
$estatu = new Estatu();
$estatu->setTabla("estatus");
switch($_REQUEST['accion'])
{
	case "buscatodos":
	{
		$todos = $estatu->getAll($tab);
		$_SESSION['cataesta'] = $todos;
		header("Location: ../Vista/estatu/estatu.php?accion=actual");
		break;
	}
	case "registrar":
	{
		if(isset($_REQUEST['BtRegistrar']))
		{
			$stdo = strtoupper($_POST['estatu']);
			$estatu->setEstatu($stdo);
			$estatu->guardarEstatus();
			header("Location: ../Vista/estatu/estatu.php?accion=actualizar");			
		}
		break;
	}
	case "eliminar":
	{
		$estatu->setId($_GET['id']);
		$comprobar=$estatu->comprobarDatos();
		if (empty($comprobar)) {
			$estatu->deleteById($id);
		}
		else {
			echo "<script>alert('no se puede eliminar este estatus porque tiene atletas asociados')</script>";//Mensaje de Sesión no válida
			echo "<META HTTP-EQUIV='refresh' CONTENT='0; URL=../Vista/estatu/estatu.php?accion=actualizar'>"; 

			break ;
		}
		header("Location: ../Vista/estatu/estatu.php?accion=actualizar");		
		break;	
	}
	case 'seleccionar':
	{
		$estatu->setId($_GET['id']);
		$datos = $estatu->getById($id);
		$_SESSION['modiesta'] = $datos;
		header("Location: ../Vista/estatu/estatu.php?accion=ver_detalles&id=".$id);	
		break;	
	}
	case 'modificar':
	{
		if(isset($_REQUEST['BtModificar']))
		{
			$estatu->setId($_GET['id']);
			$stdo = strtoupper($_POST['estatu']);
			$estatu->setEstatu($stdo);
			$estatu->modificarEstatus($id);
			header("Location: ../Vista/estatu/estatu.php?accion=actualizar");
		}
		break;
	}
}
ob_end_flush();
?>