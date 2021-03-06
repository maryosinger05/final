<?php
require_once("../Config/ClaseBase.php");
class Modalidad extends ClaseBase
{
	private $modalidad, $id_disciplina;

	public function setModalidad($modalidad)
	{
		$this->modalidad = $modalidad;
	}

	public function getModalidad()
	{
		return $this->modalidad;
	}

	public function setId_disciplina($id_disciplina)
	{
		$this->id_disciplina = $id_disciplina;
	}

	public function getId_disciplina()
	{
		return $this->id_disciplina;
	}

	public function getallactivas()
	{
		$cc=Conexion::getInstance();
		$sql="SELECT * FROM modalidades WHERE modalidades.activo=0";
		$result=$cc->db->prepare($sql);
		$result->execute();
		$trae=$result->fetchAll();
		return ($trae);
	}

	public function RegModalidad()
	{
		$cc=Conexion::getInstance();
		$sql="INSERT INTO $this->tabla (modalidad, id_disciplina) VALUES ('$this->modalidad', $this->id_disciplina)";
		$result=$cc->db->prepare($sql);
		$result->execute();
		return ($result);
	}

	public function consDetModalidad()
	{
		$cc=Conexion::getInstance();
		//$sql="SELECT a.*, b.descrip AS std FROM parroquia AS a INNER JOIN municipio AS b ON b.id=a.id_municipio ORDER BY std";
		$sql="SELECT modalidades.*,disciplinas.disciplina FROM modalidades INNER JOIN disciplinas ON disciplinas.id=modalidades.id_disciplina where modalidades.activo=0";
		$result=$cc->db->prepare($sql);
		$result->execute();
		$trae=$result->fetchAll();
		return ($trae);
	}

	public function consDetModalidad1()
	{
		$cc=Conexion::getInstance();
		//$sql="SELECT a.*, b.descrip AS std FROM parroquia AS a INNER JOIN municipio AS b ON b.id=a.id_municipio ORDER BY std";
		$sql="SELECT modalidades.*,disciplinas.disciplina FROM modalidades INNER JOIN disciplinas ON disciplinas.id=modalidades.id_disciplina where modalidades.activo=1";
		$result=$cc->db->prepare($sql);
		$result->execute();
		$trae=$result->fetchAll();
		return ($trae);
	}

	public function ModModalidad($id)
	{
		$cc=Conexion::getInstance();
		$sql="UPDATE $this->tabla SET modalidad='$this->modalidad', id_disciplina=$this->id_disciplina WHERE id= ".$id;
		$result=$cc->db->prepare($sql);
		$result->execute();
		return ($result);
	}

	public function updatemod()
	{
		$con = Conexion::getInstance();
		$sql = "UPDATE modalidades SET activo=1 WHERE id=$this->id";
		$result = $con->db->prepare($sql);
		$cambio = $result->execute();
		return $cambio;
	}

	public function updatemod1()
	{
		$con = Conexion::getInstance();
		$sql = "UPDATE modalidades SET activo=0 WHERE id=$this->id";
		$result = $con->db->prepare($sql);
		$cambio = $result->execute();
		return $cambio;
	}

	public function updatedis1()
	{
		$con = Conexion::getInstance();
		$sql = "UPDATE disciplinas SET activo=0 WHERE id=$this->id_disciplina";
		$result = $con->db->prepare($sql);
		$cambio = $result->execute();
		return $cambio;
	}
}
?>