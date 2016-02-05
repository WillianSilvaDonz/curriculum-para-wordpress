<?php

global $wpdb, $wpcvf, $wls_curriculo, $wls_areas, $wls_curriculo_options;

if(isset($_POST['cadastrar'])){
  include_once( plugin_dir_path( __FILE__ ) . 'admin/include/enviarCadastro.php' );
  $dadosF = $_POST;
  unset($_POST);
}
?>
  
<div class="container-fluid">

  <?php if(@$_GET['msg']==1){ ?>
  
      <div class="alert alert-success" style="text-align:center; color: #3c763d;">Curriculo cadastrado com sucesso!</div> 
      
  <?php }elseif(@$_GET['msg']==2){ ?>
  
      <div class="alert alert-success" style="text-align:center; color: #3c763d;">Curriculo Atualizado com sucesso!</div> 
  
  <?php }elseif(@$_GET['msg']==3){ ?>
      
      <div class="alert alert-success" style="text-align:center; color: #3c763d;">Conta excluido com sucesso!</div> 
      
  <?php }?>
  
  <form name="wp-curriculo-cadastro" method="post" enctype="multipart/form-data" onsubmit="">
    <input type="hidden" name="tipo" value="site" />
    
  <?php if(@$_SESSION['logado']==1) { ?>
      <input type="hidden" name="mod" value="edit" />
        <input type="hidden" name="id_cadastro" value="<?php echo @$dadosF['id']; ?>" />
        <div class="form-group">
          <div class="controls">
            <span style="font-size:14px;">Excluir a conta</span> <input type="checkbox" name="excluirConta" value="1" style="margin-top:-2px;"> 
          </div>
        </div>
    <?php }else{ ?>
      <input type="hidden" name="mod" value="new" />
        <input type="hidden" name="excluirConta" value="0" />
    <?php }?>
    <div class="row">
      <div class="col-md-6">
          <div class="form-group">
        <?php              
          
                  $sqlArea = "SELECT * FROM ".$wls_areas." where 1=1 group by area";
                  $queryArea = $wpdb->get_results( $sqlArea );
              ?>
              <label class="control-label">Área pretendida:</label>
              
                <select name="id_area" id="id_area" class="stylish-text-input selectseila">
                  <option value="0">Selecione um área</option>
                  <?php foreach($queryArea as $k => $v){?>
                      <option value="<?php echo $v->id?>" data-value="<?php echo $v->validacao;?>" <?php echo @$dadosF['id_area']==$v->id?"selected":"";?> ><?php echo $v->area?></option>
                  <?php }?>
                  <!--<option value="outro" <?php echo @$dadosF['id_area']=="outro"?"selected":"";?> >Outro</option>-->
                </select>
                <?php if ($error['id_area']) { ?>
                    <span class="text-danger"><?php echo $error['id_area']; ?></span>
                <?php } ?>
                <input type="hidden" name="validacaoarea" id="validacaoarea" value="">
            </div>
        </div>
        <div class="col-md-6">
          <div class="form-group" id="campoArea" <?php echo @$dadosF['id_area']!="outro"?"style='display:none;'":"";?>>
                <label class="control-label">Escreva sua área:</label>
                <input type="text" name="area" value="<?php echo @$dadosF['area']; ?>" class="stylish-text-input" style="width:100%;" />
            </div>
        </div>
    </div>
    <div class="form-group">
      <label class="control-label">Nome:</label>
        <input type="text" name="nome" class="stylish-text-input" style="width:100%;" value="<?php echo @$dadosF['nome']?>" > 
        <?php if ($error['nome']) { ?>
            <span class="text-danger"><?php echo $error['nome']; ?></span>
        <?php } ?>
    </div>
    
    <div class="row">
      <div class="col-md-4">
          <div class="form-group">
              <label class="control-label">Sexo: </label>
                <select class="stylish-text-input selectseila" name="sexo">
                  <option></option> 
                  <option value="0"   <?php echo @$dadosF['sexo']=="0"?"selected":"" ?> >Feminino</option>
                  <option value="1"   <?php echo @$dadosF['sexo']=="1"?"selected":""?> >Masculino</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
              <label class="control-label">Estado cívil:</label>
                <select name="estado_civil" class="stylish-text-input selectseila">
                    <option value="0"></option>
                    <option value="1" <?php echo @$dadosF['estado_civil']=="1"?"selected":"";?>>Solteiro(a)</option>
                    <option value="2" <?php echo @$dadosF['estado_civil']=="2"?"selected":"";?>>Viuvo(a)</option>
                    <option value="3" <?php echo @$dadosF['estado_civil']=="3"?"selected":"";?>>Casado(a)</option>
                    <option value="4" <?php echo @$dadosF['estado_civil']=="4"?"selected":"";?>>Divorciado(a)</option>
                    <option value="5" <?php echo @$dadosF['estado_civil']=="5"?"selected":"";?>>Amigável</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
              <label class="control-label">Data de nascimento:</label>
                <input type="text" name="idade" id="idade" value="<?php echo @$dadosF['idade']?>" class="stylish-text-input" style="width:100%;"> 
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-5">
          <div class="form-group">
              <label class="control-label">Telefone:</label>
              <input type="text" name="telefone" id="telefone" value="<?php echo @$dadosF['telefone']?>" class="stylish-text-input" style="width:100%;"> 
              <?php if ($error['telefone']) { ?>
                  <span class="text-danger"><?php echo $error['telefone']; ?></span>
              <?php } ?>      
          </div>
        </div>
        <div class="col-md-5">
          <div class="form-group">
              <label class="control-label">Telefone Recados:</label>
              <input type="text" name="telefonerecado" id="telefone" value="<?php echo @$dadosF['telefone']?>" class="stylish-text-input" style="width:100%;"> 
          </div>
        </div>
    </div>
    <div class="row">
       <div class="col-md-5">
          <div class="form-group">
              <label class="control-label">Celular:</label>
                <input type="text" name="celular1" id="celular1" value="<?php echo @$dadosF['celular1']?>" class="stylish-text-input" style="width:100%;"> 
                <?php if ($error['celular']) { ?>
                  <span class="text-danger"><?php echo $error['celular']; ?></span>
                <?php } ?>
          </div>
        </div>
        <div class="col-md-5">
          <div class="form-group">
              <label class="control-label">Celular Extra:</label>
                <input type="text" name="celular2" id="celular2" value="<?php echo @$dadosF['celular2']?>" class="stylish-text-input" style="width:100%;"> 
            </div>
        </div>
    </div>
    <div class="form-group">
      <label class="control-label">Email:</label>
        <input type="email" name="email" value="<?php echo @$dadosF['email']?>" class="stylish-text-input" style="width:100%;"> 
        <?php if ($error['email']) { ?>
            <span class="text-danger"><?php echo $error['email']; ?></span>
        <?php } ?>  
    </div>
    <div class="row">
        <div class="col-md-5">
          <div class="form-group">
              <label class="control-label">Disponibilidade para Período:</label>
              <br>
              <label>
                  <input type="checkbox" value="1" name="matutino" <?php echo (@$dadosF['matutino'])?'checked':''; ?> >
                  Matutino
              </label>
              <label>
                  <input type="checkbox" value="1" name="vespertino" <?php echo (@$dadosF['vespertino'])?'checked':''; ?> >
                  Vespertino
              </label>
              <?php if ($error['periodo']) { ?>
                  <span class="text-danger"><?php echo $error['periodo']; ?></span>
              <?php } ?>
          </div>
        </div>
        <div class="col-md-5">
          <div class="form-group cep">
              <label class="control-label">CEP:</label>
                <input type="text" name="cep" id="cep" value="<?php echo @$dadosF['cep']?>" class="stylish-text-input" style="width:100%;"/> 
            </div>
        </div>
    </div>
    
    <div class="row">
      <div class="col-md-8">
          <div class="form-group rua">
            <label class="control-label">Rua:</label>
              <input type="text" name="rua" id="rua" value="<?php echo @$dadosF['rua']?>" class="stylish-text-input" style="width:100%;" /> 
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group numero">
              <label class="control-label">Nº:</label>
                <input type="text" name="numero" id="numero" value="<?php echo @$dadosF['numero']?>" class="stylish-text-input" style="width:100%;" /> 
            </div>
        </div>
    </div>
    
    <div class="form-group">
      <label class="control-label">Bairro:</label>
        <input type="text" name="bairro" id="bairro" value="<?php echo @$dadosF['bairro']?>" class="stylish-text-input" style="width:100%;" />
        <?php if ($error['bairro']) { ?>
            <span class="text-danger"><?php echo $error['bairro']; ?></span>
        <?php } ?>
    </div>
    
    <div class="row">
      <div class="col-md-8">
          <div class="form-group cidade">
              <label class="control-label">Cidade:</label>
                <input type="text" name="cidade" id="cidade" value="<?php echo @$dadosF['cidade']?>" class="stylish-text-input" style="width:100%;" /> 
                <?php if ($error['cidade']) { ?>
                    <span class="text-danger"><?php echo $error['cidade']; ?></span>
                <?php } ?>
            </div>
        </div>
        <div class="col-md-2">
          <div class="form-group estado">
              <label class="control-label">Estado:</label>
              
                <input type="text" name="estado" id="estado" value="<?php echo @$dadosF['estado']?>" class="stylish-text-input" style="width:100%;" /> 
              
            </div>
        </div>
    </div>
    
    <div class="form-group">
      <label class="control-label">Conte para nós um pouco de você:</label>
        <textarea class="stylish-textarea contact-textarea" style="width:100%;" name="descricao"><?php echo @$dadosF['descricao']?></textarea>
    </div>
    
  <?php if($dadosF['curriculo']){ ?>
      <input type="hidden" name="curriculoCar" value="<?php echo @$dadoF['curriculo'];?>" />
      <div class="form-group">
          <label class="control-label">Arquivo já salvo:</label>  
            <div class="well">
                <a href="<?php echo content_url( 'uploads/curriculos/'.@$dadosF['curriculo']); ?>" target="_blank" > <?php echo @$_SESSION['curriculo'] ?></a>
            </div>
        </div>
    <?php } ?>
      
    <div class="form-group">
      <label class="control-label">Enviar currículo:</label>
      <div class="controls">
        <input type="file" name="curriculo" id="curriculo" class="input-medium input-block-level">
        <span id="msgFile">Não é permitido enviar arquivo com extensão <b><span id="ext"></span></b>. Extensões permitidas: <strong>pdf</strong>, <strong>doc</strong> e <strong>docx</strong>.</span>  
        <?php if ($error['curriculo']) { ?>
            <span class="text-danger"><?php echo $error['curriculo']; ?></span>
        <?php } ?>
      </div>
    </div>
    
    <div style="clear:both;"></div>
  
  <?php if($dadosF['id']){ ?>
      <button type="submit"  id="cadastrar" name="cadastrar" class="btn btn-primary">Atualizar</button>
    <?php }else{ ?>
      <button type="submit"  id="cadastrar" name="cadastrar" class="btn btn-primary">Cadastrar</button>
    <?php } ?>
      
  </form>
</div>

<?php wp_enqueue_script('scriptAreaJS', plugins_url('js/scriptArea.js', __FILE__)); ?>