<?php

global $wpdb, $wpcvf, $wls_curriculo, $wls_areas, $wls_curriculo_options;

$pg = $_GET['pg'];

$buscar = $_POST['buscar'];

$areadeservico = $_POST['areaservico'];

$dataini = $_POST['dataini'];
$datafim = $_POST['datafim'];
$codigo = $_POST['codigo'];

$msg = $_GET['msg'];

$where = "";

if($codigo){
    $where = " and a.id = ".(int)$codigo."";
}else{
    if($buscar){
    	$where .= " and (nome LIKE  '%".$buscar."%' or descricao LIKE '%".$buscar."%')";
    }

    if($dataini){
      $where .= " and data_cadastro >= '".$wpcvf->RetornaDataDBIdioma($dataini,"en")."'";
    }

    if($datafim){
      $where .= " or data_cadastro <= '".$wpcvf->RetornaDataDBIdioma($datafim,"en")."'";
    }

    if($areadeservico and $areadeservico!=0){
      $where .= " and (b.id = ".$areadeservico.")"; 
    }
}

########### Função para excluir registro
if(isset($_POST['excl'])){
    $wpcvf->deleteTable($_POST['excl'], $wls_curriculo );
}
########## Função para exportar registro
if(isset($_POST['exportar'])){
    $_SESSION['exportar'] = $_POST['exportar']; 
    echo '<script>location.href="'.admin_url('admin.php?page=exportxls.php&noheader=true').'"</script>';
}

//######### INICIO Paginação
$numreg = 20; // Quantos registros por página vai ser mostrado
if (!isset($pg)) {
	$pg = 0;
}
$inicial = $pg * $numreg;

//######### FIM dados Paginação

$sql = "SELECT a.*,
			   b.area
		
		FROM ".$wls_curriculo." a
		
			left join ".$wls_areas." b
				on a.id_area = b.id
		
		where 1=1 $where order by a.nome asc LIMIT $inicial, $numreg ";
$query      = $wpdb->get_results( $sql );
$rowsCurr   = $wpdb->num_rows;

$sqlRow = "SELECT a.*,
				  b.area
		   
		   FROM ".$wls_curriculo." a
		   
		   		left join ".$wls_areas." b
					on a.id_area = b.id
		   
		   where 1=1 $where order by a.nome asc";
unset($_POST);
$queryRow = $wpdb->get_results( $sqlRow );
$quantreg = $wpdb->num_rows; // Quantidade de registros pra paginação

wp_enqueue_style('wpcva_bootstrap', plugins_url('../css/bootstrap.min.css', __FILE__));
wp_enqueue_style('wpcva_styleAdminP', plugins_url('css/style.css', __FILE__));
wp_enqueue_style("wpcva_styleP", plugins_url('../css/wp_curriculo_style.css', __FILE__));

wp_enqueue_script('jquery');

wp_enqueue_script('wpcva_bootstrapAdminJS', plugins_url('../js/bootstrap.min.js', __FILE__));
wp_enqueue_script('wpcva_jqueryMaskedinput', plugins_url('../js/jquery.maskedinput-1.1.4.pack.js', __FILE__));
#wp_enqueue_script('wpcva_lightboxjs', plugins_url('../js/wpcvf_lightbox.js', __FILE__));
wp_enqueue_script('wpcva_script', plugins_url('js/script.js', __FILE__));
		
