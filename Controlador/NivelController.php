<?php
session_start();
ob_start();
require_once("../Modelo/nivel.php");
$nivel = new Nivel();
$nivel->setTabla("nivels");
switch($_REQUEST['accion'])
{
	case "buscatodos":
	{
		$todos = $nivel->getAll($tab);
		$_SESSION['catanive'] = $todos;
		header("Location: ../Vista/nivel/nivel.php?accion=actual");
		break;
	}
	case "registrar":
	{
		if(isset($_REQUEST['BtRegistrar']))
		{
			$stdo = strtoupper($_POST['nivel']);
			$nivel->setNivel($stdo);
			$nivel->guardarNivel();
			header("Location: ../Vista/nivel/nivel.php?accion=actualizar");			
		}
		break;
	}
	case "eliminar":
	{
		$nivel->setId($_GET['id']);
		$comprobar=$nivel->comprobarDatos();
		if (empty($comprobar)) {
			$nivel->deleteById($id);
		}
		else {
			echo "<script>alert('no se puede eliminar el nivel academico porque tiene atletas asociados')</script>";//Mensaje de Sesión no válida
			echo "<META HTTP-EQUIV='refresh' CONTENT='0; URL=../Vista/nivel/nivel.php?accion=actualizar'>"; 

			break ;
		}
		$nivel->deleteById($id);
		header("Location: ../Vista/nivel/nivel.php?accion=actualizar");		
		break;	
	}
	case 'seleccionar':
	{
		$nivel->setId($_GET['id']);
		$datos = $nivel->getById($id);
		$_SESSION['modinive'] = $datos;
		header("Location: ../Vista/nivel/nivel.php?accion=ver_detalles&id=".$id);	
		break;	
	}
	case 'modificar':
	{
		if(isset($_REQUEST['BtModificar']))
		{
			$nivel->setId($_GET['id']);
			$stdo = strtoupper($_POST['nivel']);
			$nivel->setNivel($stdo);
			$nivel->modificarNivel($id);
			header("Location: ../Vista/nivel/nivel.php?accion=actualizar");
		}
		break;
	}
}
ob_end_flush();
?>