<?php
session_start();
ob_start();
require_once("../Modelo/beca.php");
require_once("../Modelo/disciplina.php");

$beca = new Beca();
$disciplina = new Disciplina();

$beca->setTabla("becas");
$disciplina->setTabla("disciplinas");

switch($_REQUEST['accion'])
{
	case "buscatodos":
	{
		$todos = $beca->todosatletas($tab);
		$_SESSION['catabeca'] = $todos;
		header("Location: ../Vista/beca/beca.php?accion=actual");
		break;
	}

	case "buscatodos1":
	{
		$todos = $beca->todosatletas($tab);
		$_SESSION['catabeca'] = $todos;
		header("Location: ../Vista/beca/becanueva.php?accion=actual");
		break;
	}
	case "buscatodos11":
	{
		$todos = $beca->todosatletasgloriosos($tab);
		$_SESSION['catabeca100'] = $todos;
		header("Location: ../Vista/beca/becanuevagloria.php?accion=actual");
		break;
	}
	case "buscatodos111":
	{
		$todos = $beca->todosatletasgloriosos($tab);
		$_SESSION['catabeca100'] = $todos;
		header("Location: ../Vista/beca/becagloria.php?accion=actual");
		break;
	}

	case "buscatodos2":
	{
		$todos = $beca->todosBecas($tab);
		$_SESSION['catabeca5'] = $todos;
		header("Location: ../Vista/beca/crear.php?accion=actual");
		break;
	}
	case "buscatodos22":
	{
		$todos = $beca->todosBecasgloriosos($tab);
		$_SESSION['catabeca5'] = $todos;
		header("Location: ../Vista/beca/crear.php?accion=actual");
		break;
	}

	case "buscaGlobal":
	{
		$todos = $beca->todosTotal($tab);
		$_SESSION['catabeca1'] = $todos;
		header("Location: ../Vista/beca/consultaglobal.php?accion=actual");
		break;
	}

	case 'buscamelasdisciplinas':
		{
			$n = $disciplina->getallactivas($tab);
			$_SESSION['disciplin'] = $n;
			
			
			
			header("Location: ../Vista/beca/filtrobecadisc.php?accion=actual");
			break;
		}

		case 'buscamelasdisciplinasgloria':
			{
				$n = $disciplina->getallactivas($tab);
				$_SESSION['disciplin'] = $n;
				

				
				
				header("Location: ../Vista/beca/filtrobecadiscgloria.php?accion=actual");
				break;
			}

	case "registrarPago":
	{
		if(isset($_REQUEST['BtRegistrar']))
		{
			$cont=0;
			$z=$beca->selexmax();
			$x=$z[0][0];

			$p=$beca->selexmaxbeca();
			$l=$p[0][0];
			
			$bec = strtoupper($_POST['nombre']);
			$beca->setNombre($bec);
			$temporal=$beca->getNombre();

			$beca->setFecha($_POST['fecha']);
			$fecha=$beca->getFecha();

			$a=$beca->todosTotal();
			$b=$beca->cuenta();


			for ($t=0;$t<$b[0][0];$t++) {
				if ($temporal==$a[$t][4]) {
					if ($fecha==$a[$t][1]) {
						$beca->borron();
						$beca->borrontotal();
					}
					

				}
			}

			

			

			

			$q=$beca->selexmax();
			$w=$q[0][0];
			
			$ladilla=1;

			for ($i=1;$i<=$w;$i++) {
				$beca->setMonto($_POST['pago'.$i]);
				$comprobador=$beca->getMonto();



				if (empty($comprobador)) {
					$ladilla=$ladilla+1;
				}
				else  {

				}
			}
			$w=$w+1;

		
			if ($w==$ladilla) {
					echo "<script>alert('no puedes dejar todos los campos vacios')</script>";//Mensaje de Sesión no válida
					echo "<META HTTP-EQUIV='refresh' CONTENT='0; URL=../Vista/beca/becanueva.php?accion=actual'>"; 
				break;
			}

			$beca->truncar();
			$contbice=0;
			$contgeneral=0;
			$totalgeneral=0;
			$totalbice=0;

			$bec = strtoupper($_POST['nombre']);
			$beca->setNombre($bec);

			$_SESSION['nombres']=$beca->getNombre();

			$m=$beca->todosBecas1();



			for ($i=0;$i<=$x;$i++) {
				$beca->setId_atleta($i);
				$beca->setMonto($_POST['pago'.$i]);
				$beca->setDisc($_POST['disc'.$i]);
				$beca->setFecha($_POST['fecha']);
				$originalDate = $beca->getFecha();
				$newDate = date("Ymd", strtotime($originalDate));
				$_SESSION['fechas']=$newDate;
				
				$comprobador=$beca->getMonto();

				if (empty($comprobador)) {

				}
				elseif ($comprobador==0) {

				}

				elseif ($comprobador>0) {
					if (strncmp($_POST['cuenta'.$i],'0175',4)===0) {
						$contbice=$contbice+1;
						$bice=$beca->getMonto();

						$totalbice=$totalbice+$bice;

					}
					else {
						$contgeneral=$contgeneral+1;
						$gene=$beca->getMonto();

						$totalgeneral=$totalgeneral+$gene;

					}
					$cont=$cont+1;
					$temp=$beca->getMonto();
					$total=$total+$temp;
					$beca->guardarPersona();
					$beca->guardarRegistro();
				}
			}

			$beca->setFecha($_POST['fecha']);
			

			$beca->setMontoT($total);
			$numeroConCeros5 = str_pad($totalgeneral, 11, "0", STR_PAD_LEFT);
			$_SESSION['total']= $numeroConCeros5;
			$numeroConCeros6 = str_pad($totalbice, 11, "0", STR_PAD_LEFT);
            $_SESSION['totalbice']= $numeroConCeros6;

			$beca->setBecados($cont);
			
			$numeroConCeros3 = str_pad($contgeneral, 6, "0", STR_PAD_LEFT);
			$_SESSION['cantidad']= $numeroConCeros3;
			$numeroConCeros4 = str_pad($contbice, 6, "0", STR_PAD_LEFT);
			$_SESSION['cantidadbice']= $numeroConCeros4;

			$beca->guardarDefinitivo();

			for ($t=0;$t<$b[0][0];$t++) {
				if ($temporal==$a[$t][4]) {
					if ($fecha==$a[$t][1]) {
						echo "<script>alert('ya existe una beca con el mismo nombre y fecha, los datos se sustituiran automaticamente')</script>";//Mensaje de Sesión no válida
						echo "<META HTTP-EQUIV='refresh' CONTENT='0; URL=../Vista/beca/crear.php?accion=actualizar'>"; 
						break 2;
					}
					

				}
			}


			
			header("Location: ../Vista/beca/crear.php?accion=actualizar");


			
		}
		break;
	}

	case "registrarPagogloria":
	{
		if(isset($_REQUEST['BtRegistrar']))
		{
			$cont=0;
			$z=$beca->selexmax();
			$x=$z[0][0];

			$p=$beca->selexmaxbeca();
			$l=$p[0][0];
			$bec = strtoupper($_POST['nombre']);
			$beca->setNombre($bec);
			$temporal=$beca->getNombre();

			$beca->setFecha($_POST['fecha']);
			$fecha=$beca->getFecha();

			$a=$beca->todosTotal();
			$b=$beca->cuenta();


			for ($t=0;$t<$b[0][0];$t++) {
				if ($temporal==$a[$t][4]) {
					if ($fecha==$a[$t][1]) {
						$beca->borron();
						$beca->borrontotal();
					}
					

				}
			}

			
			

			$q=$beca->selexmax();
			$w=$q[0][0];
			

			$ladilla=1;

			for ($i=1;$i<=$w;$i++) {
				$beca->setMonto($_POST['pago'.$i]);
				$comprobador=$beca->getMonto();


				if (empty($comprobador)) {
					$ladilla=$ladilla+1;
				}
				else  {

				}
			}
			$w=$w+1;


			if ($w==$ladilla) {
					echo "<script>alert('no puedes dejar todos los campos vacios')</script>";//Mensaje de Sesión no válida
					echo "<META HTTP-EQUIV='refresh' CONTENT='0; URL=../Vista/beca/becanuevagloria.php?accion=actual'>"; 
				break;
			}

			$beca->truncar_gloria();
			$contbice=0;
			$contgeneral=0;
			$totalgeneral=0;
			$totalbice=0;

			$bec = strtoupper($_POST['nombre']);
			$beca->setNombre($bec);

			$_SESSION['nombres']=$beca->getNombre();

			$m=$beca->todosBecas1();



			for ($i=0;$i<=$x;$i++) {
				$beca->setId_atleta($i);
				$beca->setMonto($_POST['pago'.$i]);
				$beca->setFecha($_POST['fecha']);
				$beca->setDisc($_POST['disc'.$i]);
				$beca->setGloria('1');
				$originalDate = $beca->getFecha();
				$newDate = date("Ymd", strtotime($originalDate));
				$_SESSION['fechas']=$newDate;
				
				$comprobador=$beca->getMonto();
			
				if (empty($comprobador)) {

				}
				elseif ($comprobador==0) {

				}

				elseif ($comprobador>0) {
					if (strncmp($_POST['cuenta'.$i],'0175',4)===0) {
						$contbice=$contbice+1;
						$bice=$beca->getMonto();

						$totalbice=$totalbice+$bice;

					}
					else {
						$contgeneral=$contgeneral+1;
						$gene=$beca->getMonto();

						$totalgeneral=$totalgeneral+$gene;

					}
					$cont=$cont+1;
					$temp=$beca->getMonto();
					$total=$total+$temp;
					$beca->setNombre($bec);
					$beca->setGloria('1');

					$beca->guardarPersonagloriosa();
					$beca->guardarRegistro();
				}
			}
			$beca->setFecha($_POST['fecha']);
			

			$beca->setMontoT($total);
			$numeroConCeros5 = str_pad($totalgeneral, 11, "0", STR_PAD_LEFT);
			$_SESSION['total']= $numeroConCeros5;
			$numeroConCeros6 = str_pad($totalbice, 11, "0", STR_PAD_LEFT);
            $_SESSION['totalbice']= $numeroConCeros6;

			$beca->setBecados($cont);
			
			$numeroConCeros3 = str_pad($contgeneral, 6, "0", STR_PAD_LEFT);
			$_SESSION['cantidad']= $numeroConCeros3;
			$numeroConCeros4 = str_pad($contbice, 6, "0", STR_PAD_LEFT);
			$_SESSION['cantidadbice']= $numeroConCeros4;

			$beca->guardarDefinitivo();

			
			for ($t=0;$t<$b[0][0];$t++) {
				if ($temporal==$a[$t][4]) {
					if ($fecha==$a[$t][1]) {
						echo "<script>alert('ya existe una beca con el mismo nombre y fecha, los datos se sustituiran automaticamente')</script>";//Mensaje de Sesión no válida
						echo "<META HTTP-EQUIV='refresh' CONTENT='0; URL=../Vista/beca/crear.php?accion=actualizar'>"; 
						break 2;
					}
					

				}
			}

			
			header("Location: ../Vista/beca/crear.php?accion=actualizar1&id=".$id);	


			
		}
		break;
	}
	
	case 'seleccionar':
	{
		$beca->setFecha($_GET['fecha']);
		$beca->setNombre($_GET['nombre']);
		$datos = $beca->getDetalles();
		$_SESSION['detallebeca'] = $datos;

		$encabezado = $beca->getDetallesenca();
		$_SESSION['encabezado'] = $encabezado;

		header("Location: ../Vista/beca/detallebeca.php?accion=actual&id=".$id);	


		break;	
	}
	case 'modificar':
	{
		if(isset($_REQUEST['BtModificar']))
		{
			$beca->setId($_GET['id']);
			$stdo = strtoupper($_POST['beca']);
			$beca->setBeca($stdo);
			$beca->modificarBeca($id);
			header("Location: ../Vista/beca/beca.php?accion=actualizar");
		}
		break;
	}

	case "filtrogeneral":
		{

			$beca->setPrimer($_POST['primer']);
			$_SESSION['desde']=$beca->getPrimer();
			$beca->setSegundo($_POST['segundo']);
			$_SESSION['hasta']=$beca->getSegundo();
			$todos = $beca->becasfiltradas();
			$_SESSION['catabecageneral'] = $todos;
			$monto = $beca->montogeneral();
			$_SESSION['montogeneral']=$monto[0][0];

			header("Location: ../Vista/beca/reportegeneral.php?accion=actual");
			break;
		}

		case "filtrogeneralgloria":
			{
	
				$beca->setPrimer($_POST['primer']);
				$_SESSION['desde']=$beca->getPrimer();
				$beca->setSegundo($_POST['segundo']);
				$_SESSION['hasta']=$beca->getSegundo();
				$todos = $beca->becasfiltradasgloria();
				$_SESSION['catabecageneral'] = $todos;
				$monto = $beca->montogeneralgloria();
				$_SESSION['montogeneral']=$monto[0][0];
	
				header("Location: ../Vista/beca/reportegeneral.php?accion=actual");
				break;
			}

		case "filtroespecifico":
			{
	
				$beca->setPrimer($_POST['primer']);
				$_SESSION['desde']=$beca->getPrimer();
				$beca->setSegundo($_POST['segundo']);
				$_SESSION['hasta']=$beca->getSegundo();
				$todos = $beca->becasespecificas();
				$_SESSION['catabecaespecifica'] = $todos;
				
				$monto = $beca->montoespecifico();
				$_SESSION['montogeneral']=$monto;
				
				$montoto = $beca->montototallll();
				$_SESSION['montoto']=$montoto[0][0];
				
				header("Location: ../Vista/beca/reporteespecifico.php?accion=actual");
				break;
			}

			case "filtroespecificogloria":
				{
		
					$beca->setPrimer($_POST['primer']);
					$_SESSION['desde']=$beca->getPrimer();
					$beca->setSegundo($_POST['segundo']);
					$_SESSION['hasta']=$beca->getSegundo();
					$todos = $beca->becasespecificasgloria();
					$_SESSION['catabecaespecifica'] = $todos;
					
					$monto = $beca->montoespecificogloria();
					$_SESSION['montogeneral']=$monto;
					
					$montoto = $beca->montototallllgloria();
					$_SESSION['montoto']=$montoto[0][0];
					
					header("Location: ../Vista/beca/reporteespecifico.php?accion=actual");
					break;
				}

			case "filtroespecificodisciplina":
				{
		
					$beca->setPrimer($_POST['primer']);
					$_SESSION['desde']=$beca->getPrimer();
					$beca->setSegundo($_POST['segundo']);
					$_SESSION['hasta']=$beca->getSegundo();
					$beca->setTercer($_POST['tercer']);
					$_SESSION['dis']=$beca->getTercer();
					$todos = $beca->becasespecificasdisciplina();
					$_SESSION['catabecaespecifica'] = $todos;
					
					$monto = $beca->montoespecificodisciplina();
					$_SESSION['montogeneral']=$monto;
					
					$montoto = $beca->montototalllldisciplina();
					$_SESSION['montoto']=$montoto[0][0];

				
					
					header("Location: ../Vista/beca/reporteespecifico.php?accion=actual");
					break;
				}

				case "filtroespecificodisciplinagloria":
					{
			
						$beca->setPrimer($_POST['primer']);
						$_SESSION['desde']=$beca->getPrimer();
						$beca->setSegundo($_POST['segundo']);
						$_SESSION['hasta']=$beca->getSegundo();
						$beca->setTercer($_POST['tercer']);
						$_SESSION['dis']=$beca->getTercer();
						$todos = $beca->becasespecificasdisciplinagloria();
						$_SESSION['catabecaespecifica'] = $todos;
						
						$monto = $beca->montoespecificodisciplinagloria();
						$_SESSION['montogeneral']=$monto;
						
						$montoto = $beca->montototalllldisciplinagloria();
						$_SESSION['montoto']=$montoto[0][0];
	
					
						
						header("Location: ../Vista/beca/reporteespecifico.php?accion=actual");
						break;
					}
}
ob_end_flush();
?>