?>
    <div class="container-fluid">
      <h2 style="float:left;">Listagem de currículos</h2>
      
      <a class="bt_novo" href="?page=formulario-admin">Novo cadastro</a>
      
      <div style="clear:both;"></div>
      
  	  <?php if(@$_GET['msg']==2){ ?>

            <div class="alert alert-success" style="text-align:center;">Atualizado com sucesso!</div>	
    
  	  <?php }elseif(@$_GET['msg']==3){ ?>

            <div class="alert alert-success" style="text-align:center;">Registro deletado com sucesso!</div>	
          
      <?php }?>
      <div class="row">
          <form action="?page=lista-de-curriculos-admin" method="POST" accept-charset="utf-8">
              <div class="col-xs-12 col-sm-2 col-md-1 col-lg-1">
                  <input type="text" id="codigo" class="form-control" style="width: 100%;" value="<?php echo (isset($codigo))?$codigo:''; ?>" name="codigo" placeholder="codigo">
              </div>
              <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                  <input type="text" id="buscar" class="form-control" style="width: 100%;" value="<?php echo (isset($buscar))?$busca:''; ?>" name="buscar" placeholder="Buscar por...">
              </div>
              <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                  <?php
                      global $wpdb;
                      $sqlArea = "SELECT * FROM ".$wls_areas." where 1=1";
                      $queryArea = $wpdb->get_results( $sqlArea, ARRAY_A );
                  ?>
                  <select name="areaservico" class="form-control">
                          <option value="0">Todos</option>
                      <?php foreach($queryArea as $kA => $vA){?>
                          <option value="<?php echo $vA['id']?>" <?php echo (isset($areadeservico) and $areadeservico==$vA['id'])?"selected":"";?> ><?php echo $vA['area']?></option>
                      <?php }?> 
                  </select>
              </div>
              <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                  <input type="text" id="dataini" class="form-control" style="width: 100%;" value="<?php echo (isset($dataini))?$dataini:''; ?>" placeholder="Data Cadastro Inicial" name="dataini">
              </div>
              <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                  <input type="text" id="datafim" class="form-control" style="width: 100%;" placeholder="Data Cadastro Final" value="<?php echo (isset($dataini))?$datafim:''; ?>" name="datafim">
              </div>
              <div class="col-xs-12 col-sm-2 col-md-1 col-lg-1">
                  <button class="btn btn-default" type="submit">Buscar</button>
              </div>
          </form>
      </div>
      <div class="link-del-reg" style="margin-top: 20px;">
      	<img src="<?php echo plugins_url('../img/cross.png', __FILE__) ?>" width="16" height="16" alt="Exportar emails em XML." style="margin-bottom: 1px;" />
        <a href="javascript:registros.submit();">Excluir registro</a>
      </div>      
      <div class="link-del-reg" style="float: left; margin-top: 20px;">
        <img src="<?php echo plugins_url('../img/page_white_text.png', __FILE__) ?>" width="16" height="16" alt="Exportar curriculum em XLS." style="margin-bottom: 1px;" />
        <a href="javascript:registros.submit();" class="paraexportar">Exportar Registros</a>
      </div>      
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th width="30" style="text-align:center;"><input type="checkbox" id="checkAllExp" /></th>
            <th>Data Cadastro</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Área de serviço</th>
            <th width="60" style="text-align:center;">E-mail</th>
            <th width="50" style="text-align:center;">Arquivo</th>
            <th width="30" style="text-align:center;">Editar</th>
            <th width="30" style="text-align:center;"><input type="checkbox" id="checkAll" /></th>
          </tr>
        </thead>
        <tbody>
        <form action="?page=lista-de-curriculos-admin" name="registros" id="registros" method="post">
        <?php 
        	$x=0;
          	foreach($query as $k => $v){
            //print_r($v);
			
        			if($v->estado_civil==1){
        				$civil = "Solteiro(a)";
        			}elseif($v->estado_civil==2){
        				$civil = "Viuvo(a)";
        			}elseif($v->estado_civil==3){
        				$civil = "Casado(a)";
        			}elseif($v->estado_civil==4){
        				$civil = "Divorciado(a)";
        			}elseif($v->estado_civil==5){
        				$civil = "Amigável";
        			}
                ?>

              <?php 
                  $periodo = "";
                  if($v->vespertino){
                    $periodo .= "Vespertino";
                  }
                  if($v->matutino){
                    if($v->vespertino){
                        $periodo .= ", Matutino";
                    }else{
                        $periodo .= "Matutino";
                    }
                  }
               ?>
              <tr>
                <td style="text-align:center;">                    
                    <input type="checkbox" name="exportar[]" value="<?php echo $v->id ?>" class="checkEx" />
                </td>
                <td><?php echo $wpcvf->RetornaDataIdioma($v->data_cadastro,"pt"); ?></td>
                <td><?php echo $v->nome ?></td>
                
                <td ><a class="abrirDescricao" rel="<?php echo $x; ?>" style="cursor:pointer;" >Visualizar</a><?php #echo $v->descricao ?></td>
                <div style="display:none" id="curriculo_<?php echo $x; ?>" class="wpcvf_lightbox_content">
                    <div class="wpcvcontent" style='display:none; padding:10px; background:#fff; width:570px;'>
                       
                        <h3><center><?php echo $v->nome ?></center></h3>                        
                        <p>
                            <strong>Nome:</strong> <?php echo $v->nome ?><br />
                            <strong>Telefone:</strong> <?php echo $v->telefone ?>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <strong>Telefone Recados:</strong> <?php echo $v->telefone_recado ?><br>
                            <strong>Celular 1:</strong> <?php echo $v->celular1 ?>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <strong>Celular 2:</strong> <?php echo $v->celular2 ?><br />
                            <strong>E-mail:</strong> <?php echo $v->email ?><br />
                            <strong>Estado cívil:</strong> <?php echo $civil ?>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <strong>Idade:</strong> <?php echo $wpcvf->RetornaDataIdioma($v->idade,"pt"); ?><br />
                            <strong>Área pretendida:</strong> <?php echo $v->area ?><br />
                            <strong>Disponibilidade para Período:</strong> <?php echo $periodo; ?><br />
                        </p>
                        
                        <p>
                            <strong>Endereço:</strong>
                            <?php echo $v->rua?>, <?php echo $v->numero?><br />
                            <?php echo $v->bairro?> - <?php echo $v->cidade?> - <?php echo $v->estado?><br />
                            <strong>CEP:</strong> <?php echo $v->cep?>
                        </p>
                        
                        <p>
                        	<strong>Descrição:</strong><br />
							            <?php echo nl2br($v->descricao) ?>
                        </p>
                        

                        <img src="<?php echo plugins_url('../img/email.png', __FILE__)?>" width="16" height="16" alt="<?php echo $v->email?>" /> 
                        <a href="mailto:<?php echo $v->email?>" target="_blank">
                      		 <?php echo $v->email?>
                        </a><br />
                        
                        <?php if($v->curriculo != ""){ ?>
                          <a href="<?php echo content_url( 'uploads/curriculos/'.$v->curriculo); ?>" target="_blank" >Baixar currículo</a>
                        <?php  }?>
                    </div>
                </div>
                
                <td><?php echo $v->area ?></td>
                
                <td style="text-align:center;"><a href="mailto:<?php echo $v->email?>" target="_blank"><img src="<?php echo plugins_url('../img/email.png', __FILE__) ?>" width="16" height="16" alt="<?php echo $v->email?>" /></a></td>
                
                <td style="text-align:center;">
                  <?php if($v->curriculo != ""){ ?>
                            <a href="<?php echo content_url( 'uploads/curriculos/'.$v->curriculo); ?>" target="_blank" > <img src="<?php echo plugins_url('../img/page_white_text.png', __FILE__) ?>" width="16" height="16" alt="<?php echo $v->curriculo?>" /></a>
                  <?php  }else{ ?>
                            -
                  <?php  } ?>
                  
                </td>
                
                <td style="text-align:center;">
                	
                    <a href="?page=formulario-admin&id_cadastro=<?php echo $v->id?>" >
                      <img src="<?php echo plugins_url('../img/user_edit.png', __FILE__)?>" width="16" height="16" alt="<?php echo $v->nome?>" style="padding:0;" /></a><br />
                    
                </td>
                
                <td style="text-align:center;">                    
                    <input type="checkbox" name="excl[]" value="<?php echo $v->id ?>" class="check" />
                </td>
                
              </tr>
              
        <?php $x++; }  ?>
        </form>  
        </tbody>
      </table>
      
      <span style="position: relative; top: -15px;"><?php echo 'Existe <strong>' . $rowsCurr . '</strong> ' . ($rowsCurr<=1?'currículo cadastrado.':'currículos cadastrados.'); ?></span>

      <div style="clear:both;">

      <?php include( plugin_dir_path( __FILE__ ) . '../classes/paginacao2.php' ); ?>
      
    </div>
	<div id="black_overlay"></div>