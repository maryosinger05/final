<?php
session_start();
ob_start();
require_once("../Modelo/disciplina.php");
$disciplina = new Disciplina();
$disciplina->setTabla("disciplinas");
switch($_REQUEST['accion'])
{
	case "buscatodos":
	{
		$todos = $disciplina->getallactivas($tab);
		$_SESSION['catadisci'] = $todos;
		header("Location: ../Vista/disciplina/disciplina.php?accion=actual");
		break;
	}
	case "buscatodos1":
		{
			$todos = $disciplina->getallinactivas($tab);
			$_SESSION['catadisci1'] = $todos;
			header("Location: ../Vista/disciplina/disciplina1.php?accion=actual");
			break;
		}
	case "registrar":
	{
		if(isset($_REQUEST['BtRegistrar']))
		{
			$stdo = strtoupper($_POST['disciplina']);
			$disciplina->setDisciplina($stdo);
			$disciplina->guardarDisciplina();
			header("Location: ../Vista/disciplina/disciplina.php?accion=actualizar");			
		}
		break;
	}
	case "eliminar":
	{
		$disciplina->setId($_GET['id']);
		$disciplina->updatedis();
		$disciplina->updatemod();

		header("Location: ../Vista/disciplina/disciplina.php?accion=actualizar");		
		break;	
	}
	case 'seleccionar':
	{
		$disciplina->setId($_GET['id']);
		$datos = $disciplina->getById($id);
		$_SESSION['modidisci'] = $datos;
		header("Location: ../Vista/disciplina/disciplina.php?accion=ver_detalles&id=".$id);	
		break;	
	}
	case 'modificar':
	{
		if(isset($_REQUEST['BtModificar']))
		{
			$disciplina->setId($_GET['id']);
			$stdo = strtoupper($_POST['disciplina']);
			$disciplina->setDisciplina($stdo);
			$disciplina->modificarPersona($_GET['id']);
			header("Location: ../Vista/disciplina/disciplina.php?accion=actualizar");
		}
		break;
	}

	case "reactivar1":
		{
			$disciplina->setId($_GET['id']);
			$disciplina->updatedis1();
	
			header("Location: ../Vista/disciplina/disciplina1.php?accion=actualizar");		
			break;	
		}
}
ob_end_flush();
?>