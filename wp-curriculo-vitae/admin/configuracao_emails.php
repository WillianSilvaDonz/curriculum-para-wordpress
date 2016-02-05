<?php

global $wpdb, $wpcvf, $wls_curriculo, $wls_areas, $wls_curriculo_options;

$sqlOp = "SELECT * FROM ".$wls_curriculo_options." LIMIT 1";

$queryOp = $wpdb->get_results( $sqlOp, ARRAY_A );
if($_POST){
  $var = array(
      'assunto_cadastro'    => $_POST['assunto_cadastro'], 
      'mensagem_cadastro'   => $_POST['mensagem_cadastro'],
      'assunto_cadastro_admin'  => $_POST['assunto_cadastro_admin'], 
      'mensagem_cadastro_admin' => $_POST['mensagem_cadastro_admin'],
      'nome'                    => $_POST['nome'],
      'email'               => $_POST['email'],
          
  );
  if($queryOp[0]['id']){
      echo $qry = $wpdb->update($wls_curriculo_options, $var, array('id' => $queryOp[0]['id']), $format = null, $where_format = null );
  }else{
      echo $qry = $wpdb->insert($wls_curriculo_options, $var);
  }
  $dadosOp = $_POST;
}else if($queryOp){
  $dadosOp = $queryOp[0];
}

wp_enqueue_style('wpcva_bootstrap', plugins_url('../css/bootstrap.min.css', __FILE__));

wp_enqueue_script('jquery');	
wp_enqueue_script('wpcva_bootstrapJS', plugins_url('../js/bootstrap.min.js', __FILE__));
wp_enqueue_script('wpcva_script', plugins_url('js/script.js', __FILE__));

?>
<div class="container-fluid">
    <h2>Configurações de e-mails</h2>
    <p>Para usar as informações do cadastrado no e-mail usar os comandos abaixo:</p>
    <div class="rows">
    	<div class="col-md-5">
            <strong>@nome</strong><br />
            <strong>@email</strong><br />
            <strong>@cpf</strong><br />
            <strong>@cep</strong><br />
            <strong>@rua</strong><br />
            <strong>@bairro</strong><br />
		</div>
        <div class="col-md-5">
        	<strong>@cidade</strong><br />
            <strong>@estado</strong><br />
            <strong>@numero</strong><br />
            <strong>@telefone</strong><br />
            <strong>@celular</strong><br />
            <strong>@site_blog</strong><br />
            <strong>@skype</strong><br />

        </div>
    </div>
    <div style="clear:both; height:20px;"></div>
	
<?php if(@$_GET['msg']==1){ ?>

  <div class="alert alert-success" style="text-align:center;">Salvo com sucesso!</div>	
  
<?php } ?>

	<form method="post">
		<h3>Configura&ccedil;&otilde;es de e-mail cadastro</h3>
    
        <div class="form-group">
          <label class="control-label cep">Assunto:</label>
          <div class="controls">
            <input type="text" name="assunto_cadastro" id="assunto_cadastro" value="<?php echo $dadosOp['assunto_cadastro'];?>" class="form-control" /> 
          </div>
        </div>
        
        <div class="form-group">
          <label class="control-label cep">Mensagem:</label>
          <div class="controls">
            
            <?php /*<textarea name="mensagem_cadastro" id="mensagem_cadastro" class="form-control" ><?php echo $dadosOp['mensagem_cadastro'];?></textarea> */ ?>
            
            <?php wp_editor( $dadosOp['mensagem_cadastro'], 'wpa_mensagem_cadastro', $settings = array('textarea_name' => mensagem_cadastro) ); ?>
          </div>
        </div>

        <h3>Configura&ccedil;&otilde;es de e-mail cadastro para o admin</h3>
    
        <div class="form-group">
          <label class="control-label cep">Assunto:</label>
          <div class="controls">
            <input type="text" name="assunto_cadastro_admin" id="assunto_cadastro_admin" value="<?php echo $dadosOp['assunto_cadastro_admin'];?>" class="form-control" /> 
          </div>
        </div>
        
        <div class="form-group">
          <label class="control-label cep">Mensagem:</label>
          <div class="controls">
            <?php /*<textarea name="mensagem_cadastro_admin" class="form-control" id="wpcvp_mensagem_cadastro_admin"><?php echo $dadosOp['mensagem_cadastro_admin'];?></textarea> */?>
            
            <?php wp_editor( $dadosOp['mensagem_cadastro_admin'], 'wpcvp_mensagem_cadastro_admin', $settings = array('textarea_name' => mensagem_cadastro_admin) ); ?>
            
          </div>
        </div>
    		
        <h3>Personalizar configura&ccedil;&otilde;es de remetente</h3>
        
        <div class="rows">
        	
            <div class="col-md-5">
            	<div class="form-group">
                  <label class="control-label">Nome:</label>
                  <div class="controls">
                    <input type="text" name="nome" id="email_envio" value="<?php echo $dadosOp['nome'];?>" class="form-control" /> 
                  </div>
                </div>
            </div>
            
            <div class="col-md-5">
            	<div class="form-group">
                  <label class="control-label">E-mail:</label>
                  <div class="controls">
                    <input type="text" name="email" id="email_envio" value="<?php echo $dadosOp['email'];?>" class="form-control" /> 
                  </div>
                </div>
            </div>
            
        </div>
        <div style="clear:both; height:20px;"></div>
        <button type="submit" name="salvar" id="salvar" class="btn btn-primary">Salvar</button>
        
    </form>

    
</div>
