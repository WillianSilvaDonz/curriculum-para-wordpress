<?php

global $wpdb, $wpcvf, $wls_curriculo, $wls_areas, $wls_curriculo_options;
	
$pg = $_GET['pg'];

foreach ($_POST as $key=>$value){
  ${$key} = $value;
}

$where = "";


if($buscar != ''){
	$where .= " and ( LOWER(a.nome) LIKE  '%".strtolower($buscar)."%' or LOWER(a.descricao) LIKE '%".strtolower($buscar)."%' or LOWER(b.area) LIKE '%".strtolower($buscar)."%')";
}

if($bairro != ''){
	$where .= " and LOWER(a.bairro) LIKE  '%".strtolower($bairro)."%'";
}

if($cidade != ''){
	$where .= " and LOWER(a.cidade) LIKE  '%".strtolower($cidade)."%'";
}

if($estado != ''){
	$where .= " and LOWER(a.estado) LIKE  '%".strtolower($estado)."%'";
}

######### INICIO Paginação
$numreg = 20; // Quantos registros por página vai ser mostrado
if (!isset($pg)) {
	$pg = 0;
}

$inicial = $pg * $numreg;

######### FIM dados Paginação

$sql = "SELECT a.*,
			   b.area
		
		FROM ".$wls_curriculo." a
		
			left join ".$wls_areas." b
				on a.id_area = b.id
		
		where 1=1 $where order by a.nome asc LIMIT $inicial, $numreg ";
		
$query = $wpdb->get_results( $sql );

$sqlRow = "SELECT a.*,
				  b.area
		   
		   FROM ".$wls_curriculo." a
		   
		   		left join ".$wls_areas." b
					on a.id_area = b.id
		   
		   where 1=1 $where order by a.nome asc";
$queryRow = $wpdb->get_results( $sqlRow );
$quantreg = $wpdb->num_rows; // Quantidade de registros pra paginação

	
include( plugin_dir_path( __FILE__ ) . 'classes/estados.php' );

?>

        <form id="wp-curriculo-busca-rapida" method="post">
          <input type="hidden" id="url_ajax" value="<?php echo admin_url( 'admin-ajax.php' ); ?>"  />
          <div class="form-group">
            <div class="controls">
              <input type="text" name="buscar" placeholder="Nome, área de atuação, experiência..." class="form-control" > 
            </div>
          </div>   
          
          
          <div class="form-group">
            <div class="controls">
              <select name="estado" class="form-control" id="estado">
                <option value="">Selecione o estado</option>
                <?php
              
                    $sqlEstado = "SELECT estado FROM ".$wls_curriculo." where 1=1 group by estado order by estado";
                    $queryEstado = $wpdb->get_results( $sqlEstado );
                ?>
                <?php foreach($queryEstado as $kE => $vE){?>
                    <option value="<?php echo $vE->estado?>"><?php echo utf8_encode($estadoArray[$vE->estado])?></option>
                <?php }?>
              </select>
            </div>
          </div>   
          
          <div class="form-group">
            <div class="controls">
              <select name="cidade" class="form-control" disabled="disabled" id="cidade">
                <option value="">Selecione a cidade</option>
              </select>
            </div>
          </div>   
          
          <div class="form-group">
            <div class="controls">
              <select name="bairro" class="form-control" disabled="disabled" id="bairro">
                <option value="">Selecione o bairro</option>
              </select>
            </div>
          </div>   
          <button type="submit" name="novaSenha" class="btn btn-primary">Pesquisar</button>          

        </form>
        <div style="clear:both; height:30px; "></div>
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>Nome</th>
              <th>Descrição</th>
              <th>Área de serviço</th>
              <th width="50" style="text-align:center;">E-mail</th>
              <th width="50" style="text-align:center;">Arquivo</th>
            </tr>
          </thead>
          <tbody>
          <?php 
          $x=1;
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
                <tr>
                  <td><?php echo $v->nome ?></td>
                  
                  <td>
                  	<a class="abrirDescricao" rel="<?php echo $x; ?>" style="cursor:pointer;" >Visualizar</a>
                    <div style="display:none" class="wpcvf_lightbox_content" id="curriculo_<?php echo $x; ?>">
                        <div class="wpcvcontent" style='padding:10px; background:#fff;'>
                           
                            <h1><center><?php echo $v->nome ?></center></h1>
                           
                            <p>
                                <strong>Nome:</strong> <?php echo $v->nome ?><br />
                                <strong>Telefone:</strong> <?php echo $v->telefone ?>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Celular:</strong> <?php echo $v->celular ?><br />
                                <strong>E-mail:</strong> <?php echo $v->email ?><br />
                                <strong>Site/Blog:</strong> <?php echo $v->site_blog ?><br />
                                <strong>Skype:</strong> <?php echo $v->skype ?><br />
                                <strong>Estado cívil:</strong> <?php echo $civil ?>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Idade:</strong> <?php echo $v->idade ?><br />
                                <strong>Área pretendida:</strong> <?php echo $v->area ?><br />
                                <strong>Remuneração:</strong> R$ <?php echo $v->remuneracao ?>
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
                            
                            <img src="<?php echo plugins_url('img/email.png', __FILE__)?>" width="16" height="16" alt="<?php echo $v->email?>" /> 
                            <a href="mailto:<?php echo $v->email?>" target="_blank">
                                <?php echo $v->email?>
                            </a><br />
                            
                            
                            <?php if($v->curriculo != ""){ ?>
                              <a href="<?php echo content_url( 'uploads/curriculos/'.$v->curriculo); ?>" target="_blank" >Baixar currículo</a>
                            <?php  }?>
                        </div>
                    </div>
                  </td>
                  
                  <td><?php echo $v->area ?></td>
                  
                  <td style="text-align:center;"><a href="mailto:<?php echo $v->email?>" target="_blank">
                  <img src="<?php echo plugins_url('img/email.png', __FILE__) ?>" width="16" height="16" alt="<?php echo $v->email?>" /></a></td>
                  
                  <td style="text-align:center;">
                    <?php if($v->curriculo != ""){ ?>
                              <a href="<?php echo content_url( 'uploads/curriculos/'.$v->curriculo); ?>" target="_blank" > <img src="<?php echo plugins_url('../img/page_white_text.png', __FILE__) ?>" width="16" height="16" alt="<?php echo $v->curriculo?>" /></a>
                    <?php  }else{ ?>
                              -
                    <?php  } ?>
                    
                  </td>
                  
                </tr>
                
          <?php $x++; }  ?>
            
          </tbody>
        </table>
        
		<?php if($quantreg > $numreg){
				// Chama o arquivo que monta a paginação. ex: << anterior 1 2 3 4 5 próximo >> 
				include( plugin_dir_path( __FILE__ ) . 'classes/paginacao.php' ); 
			}
		?>

<?php
wp_enqueue_script('scriptJSa', plugins_url('js/script.js', __FILE__));
?>
<div id="black_overlay"></div>