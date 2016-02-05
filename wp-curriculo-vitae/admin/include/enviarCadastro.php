<?php
	// Devido à quantidade de dados que esta função poderia gerar,
	// vamos apenas atualizar a base de dados de 10 em 10 minutos.
	// Desta forma, se um usuário permanecer no site por 30 minutos,
	// será registado três vezes na tabela.
	 
global $wpdb, $wpcvf, $wls_curriculo, $wls_areas, $wls_curriculo_options;

$sqlV = "SELECT a.*
		   
		   FROM ".$wls_curriculo." a
		   
		   		where a.id = '".$_POST["id_cadastro"]."'";
			
			
$queryV = $wpdb->get_results( $sqlV );
foreach($queryV as $kV => $vV){
	$dadosV = $vV;
}

foreach ($_POST as $key=>$value){
	${$key} = $value;
}

/*echo "nome: ". $nome. "</br>";
echo "email: ". $email. "</br>";

exit;*/

if($_POST["area"]){
	
	$area 		= $_POST["area"];

	// A Hora a que o usuário acessou
	$current_time = current_time( 'mysql' );
	
	// Checamos se não existe nenhum registo procedemos
	$var2 = array(
	  'area' 		=> $area,
	);
	
	$wpdb->insert($wls_areas, $var2 );
	
	$id_area = $wpdb->insert_id;
}

#echo "<br/>";
#echo "senha atualizado: ".$senha;
//exit;

// A Hora a que o usuário acessou
$current_time = current_time( 'mysql' );

if($_FILES['curriculo']['name']){
			  
	$uploaddir = dirname(__FILE__)."/../../../../../wp-content/uploads/curriculos/";
	
	$tipoArquivo 	= explode(".", $_FILES['curriculo']['name']);
	$nome2 			= str_replace(" ", "", $nome);
	
	if(@$_SESSION['tipo']=="site"){
		
		@unlink("wp-content/uploads/curriculos/".@$_SESSION['curriculo']);
		$_SESSION['curriculo'] = $nome2.".".$tipoArquivo[1];
		
	}elseif(@$_POST['tipo']=="admin"){
		
		@unlink("wp-content/uploads/curriculos/".@$dado['curriculo']);
		$dado['curriculo'] = $nome2.".".$tipoArquivo[1];
		
	}
	
	$curriculo = $nome2.".".$tipoArquivo[1];
	
	#echo $uploaddir. $curriculo;
	#exit;
	move_uploaded_file($_FILES['curriculo']['tmp_name'], $uploaddir. $curriculo);
		
}elseif($_FILES['curriculo']['name'] == "" && $curriculoCar != ""){
	
	$tipoArquivo = explode(".", @$curriculoCar);
	$nomeNovo = $nome2.".".@$tipoArquivo[1];
	
	rename(@$uploaddir.@$curriculoCar, @$uploaddir.@$nomeNovo);
	//exit;
	$curriculo = $nomeNovo;

}else{
	$curriculo = "";
}


###################################################################################################

###################################################################################################

