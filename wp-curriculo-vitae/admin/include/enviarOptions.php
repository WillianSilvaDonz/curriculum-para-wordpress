<?php
// Devido а quantidade de dados que esta funзгo poderia gerar,
// vamos apenas atualizar a base de dados de 10 em 10 minutos.
// Desta forma, se um usuбrio permanecer no site por 30 minutos,
// serб registado trкs vezes na tabela.
global $wpdb, $wpcvf, $wls_curriculo, $wls_areas, $wls_curriculo_options;
 
$assunto_cadastro 		= @$_POST['assunto_cadastro'];
$mensagem_cadastro 		= @$_POST['mensagem_cadastro'];

$assunto_cadastro_admin			= @$_POST['assunto_cadastro_admin'];
$mensagem_cadastro_admin 		= @$_POST['mensagem_cadastro_admin'];

$nome					= @$_POST['nome']; 
$email					= @$_POST['email']; 

#exit;
// Checamos se nгo existe nenhum registo procedemos

// Registar os IPs na base de dados
$var = array(
  
  'assunto_cadastro'		=> $assunto_cadastro,	
  'mensagem_cadastro'		=> $mensagem_cadastro,
  'assunto_cadastro_admin'		=> $assunto_cadastro_admin,	
  'mensagem_cadastro_admin'		=> $mensagem_cadastro_admin,		
  
  #'tipo_envio' 				=> $tipo_envio,
  'nome' 					=> $nome,
  'email' 					=> $email,
  #'senha' 					=> $senha,
  #'usuario' 				=> $usuario,
  #'smtp_autententicacao' 	=> $smtp_autententicacao,
  #'seguranca'				=> $seguranca,
  #'porta_saida'				=> $porta_saida,
  #'host' 					=> $host,
			
);

$proto = strtolower(preg_replace('/[^a-zA-Z]/','',$_SERVER['SERVER_PROTOCOL'])); //pegando sу o que for letra 

if($_GET['id_formulario']){
	$location = $proto.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."&";
}else{
	$location = $proto.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."?";
}

$id = $queryOp['id'];

if($id){
	echo $qry = $wpdb->update($wls_curriculo_options, $var, array('id' => $id), $format = null, $where_format = null );
}else{
	echo $qry = $wpdb->insert($wls_curriculo_options, $var);
}

$msg = "?msg=1";

if($qry == false && $qry != 0) { 
	
	//$wpdb->show_errors(); 
	
	//$wpdb->print_error();
	
	//exit;
	
} else { 

	
	//@header("Location:?page=configuracao-emails&msg=".$msg."");

}

?>