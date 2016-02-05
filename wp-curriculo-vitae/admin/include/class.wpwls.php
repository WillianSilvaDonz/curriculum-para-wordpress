<?php 

class WpWls{

	public $id;
	public $table;
	public $link;
	public $tipo;
	public $qtde;

	static $subTables;

	public function RetornaDataIdioma($dataen, $idioma, $datahora = "data") {
	    if($idioma == "en") {
	        if($datahora == "data") {
	            return str_replace("-", "/", substr($dataen, 0, 10));
	        } else {
	            return str_replace("-", "/", $dataen);
	        }
	    } else {
	        if($datahora == "data") {
	            return substr($dataen, 8, 2) . "/" . substr($dataen, 5, 2) . "/" . substr($dataen, 0, 4);
	        } else {
	            return substr($dataen, 8, 2) . "/" . substr($dataen, 5, 2) . "/" . substr($dataen, 0, 4) . " " . substr($dataen, 11, 8);
	        }
	    }
	}

	public function verificaEmail($email){
		/* Verifica se o email e valido */
		if (filter_var($email, FILTER_VALIDATE_EMAIL)){
			/* Obtem o dominio do email */
			list($usuario, $dominio) = explode('@', $email);
			/* Faz um verificacao de DNS no dominio */
			if (checkdnsrr($dominio, 'MX') == 1){
				return TRUE;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}

	public function RetornaDataDBIdioma($datajp, $idioma, $datahora = "data") {
        if($idioma == "en") {
            if($datahora == "data") {
                return substr($datajp, 6, 4) . "/" . substr($datajp, 3, 2) . "/" . substr($datajp, 0, 2);
            } else {
                return substr($datajp, 5, 2) . "/" . substr($datajp, 8, 2) . "/" . substr($datajp, 0, 4) . " " . substr($datajp, 11, 8);
            }
        } else {
            if($datahora == "data") {
                return substr($datajp, 8, 2) . "/" . substr($datajp, 5, 2) . "/" . substr($datajp, 0, 4);
            } else {
                return substr($datajp, 8, 2) . "/" . substr($datajp, 5, 2) . "/" . substr($datajp, 0, 4) . " " . substr($datajp, 11, 8);
            }
        }
    }

    public function exportarxls($export){
		/*
		* Criando e exportando planilhas do Excel
		* /
		*/
		// Definimos o nome do arquivo que será exportado
		$arquivo = 'planilha.xls';
		// Criamos uma tabela HTML com o formato da planilha
		$html = '';
		$html .= '<table>';
		$html .= '<tr>';
		$html .= '<td colspan="3">Planilha teste</tr>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td><b>Coluna 1</b></td>';
		$html .= '<td><b>Coluna 2</b></td>';
		$html .= '<td><b>Coluna 3</b></td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td>L1C1</td>';
		$html .= '<td>L1C2</td>';
		$html .= '<td>L1C3</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td>L2C1</td>';
		$html .= '<td>L2C2</td>';
		$html .= '<td>L2C3</td>';
		$html .= '</tr>';
		$html .= '</table>';
		// Configurações header para forçar o download
		header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
		header ("Cache-Control: no-cache, must-revalidate");
		header ("Pragma: no-cache");
		header ("Content-type: application/x-msexcel");
		header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
		header ("Content-Description: PHP Generated Data" );
		// Envia o conteúdo do arquivo
		echo $html;
		exit;
    	/*
    	$nomearquivo = "CadastroClientes";
	    $hoje=date("Y_m_j");
	    header("Content-type: application/vnd.ms-excel");
	    header("Content-Disposition: attachment; filename=".$nomearquivo."_".$hoje.".xls");
	    header("Pragma: no-cache");
	    header("Expires: 0");
	    
		$fields = mysql_num_fields($export);
		for ($i = 0; $i < $fields; $i++) {
		    $header .= mysql_field_name($export, $i) . "\t";
		}
		print "$header\n";
		while($row = mysql_fetch_row($export)) {
		    $line = '';
		    foreach($row as $value) {
		        if ((!isset($value)) OR ($value == "")) {
		            $value = "\t";
		        } else {
		            $value = str_replace('"', '""', $value);
		            $value = '"' . $value . '"' . "\t";
		        }
		        $line .= $value;
		    }
		    $data = trim($line)."\n";
		    $data = str_replace("\r","",$data);
	        print $data;
		}*/
    }
	
	public function deleteTable($id, $table=""){
		global $wpdb;
	
		$proto = strtolower(preg_replace('/[^a-zA-Z]/','',$_SERVER['SERVER_PROTOCOL'])); //pegando só o que for letra 
		$location = $proto.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		
		$array_url = explode("&", $location);

		$path = $this->removeMsg($location).'&msg=3';
		
		$path = $array_url[0];
				
		foreach($id as $regExcl){
			$delete = "DELETE FROM ".$table. " WHERE id = ".$regExcl." ";
			
			$wpdb->query($delete);
		}
		
		echo "<script>location.href='".$path."".$msg."'</script>";
	}


	public function deleteSub($id, $table=""){
		global $wpdb;
		
		$proto = strtolower(preg_replace('/[^a-zA-Z]/','',$_SERVER['SERVER_PROTOCOL'])); //pegando só o que for letra 
		$location = $proto.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		
		$array_url = explode("&", $location);

		$path = $this->removeMsg($location).'&msg=3';
		
		$path = $array_url[0];

		foreach($id as $regExcl){
		
			$delete = "DELETE FROM ".$table. " WHERE id_cadastro = ".$regExcl." ";
			$wpdb->query($delete);
		}	
		
		echo "<script>location.href='".$path."".$msg."'</script>";
		
	}

	public function removeMsg($link){
		$return  = str_replace('&msg=1','', str_replace('&msg=2','', str_replace('&msg=3','', str_replace('&msg=4','', $link))));		
		return $return;
	}

	public function dataHora($dataHora, $tipo){
		/*
			tipo = 1 igual dia/mês/ano às hora:min:seg
			tipo = 2 igual dia/mês/ano
			tipo = 3 igual hora:min:seg
			tipo = 4 igual dia/mês/ano às hora:min
		*/
		
		$array = explode(" ", $dataHora);
		
		if($tipo==5 || $tipo==6){
			
			$dataArray = explode("/", $array[0]);
			
			$ano = $dataArray[2];
			$mes = $dataArray[1];
			$dia = $dataArray[0];
			
		}else{
			
			$dataArray = explode("-", $array[0]);
			
			$ano = $dataArray[0];
			$mes = $dataArray[1];
			$dia = $dataArray[2];
			
		}
		
		$horaArray = explode(":", $array[1]);
		
		$hora 	= $horaArray[0];
		$min 	= $horaArray[1];
		$seg 	= $horaArray[2];
		
		$anoAtual = date("Y");
		
		switch($tipo){
			case 1:{
				
				$data = $dia . "/" . $mes . "/" . $ano;
				$horario = $hora . ":"  . $min;
				
				$return = $data . " &agrave;s "  . $horario . " hrs";
				
				break;
			}
			case 2:{
				
				$data = $dia . "/" . $mes . "/" . $ano;
				$return = $data;
				
				break;
			}
			case 3:{
				
				$horario = $hora . ":"  . $min . " hrs";
				$return = $data . " &agrave;s "  . $horario;
				
				break;
			}
			case 4:{
				
				$data = $dia . "/" . $mes . "/" . str_replace("20", "", $ano);
				$horario = $hora . ":"  . $min;
				
				$return = $data . "<br/>"  . $horario . " hrs";
				
				break;
			}
			case 5:{
				
				$data = $ano . "-" . $mes . "-" . $dia;
				$return = $data;
				break;
			}
			case 6:{

				$data = $anoAtual - $ano;
				$return = $data;
				break;
			}
			default:{
				
				$return = $dataHora;
				
				break;
			}
		}
		
		return $return;
	}

	public function zerarEdit($table, $id_cadastro){
	
		global $wpdb;

		$sql 	= "SELECT * FROM ".$table." where id_cadastro = '".$id_cadastro."'";
		$query 	= $wpdb->get_results( $sql );

		foreach($query as $k => $v){
			$var = array(
					'edit' 	=> 0,
						  
			);

			$wpdb->update($table, $var, array('id' => @$v->id), $format = null, $where_format = null );
		}
		
		
	}

	public function deletarZero($table, $id_cadastro){
		
		global $wpdb;
		$iT = 0;

		for($iT==0;$iT<count($table);$iT++){

			$sqlCT 		= "SELECT * FROM ".$table[$iT]." where id_cadastro = '".$id_cadastro."' and edit = 0";
			$queryCT 	= $wpdb->get_results( $sqlCT );

			foreach($queryCT as $kCT => $vCT){
				$wpdb->get_row("DELETE FROM ".$table[$iT]." WHERE edit = 0", ARRAY_A);
				#$wpdb->query( $wpdb->prepare( "DELETE FROM ".$tabela." WHERE edit = %d" , array('edit' => 0) ) );
			}

		}
			
	}


}

?>