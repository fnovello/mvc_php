<?php
require_once('/models/Curso.php');

class Curso_Dac extends Configuracion{

	function __construct() {
		//$this->set_estado_producto('en uso');
	}

   	public function getListaCursos() {
   		//include '/conec.php';
   		$v_cursos= array();
   		$o_curso;
		$v_sql = "select id_curso, uni_id, descri from CURSOS where rownum < 20 and UNI_ID <> 0";
		//$stmt = oci_parse($conn, $v_sql);
		$stmt = oci_parse(self::$conn, $v_sql);
		oci_execute($stmt, OCI_DEFAULT);
		
		while (oci_fetch($stmt)) {
			// creo objeto y guardo en una lista 
			$o_curso = new Curso();
			$o_curso->setDescripcion(oci_result($stmt, 'DESCRI'));
			$o_curso->setIdCurso(oci_result($stmt, 'ID_CURSO'));
			$o_curso->setUniId(oci_result($stmt, 'UNI_ID'));
			array_push ( $v_cursos , $o_curso );
 		   	//echo oci_result($stmt, 'UNI_ID') . " es ";
    		//echo oci_result($stmt, 'DESCRI') . "<br>\n";
		}
		return $v_cursos;
	}


	public function getCursoId($p_idCurso) {
   		//include '/conec.php';
   		
		/*echo $p_idCurso;
		die();
		*/

		$v_sql = "select id_curso, descri, uni_id, objetivos, crea  from cursos where id_curso=" . $p_idCurso;
		//,crea, objetivos
		//$stmt = oci_parse($conn, $v_sql);
		$stmt = oci_parse(self::$conn, $v_sql);
		oci_execute($stmt, OCI_DEFAULT);
		
		if ($objeto =oci_fetch_object($stmt) ) {

			//var_dump(utf8_encode($objeto->DESCRI));
			$o_curso = new Curso();
			$o_curso->setDescripcion(utf8_encode($objeto->DESCRI));
			$o_curso->setIdCurso(utf8_encode($objeto->ID_CURSO));
			$o_curso->setCrea(utf8_encode($objeto->CREA));
			$o_curso->setUniId(utf8_encode($objeto->UNI_ID));
			$o_curso->setObjetivos(utf8_encode($objeto->OBJETIVOS));
			
		}
		oci_free_statement($stmt);
		return (json_encode($o_curso));
	}
}
?>