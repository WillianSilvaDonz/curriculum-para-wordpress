<?php /* Template Name: exportxls */ ?>
<?php 
	global $wpdb, $wpcvf, $wls_curriculo, $wls_areas, $wls_curriculo_options;

	if(isset($_SESSION['exportar'])){
		$corriculos = array();
		foreach ($_SESSION['exportar'] as $value) {
			$corriculos[] = $wpdb->get_row("SELECT a.*, b.area FROM ".$wls_curriculo." a inner join ".$wls_areas." b on a.id_area = b.id where a.id = ".(int)$value."");
		}
		if($wpdb->num_rows){
			// Nome do arquivo que será exportado
			$arquivo = 'Relatorio_'.date('dmYHis').'.xls';

			// Tabela HTML com o formato da planilha
			$html = '';
			$html .= '<table border="1">';
			$html .= '<tr>';
			$html .= '<td colspan="7" align="center"><b>Lista de Curriculum - '.get_bloginfo('name').'</b></tr>';
			$html .= '</tr>';

			$html .= '<tr>';
			$html .= '<td><b>Codigo</b></td>';
			$html .= '<td><b>Data Cadastro</b></td>';
			$html .= '<td><b>Nome</b></td>';
			$html .= '<td><b>'.utf8_decode('Area de Serviço').'</b></td>';
			$html .= '<td><b>Bairro</b></td>';
			$html .= '<td><b>Cidade</b></td>';
			$html .= '<td><b>Estado</b></td>';
			$html .= '</tr>';
			foreach ($corriculos as $valores) {
				$html .= '<tr>';
				$html .= '<td>'.utf8_decode($valores->id).'</td>';
				$html .= '<td>'.utf8_decode($valores->data_cadastro).'</td>';
				$html .= '<td>'.utf8_decode($valores->nome).'</td>';
				$html .= '<td>'.utf8_decode($valores->area).'</td>';
				$html .= '<td>'.utf8_decode($valores->bairro).'</td>';
				$html .= '<td>'.utf8_decode($valores->cidade).'</td>';
				$html .= '<td>'.utf8_decode($valores->estado).'</td>';
				$html .= '</tr>';	
			}

			$html .= '</table>';


			// Configurações header para forçar o download
			header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
			header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
			header ("Cache-Control: no-cache, must-revalidate");
			header ("Pragma: no-cache");
			header ("Content-Type: application/vnd.ms-excel; charset=utf-8");
			header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
			header ("Content-Description: PHP Generated Data" );

			// Envia o conteúdo do arquivo
			echo $html;
		}
	}else{

	}
?>