// Checamos se não existe nenhum registo procedemos
#if (!$cpf ) {
  // Registar os IPs na base de dados
  	$error = array();
  	if($id_area){
  		if($validacaoarea == 1){
		  	if(!$nome){
		  		$error['nome'] = "O nome é obrigatorio!";
		  	}

		  	if(!$email){
		  		$error['email'] = "O E-mail é obrigatório!";
		  	}else{
		  		if(!$wpcvf->verificaEmail($email)){
		  			$error['email'] = "O E-mail é invalido!";
		  		}
		  	}
		  	if(!$celular1){
		  		if(!$celular2){
		  			$error['celular'] = "Um Celular é obrigatório!";
		  		}
		  	}

		  	if(!$telefone){
		  		$error['telefone'] = "Um telefone é obrigatório!";
		  	}

		  	if(!$id_area){
		  		$error['id_area'] = "È obrigatório selecionar um cargo";
		  	}

		  	if(!$vespertino){
			  	if(!$matutino){
			  		$error['periodo'] = "È obrigatório selecionar um periodo";
			  	}
		  	}

		  	if(!$cidade){
		  		$error['cidade'] = "Uma cidade é obrigatório!";
		  	}

		  	if(!$bairro){
		  		$error['bairro'] = "Um bairro é obrigatório!";
		  	}

		  	if(!$curriculo){
		  		$error['curriculo'] = "Um Arquivo em PDF ou DOC é obrigatório";
		  	}
	  	}else if ($validacaoarea == 2){
	  		if(!$nome){
		  		$error['nome'] = "O nome é obrigatorio!";
		  	}

		  	if(!$celular1){
		  		if(!$celular2){
		  			$error['celular'] = "Um Celular é obrigatório!";
		  		}
		  	}

		  	if(!$telefone){
		  		$error['telefone'] = "Um telefone é obrigatório!";
		  	}

		  	if(!$id_area){
		  		$error['id_area'] = "È obrigatório selecionar um cargo";
		  	}

		  	if(!$vespertino){
			  	if(!$matutino){
			  		$error['periodo'] = "È obrigatório selecionar um periodo";
			  	}
		  	}
		  	if(!$cidade){
		  		$error['cidade'] = "Uma cidade é obrigatório!";
		  	}

		  	if(!$bairro){
		  		$error['bairro'] = "Um bairro é obrigatório!";
		  	}
	  	}
  	}else{
  		$error['id_area'] = "È obrigatório selecionar um cargo";
  	}

  	$var = array(
		'id_area' 		  => $id_area,
		'nome' 			  => $nome,
		'telefone'		  => $telefone,
		'telefone_recado' => $telefonerecado,
		'celular1'		=> $celular1,
		'celular2'		=> $celular2,
		'email' 		=> $email,
		'idade' 		=> $wpcvf->RetornaDataDBIdioma($idade,"en"),
		'estado_civil'	=> $estado_civil,
		'sexo' 			=> $sexo,
		'matutino'		=> (isset($matutino))?$matutino:0,
		'vespertino'	=> (isset($vespertino))?$vespertino:0,
		'cep' 			=> $cep,
		'rua' 			=> $rua,
		'numero' 		=> $numero,
		'bairro' 		=> $bairro,
		'cidade' 		=> $cidade,
		'estado' 		=> $estado,
		'descricao' 	=> $descricao,
		'curriculo' 	=> $curriculo,
		'data_cadastro'	=> date('Y-m-d H:i:s'),
  	);
  
  $proto = strtolower(preg_replace('/[^a-zA-Z]/','',$_SERVER['SERVER_PROTOCOL'])); //pegando só o que for letra 
  
  if($_GET){
  
	  $location = $proto.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."&";
	  
  }else{
	  
	  $location = $proto.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."?";
	  
  }
  
  	  $path = $wpcvf->removeMsg($location);
  
  if(@$_POST['mod']=="new"){
	  	if(!$error){
	  		$qry = $wpdb->insert($wls_curriculo, $var);
	  		$id_cadastro = $wpdb->insert_id;
	  
	  		include(dirname(__FILE__)."/../../emails/cadastro.php");
	  		include(dirname(__FILE__)."/../../emails/cadastro_admin.php");
	  	}
  }elseif(@$_POST['mod']=="edit"){
  	if(!$error){
	  	if(@$_POST['excluirConta']==1){
		  
		  $qry = $wpdb->query( $wpdb->prepare( "DELETE FROM ".$wls_curriculo." WHERE id = %d" , array('id' => $_SESSION['id_cadastro']) ) );
		  
	  	}else{
	  
		  	if($_POST['id_cadastro']){
				  
				$qry = $wpdb->update($wls_curriculo, $var, array('id' => $_POST['id_cadastro']), $format = null, $where_format = null );		
				$id_cadastro = $_POST['id_cadastro'];
				  
			}
		}
	}
  }
  
  if($qry == false && $qry != 0) { 
		
	  $wpdb->show_errors(); 
	  
	  $wpdb->print_error();
	  
	  exit;
	  
  } else {
	  if(@$_POST['tipo']=="admin"){
		  
		if(@$_POST['mod']=="new"){
			
			$msg = "&msg=1";
	  	  	echo "<script>location.href='?page=formulario-admin&id_cadastro=".@$id_cadastro."".$msg."'</script>";  
			
		  }elseif(@$_POST['mod']=="edit"){
			$msg = "&msg=2";
		  	echo "<script>location.href='?page=formulario-admin&id_cadastro=".@$id_cadastro."".$msg."'</script>";  
			
		  }
		  
	  }elseif(@$_SESSION['logado']==1){
		  if(@$_POST['excluirConta']==1){
			  $msg = "&msg=3";
			  echo "<script>location.href='".$path."&logout=3".$msg."'</script>";
		  }elseif(@$_POST['mod']=="new"){
			  $msg = "&msg=1";
			  echo "<script>location.href='".$path."&logout=1".$msg."'</script>";
		  }elseif(@$_POST['mod']=="edit"){
			  $msg = "&msg=2";
			  echo "<script>location.href='".$path."".$msg."'</script>";
		  }
		  
	  }
	  
  }	
  
?>