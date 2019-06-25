<?php
	class forum extends usuarios{
		public $con = null;


		public function __construct($con){
			$this->con = $con;

			if(isset($_SESSION['userLogin'])){
				$user = $_SESSION['userLogin'];
				$sql = $this->con->prepare("SELECT * FROM usuarios WHERE usuario = ?");
				$sql->bind_param("s", $user);
				$sql->execute();
				$dados = $sql->get_result()->fetch_assoc();

				$this->nome = $dados['nome'];
				$this->usuario = $dados['usuario'];
				$this->senha = $dados['senha'];
				$this->foto = $dados['foto'];
				$this->email = $dados['email'];
				$this->nivel = $dados['nivel'];
				$this->ativo = $dados['ativo'];
				$this->pontos = $dados['pontos'];
				$this->ativo_chat = $dados['ativo_chat'];
			}
		}

		public function strReplaceolder($str){
			$formattedString = mb_strtolower($str);
			return str_replace(' ', '-', preg_replace('/[`^~\'".,=]/', null, iconv( 'utf-8', 'ASCII//TRANSLIT', $formattedString)));
		}

		public function strReplace($str) {
		    $str = preg_replace('/[áàãâä]/ui', 'a', $str);
		    $str = preg_replace('/[éèêë]/ui', 'e', $str);
		    $str = preg_replace('/[íìîï]/ui', 'i', $str);
		    $str = preg_replace('/[óòõôö]/ui', 'o', $str);
		    $str = preg_replace('/[úùûü]/ui', 'u', $str);
		    $str = preg_replace('/[ç]/ui', 'c', $str);
		    // $str = preg_replace('/[,(),;:|!"#$%&/=?~^><ªº-]/', '_', $str);
		    $str = preg_replace('/[^a-z0-9]/i', '_', $str);
		    $str = preg_replace('/_+/', '_', $str); // ideia do Bacco :)
		    return $str;
		}

		function get_data(){
			date_default_timezone_set('America/Sao_Paulo');
			return date('d-m-Y H:i:s');
		}	

		function calculaDias($diaX,$diaY){
		$data1 = new DateTime($diaX);
		$data2 = new DateTime($diaY); 

		$intervalo = $data1->diff($data2); 


		if($intervalo->y > 1){
		  return $intervalo->y." Anos atrás";
		}elseif($intervalo->y == 1){
		  return $intervalo->y." Ano atrás";
		}elseif($intervalo->m > 1){
		  return $intervalo->m." Meses atrás";
		}elseif($intervalo->m == 1){
		  return $intervalo->m." Mês atrás";
		}elseif($intervalo->d > 1){
		  return $intervalo->d." Dias atrás";
		}elseif($intervalo->d == 1){
		  return $intervalo->d." Dia atrás";
		}elseif($intervalo->h > 1){
		  return $intervalo->h." Horas atrás";
		}elseif($intervalo->h == 1){
		  return $intervalo->h." Hora atrás";
		}elseif($intervalo->i > 1 && $intervalo->i < 59){
		  return $intervalo->i." Minutos atrás";
		}elseif($intervalo->i == 1){
		  return $intervalo->i." Minuto atrás";
		}elseif($intervalo->s < 60 && $intervalo->i <= 0){
		  return $intervalo->s." Segundo atrás";
		}
	}

	public function carrega_pagina($con){
			$url = (isset($_GET['pagina'])) ? $_GET['pagina'] : 'inicio';
			$explode = explode('/', $url);
			$dir = "pags/";
			$ext = ".php";

			if(file_exists($dir.$explode['0'].$ext)){
			  require_once($dir.$explode['0'].$ext);
			}else{
			  echo '<div class="alert alert-danger">Página não encontrada!</div>';
			}
		}

		public function gera_titulo(){
			$titulo = $this->get_siteinfos("titulo");
			$url = (isset($_GET['pagina'])) ? $_GET['pagina'] : 'inicio';
			$explode = explode('/', $url);
			switch($explode['0']):
				case 'inicio':
					$titulo = $titulo." - Inicio";
				break;

				case 'forum':
					$explodeTitulo = explode('/', $explode['1']);
					$titulo = $this->get_titulo_forum($explodeTitulo['0']);
				break;

				case 'topico':
					$explodeTitulo = explode('/', $explode['1']);
					$titulo = $this->get_titulo_topico($explodeTitulo['0']);
				break;

				case 'novo-topico':
					$titulo = "Novo Tópico";
				break;

				case 'mensagens':
					$titulo = "Mensagens";
				break;

				case 'chat':
					$titulo = "Chat";
				break;

				case 'buscar':
					$titulo = "Buscando por: ".$_POST['resultado'];
				break;

				case 'meus-topicos':
					$titulo = "Meus Tópicos";
				break;

				case 'editar-perfil':
					$titulo = "Editar Perfil";
				break;

				case 'perfil':
					$titulo = $this->get_dadosUser($explode['1'], "nome")." - Perfil";
				break;
			endswitch;
			echo $titulo;
		}

		public function get_titulo_forum($id){
			$sql = $this->con->prepare("SELECT * FROM forums WHERE id = ?");
			$sql->bind_param("s", $id);
			$sql->execute();
			$get = $sql->get_result();
			$dados = $get->fetch_assoc();

			return $dados['titulo'];
		}

		public function get_titulo_topico($id){
			$sql = $this->con->prepare("SELECT * FROM topicos WHERE id = ?");
			$sql->bind_param("s", $id);
			$sql->execute();
			$get = $sql->get_result();
			$dados = $get->fetch_assoc();

			return $dados['titulo'];
		}

		public function get_dados_topico($id, $var){
			$sql = $this->con->prepare("SELECT * FROM topicos WHERE id = ?");
			$sql->bind_param("s", $id);
			$sql->execute();
			$get = $sql->get_result();
			$dados = $get->fetch_assoc();

			return $dados[$var];
		}

		public function get_nicon(){
			return str_replace("../", "", $this->get_siteinfos('icon'));
		}


		public function mainmenu(){
			$url = (isset($_GET['pagina'])) ? $_GET['pagina'] : 'inicio';
			$explode = explode('/', $url);
			$explodeTitulo = explode('/', isset($explode['1']));
			$nlogo = str_replace("../", "", $this->get_siteinfos('banner'));

			echo "
			<div class='main-title'>
			<div class='row'>
				<div class='col-sm-8'>
					<img src='{$nlogo}' class='img-fluid'>
				</div>

				<div class='col-sm-4'>
					<ul align='right'>";
						if(isset($_SESSION['userLogin'])){
						echo "
						<li><a href=''><i class='fas fa-home'></i></a></li>
						<li><a href='perfil/{$this->usuario}'><i class='fas fa-user'></i>{$this->badgesSolicitations()}</a></li>
						<li><a href='mensagens/'><i class='fas fa-envelope'></i>{$this->badgesMessages()}</a></li>
						<!--<li><a href='notificacoes'><i class='fas fa-bell'></i>{$this->badgesNotifications()}</a></li>-->
						<li id='logout'><a href='sair/'><i class='fas fa-power-off'></i></a></li>
						<?php ";
						}else{
						echo "
						<li><a href='registro/' data-toggle='tooltip' data-placement='top' title='Cadastrar-se'><i class='fas fa-user-plus'></i></a></li>
						<li data-toggle='tooltip' data-placement='top' title='Entrar'><a href='' data-toggle='modal' data-target='#exampleModal'><i class='fas fa-sign-in-alt'></i></a></li>";
						}
					echo "
					</ul>
				</div>
			</div>
		</div>


	    <div class='main-menu'>
	      	<div class='row'>
		      	<div class='col-sm-9'>
			  		<nav aria-label='breadcrumb'>
				  <ol class='breadcrumb'>
				    <li class='breadcrumb-item'><a href='inicio/'><i class='fas fa-home'></i> {$this->get_siteinfos('titulo')}</a></li>";

				    //if($explode['0'] == "forum" && $explode['1']){
				    	//echo "<li class='breadcrumb-item active' aria-current='page'><i class='fas fa-layer-group'></i> {$this->get_titulo_forum($explodeTitulo['0'])}</li>";
				   // }else if($explode['0'] == "topico"){
				    	//echo "<li class='breadcrumb-item' aria-current='page'><i class='fas fa-arrow-right'></i> Tópico</li>";
				    	//echo "<li class='breadcrumb-item' aria-current='page'><i class='fas fa-layer-group'></i>  {$this->get_titulo_topico($explodeTitulo['0'])}</li>";
				    //}else if($explode['0'] == "novo-topico"){
				    //	echo "<li class='breadcrumb-item' aria-current='page'><i class='fas fa-plus'></i> Novo Tópico</li>";
				   // }
					    
					   echo "
					  </ol>
					</nav>
		      	</div>
		      	<div class='col-sm-3 form-inline'>
		      		<div class='form-group'>
		      			<form method='POST' action='buscar/'>
		      				<input type='text' name='resultado' class='form-control' required>
		      			
		      		</div>
		      		<div class='form-group'>
		      				<button type='submit' class='btn btn-secoundary'><i class='fas fa-search'></i></button>
		      				<input type='hidden' name='env' value='form'>
		      			</form>
		      		</div>
		      		<div class='form-group'>
	      				<button type='button' class='btn btn-secoundary' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' id='btnGroupDrop1'><i class='fas fa-cog'></i></button>
	      				<div class='dropdown-menu' aria-labelledby='btnGroupDrop1'>
					      <!--<a class='dropdown-item' href='#'>Dropdown link</a>
					      <a class='dropdown-item' href='#'>Dropdown link</a>-->
					    </div>
		      		</div>
		      	</div>
	      	</div>
	    </div>
			";
		}

		public function modalLogin(){
			echo "
			<div class='modal fade' id='exampleModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
			  <div class='modal-dialog' role='document'>
			    <div class='modal-content'>
			      <div class='modal-header'>
			        <h5 class='modal-title' id='exampleModalLabel'>Login</h5>
			        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
			          <span aria-hidden='true'>&times;</span>
			        </button>
			      </div>
			      <div class='modal-body'>";
			        $this->logIn();
			        echo "
			      </div>
			    </div>
			  </div>
			</div>";
		}

		public function get_category(){
			$query = $this->con->prepare("SELECT * FROM categorias ORDER BY id ASC");
			$query->execute();
			$get = $query->get_result();

			if($get->num_rows > 0){
				while($dados_categorias = $get->fetch_array()){
					$categoryId = $dados_categorias['id'];
					echo "<div class='table-responsive-xl'>
						<table class='table topics'>
							<tr>
								<th class='title'><i class='fas fa-layer-group'></i> {$dados_categorias['categoria']}</th>
								<th class='center'>Tópicos</th>
								<th class='center'>Respostas</th>
								<th class='center'>Última Resposta</th>
							</tr>";

					$this->get_forums($categoryId);
					echo "</tr></table></div>";

				}
			}
		}

		public function get_forums($id){
			$query = $this->con->prepare("SELECT * FROM forums WHERE categoria = ?");
			$query->bind_param("i", $id);
			$query->execute();
			$get = $query->get_result();

			if($get->num_rows > 0){
				while($dados_forums = $get->fetch_array()){
					switch($dados_forums['status']){
						case 0:
							$class = 'locked';
							$img = 'images/icon-locked.png';
						break;

						case 1:
							$class = 'open';
							$img = 'images/icon-message.png';
						break;
					}
			echo "<tr>
  					<td>
		  				<div class='media'>
		  					<img class='mr-3 {$class}' src='{$img}'>
		  					<div class='media-body'>
		  						<label  style='line-height: normal;'><a href='forum/{$dados_forums['id']}-".strtolower($this->strReplace($dados_forums['titulo']))."'>{$dados_forums['titulo']}</a><br>
		  						<span class='small'>{$dados_forums['descricao']}</span></label>
		  					</div>
		  				</div>
		  			</td>";

		  			$this->get_totaltopics($dados_forums['id'], $id);
		  			$this->get_totalrespostas($dados_forums['id'], $id);
		  			$this->get_lastPost($dados_forums['id'], $id);
		  			
				}
			}	
		}


		public function get_totaltopics($id, $id_categoria){
			$query = $this->con->prepare("SELECT * FROM topicos WHERE forum = ? AND categoria = ?");
			$query->bind_param("ss", $id, $id_categoria);
			$query->execute();
			$total = $query->get_result()->num_rows;

			echo "<td  class='center'>{$total}</td>";
		}

		public function get_totalrespostas($id, $id_categoria){
			$query = $this->con->prepare("SELECT * FROM respostas WHERE id_forum = ? AND id_categoria = ?") OR DIE ($this->con->error);
			$query->bind_param("ss", $id, $id_categoria);
			$query->execute();
			$total = $query->get_result()->num_rows;

			echo "<td class='center'>{$total}</td>";
		}

		public function get_lastPost($id_forum, $id_categoria){
			$query = $this->con->prepare("SELECT * FROM respostas WHERE id_forum = ? AND id_categoria = ? ORDER BY id DESC LIMIT 1");
			$query->bind_param("ss", $id_forum, $id_categoria);
			$query->execute();
			$get = $query->get_result();
			$total = $get->num_rows;
			$dados = $get->fetch_assoc();


			echo "<td class='center'>";
			if($total > 0){
			$sql = $this->con->prepare("SELECT * FROM topicos WHERE id = ?");
			$sql->bind_param("s", $dados['id_topico']);
			$sql->execute();
			$dadosT = $sql->get_result()->fetch_assoc(); 


			$stmt = $this->con->prepare("SELECT * FROM usuarios WHERE usuario = ?");
			$stmt->bind_param("s", $dados['postador']);
			$stmt->execute();
			$dadosU = $stmt->get_result()->fetch_assoc();

			switch ($dadosU['nivel']) {
				case 0:
					$class = 'type-user';
				break;

				case 1:
					$class = 'type-moderator';
				break;

				case 2:
					$class = 'type-admin';
				break;
			}
			echo "<span class='title'><a href='topico/{$dadosT['id']}-".strtolower($this->strReplace($dadosT['titulo']))."'>{$dadosT['titulo']}</a></span>
					<br> por <span class='{$class}'><a href='perfil/{$dadosU['usuario']}'>{$dadosU['nome']}</a></span>, <span class='small'>{$this->calculaDias($dados['data'], $this->get_data())}</span>";
			echo "</td>";
		}
	}

	public function get_forum($titulo){
		$url = (isset($_GET['pagina'])) ? $_GET['pagina'] : 'inicio';
		$explode = explode('/', $url);

		if(isset($explode['2'])){
	    	$pg = (int)$explode['2'];
	    }else{
	    	$pg = 1;
	    }

	    $maximo = 20;
	    $inicio = ($pg * $maximo) - $maximo;
		$stmt = $this->con->prepare("SELECT * FROM topicos WHERE forum = ? ORDER BY fixo DESC, data DESC LIMIT $inicio,$maximo") or die($this->con->error);
		$stmt->bind_param("s", $titulo);
		$stmt->execute();
		$get = $stmt->get_result();
		$total = $get->num_rows;

		$sql = $this->con->prepare("SELECT * FROM forums WHERE id = ?");
		$sql->bind_param("s", $titulo);
		$sql->execute();
		$dadosf = $sql->get_result()->fetch_assoc();



		if($total > 0){
			echo "<div class='table-responsive-xl'> <table class='table topics'>";
			echo "<tr>";
			echo "<th><i class='fas fa-layer-group'></i> Título</th>";
			echo "<th class='options-topics'>Informações";
			if(isset($_SESSION['userLogin']) && $this->nivel >= $dadosf['permissao'] && $dadosf['status'] > 0){
				echo "<a href='novo-topico/{$dadosf['categoria']}/{$titulo}' class='btn btn-primary btn-sm'>Criar Tópico</a> ";
			}
			echo "</th></tr>";
			while($dados = $get->fetch_array()){
				if($dados['resolvido'] == 1){ 
					$nclass =  "class='active-topic'";
					$ntext = "<span class='badge badge-success'>Resolvido</span>";
				}else{
					$nclass = "";
					$ntext = "";
				}

				if($dados['fixo'] == 1){ 
					$ftext = "<span class='badge badge-dark'><i class='fas fa-thumbtack'></i></span>";
				}else{
					$ftext = "";
				}

				if($dados['status'] == 0){ 
					$ctext = "<span class='badge badge-danger'><i class='fas fa-lock'></i></span>";
				}else{
					$ctext = "";
				}

				$qr = $this->con->prepare("SELECT * FROM usuarios WHERE usuario = ?");
				$qr->bind_param("s", $dados['postador']);
				$qr->execute();
				$duser = $qr->get_result()->fetch_assoc();
					
			echo "
				<tr>
				<td {$nclass}>{$ntext} {$ftext} {$ctext}
					<a href='topico/{$dados['id']}-".strtolower($this->strReplace($dados['titulo']))."'>{$dados['titulo']}</a>
					<br><small>Criado por <a href='perfil/{$dados['postador']}'>{$duser['nome']}</a>, {$this->calculaDias($dados['data'], $this->get_data())}</small>
				</td>
				<td>
					<span class='small'>{$this->get_total_respostas($dados['id'], $dados['forum'], $dados['categoria'])} Respostas</span>
					<br>
					<span class='small'>{$dados['visitas']} Visualizações</span>
				</td>
				</tr>";
				}
			echo "</table></div>";
			echo "<ul class='pagination justify-content-center'>";
			$selsql = $this->con->prepare('SELECT id FROM topicos WHERE forum = ?');
			$selsql->bind_param("s", $titulo);
			$selsql->execute();
			$dsql = $selsql->get_result();
			$totalPosts = $dsql->num_rows;

			$pags = ceil($totalPosts/$maximo);
			$links = 2;	
			echo "<li class='page-item'><a class='page-link' href='forum/{$titulo}/1' aria-label='Página Inicial'><span aria-hidden='true'>&laquo;</span></a></li>";
			for($i = $pg - $links; $i <= $pg - 1; $i++){
	      	if($i <= 0){}else{
			echo "<li class='page-item'><a class='page-link' href='forum/{$titulo}/{$i}'>{$i}</a></li>";
			}}
			echo "<li class='page-item'><a class='page-link' href='forum/{$titulo}/{$pg}'>{$pg}</a></li>";
			for($i = $pg + 1; $i <= $pg + $links; $i++){
	    	if($i > $pags){}else{
	    	echo "<li class='page-item'><a class='page-link' href='forum/{$titulo}/{$i}'>{$i}</a></li>";
	    	}}
	    	echo "<li class='page-item'><a class='page-link' href='forum/{$titulo}/{$pags}' aria-label='Última Página'><span aria-hidden='true'>&raquo;</span></a></li>
	      </ul>";
			}else{
				echo "<div class='table-responsive-xl'><table class='table topics'>";
				echo "<tr>";
				echo "<th>Título</th>";
				echo "<th class='options-topics'>Informações";
			if(isset($_SESSION['userLogin']) && $this->nivel >= $dadosf['permissao'] && $dadosf['status'] > 0){
				echo "<a href='novo-topico/{$dadosf['categoria']}/{$titulo}' class='btn btn-primary btn-sm'>Criar Tópico</a>";
			}
			echo "</th></tr>";
				echo "<tr><td class='alert alert-warning' align='center'>Este fórum não possui tópicos</div></td>";
				echo "<td></td></table></div>";
			}
		}

	public function get_total_respostas($id, $id_forum, $id_categoria){
		$stmt = $this->con->prepare("SELECT * FROM respostas WHERE id_topico = ? AND id_forum = ? AND id_categoria = ?");
		$stmt->bind_param("sss", $id, $id_forum, $id_categoria);
		$stmt->execute();
		$get = $stmt->get_result();
		return $get->num_rows;
	}
	
	public function get_idCategoria($id){
		$stmt = $this->con->prepare("SELECT * FROM topicos WHERE forum = ?");
		$stmt->bind_param("s", $id);
		$stmt->execute();
		$get = $stmt->get_result();
		$dados = $get->fetch_assoc();

		return $dados['categoria'];
	}


	public function get_topic($id){
		$stmt = $this->con->prepare("SELECT * FROM topicos WHERE id = ?");
		$stmt->bind_param("s", $id);
		$stmt->execute();
		$get = $stmt->get_result();
		$total = $get->num_rows;

		if($total > 0){
			$dados = $get->fetch_assoc();

			$sql = $this->con->prepare("SELECT * FROM usuarios WHERE usuario = ?");
			$sql->bind_param("s", $dados['postador']);
			$sql->execute();
			$dadosU = $sql->get_result()->fetch_assoc();

			switch ($dadosU['nivel']) {
				case 0:
					$class = 'color: blue;';
					$ntipo = 'Membro';
				break;

				case 1:
					$class = 'color: limegreen;';
					$ntipo = 'Moderador';
				break;

				case 2:
					$class = 'color: red;';
					$ntipo = 'Administrador';
				break;
			}

			if(isset($_SESSION['userLogin'])){
				$valor = 'location.href="curtir/'.$dados['id'].'/'.$dados['curtidas'].'/'.$dados['postador'].'"';	
			}
			

			echo "<div class='table-responsive-xl'>
			<table class='table'>
				<tr>
					<th class='w-15 p-3'>{$dadosU['nome']}</th>
					<th class='w-75 p-3'>Postado {$this->calculaDias($dados['data'], $this->get_data())}</th>
					<th>";

					if($dados['resolvido'] == 0 && $dados['postador'] == $this->usuario || $dados['resolvido'] == 0 && $this->nivel >= 1){
						echo "<div class='btn-group float-right'>
						<a href='#' id='btnGroupDrop1' class='dropdown-toggle nolink ' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='fas fa-ellipsis-v'></i></a>
						<div class='dropdown-menu' aria-labelledby='btnGroupDrop1' style='padding-top: 0px; border-bottom: 0px;'>
						  <a href='change-status/{$dados['id']}/1' class='btn btn-success btn-sm white float-right '><i class='fas fa-check'></i> Marcar como resolvido</a>
						  <a href='editar-topico/{$dados['id']}' class='btn btn-info btn-sm white float-right' style='width: 100%;'><i class='fas fa-edit'></i> Editar Tópico</a>
						  <a href='deletar-topico/{$dados['id']}' class='btn btn-danger btn-sm white float-right' style='width: 100%;'><i class='fas fa-trash'></i> Deletar Tópico</a>";
						  if($this->nivel >= 1 && $dados['status'] == 1){
						  	echo "
						  	<div class='dropdown-divider'></div>
						  	<a href='status-topico/{$dados['id']}/0' class='btn btn-danger btn-sm white float-right' style='width: 100%;'><i class='fas fa-lock'></i> Trancar Tópico</a>";
						  }else if($this->nivel >= 1 && $dados['status'] == 0){
						  	echo "
						  	<div class='dropdown-divider'></div>
						  	<a href='status-topico/{$dados['id']}/1' class='btn btn-success btn-sm white float-right' style='width: 100%;'><i class='fas fa-check'></i> Abrir Tópico</a>";
						  }
						echo "</div></div>";
					}else if($dados['resolvido'] == 1 && $dados['postador'] == $this->usuario || $dados['resolvido'] == 1 && $this->nivel >= 1){
						echo "<div class='btn-group float-right'>
						<a href='#' id='btnGroupDrop1' class='dropdown-toggle nolink ' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='fas fa-ellipsis-v'></i></a>
						<div class='dropdown-menu' aria-labelledby='btnGroupDrop1' style='padding-top: 0px; border-bottom: 0px;'>
						  <a href='change-status/{$dados['id']}/0' class='btn btn-danger btn-sm white float-right'><i class='fas fa-minus'></i> Alterar para não resolvido</a>
						  <a href='editar-topico/{$dados['id']}' class='btn btn-info btn-sm white float-right' style='width: 100%;'><i class='fas fa-edit'></i> Editar Tópico</a>
						  <a href='deletar-topico/{$dados['id']}' class='btn btn-danger btn-sm white float-right' style='width: 100%;'><i class='fas fa-trash'></i> Deletar Tópico</a>";

						  if($this->nivel >= 1 && $dados['status'] == 1){
						  	echo "
						  	<div class='dropdown-divider'></div>
						  	<a href='status-topico/{$dados['id']}/0' class='btn btn-danger btn-sm white float-right' style='width: 100%;'><i class='fas fa-trash'></i> Trancar Tópico</a>";
						  }else if($this->nivel >= 1 && $dados['status'] == 0){
						  	echo "
						  	<div class='dropdown-divider'></div>
						  	<a href='status-topico/{$dados['id']}/1' class='btn btn-success btn-sm white float-right' style='width: 100%;'><i class='fas fa-check'></i> Abrir Tópico</a>";
						  }

						echo "</div></div>";
					}

			echo "</th></tr>
				<tr>
					<td class='left'>
						<img src='{$dadosU['foto']}' class='img-fluid'>
						<p class='small' style='{$class}'>{$ntipo}";
						if($dadosU['ativo'] == 0){
							echo "<br><span class='badge badge-dark size'><s>BANIDO</s></span>";
						}
						echo "<br><span class='badge badge-dark'><i class='fas fa-thumbs-up'></i> {$dadosU['pontos']}</span>";
						$this->get_mynivel($dadosU['pontos'], false);
						$nmensagem = stripslashes($dados['mensagem']);
					echo "</p></td>
					<td class='topic-left'>{$nmensagem}</td>
					<td class='float-right' style='margin-right: 20px'><i class='fas fa-thumbs-up' onclick='"; echo $valor; echo "'></i> <span class='badge badge-dark'>{$dados['curtidas']}</span></td>
				</tr>
		</table></div>
		";
		}else{
			$this->alert(false, false, true, "inicio");
		}
		$this->update_views($dados['id'], $dados['visitas']);
		$this->get_respostas($dados['id'], $dados['forum'], $dados['categoria'], $dados['status'], $dados['titulo']);
		
	}

	public function update_solved($idTopico, $status){
		$sql = $this->con->prepare("SELECT * FROM topicos WHERE id = ?");
		$sql->bind_param("s", $idTopico);
		$sql->execute();

		$get = $sql->get_result();
		$total = $get->num_rows;

		if($total > 0){
			$dados = $get->fetch_assoc();

			if($dados['postador'] == $this->usuario || $this->nivel >= 1){
				$query = $this->con->prepare("UPDATE topicos SET resolvido = ? WHERE id = ?");
				$query->bind_param("ss", $status, $idTopico);
				$query->execute();

				if($query->affected_rows > 0){
					$this->alert(false, false, true, "topico/".$idTopico.'-'.strtolower($this->strReplace($this->get_titulo_topico($idTopico))));
				}else{
					$this->alert(false, false, true, "topico/".$idTopico.'-'.strtolower($this->strReplace($this->get_titulo_topico($idTopico))));
					echo "Erro: ".$query->affected_rows;
				}
			}else{
				$this->alert(false, false, true, "topico/".$idTopico.'-'.strtolower($this->strReplace($this->get_titulo_topico($idTopico))));
			}
		}
	}

	public function update_statusTopic($id_topico, $status){
		if($this->nivel >= 1){
			$sql = $this->con->prepare("UPDATE topicos SET status = ? WHERE id = ?");
			$sql->bind_param("ss", $status, $id_topico);
			$sql->execute();

			if($sql->affected_rows > 0){
				$this->alert(false, false, true, "topico/".$id_topico.'-'.strtolower($this->strReplace($this->get_titulo_topico($id_topico))));
			}else{
				$this->alert(false, false, true, "topico/".$id_topico.'-'.strtolower($this->strReplace($this->get_titulo_topico($id_topico))));
			}
		}else{
			echo "<script>window.history.back(-1);</script>";
		}
	}

	public function delete_topic($idTopico){
		$sql = $this->con->prepare("SELECT * FROM topicos WHERE id = ?");
		$sql->bind_param("s", $idTopico);
		$sql->execute();

		$get = $sql->get_result();
		$total = $get->num_rows;

		if($total > 0){
			$dados = $get->fetch_assoc();

			if($dados['postador'] == $this->usuario){
				$query = $this->con->prepare("DELETE FROM topicos WHERE id = ?");
				$query->bind_param("s", $idTopico);
				$query->execute();

				$qr = $this->con->prepare("DELETE FROM respostas WHERE id_topico = ?");
				$qr->bind_param("s", $idTopico);
				$qr->execute();

				if($query->affected_rows > 0){
					$this->alert(false, false, true, "inicio");
				}else{
					$this->alert(false, false, true, "inicio");
				}
			}else{
				$this->alert(false, false, true, "topico/".$idTopico.'-'.strtolower($this->strReplace($this->get_titulo_topico($idTopico))));
			}
		}
	}


	public function update_views($id, $visitas){
		$newvistas = ($visitas) + 1;

		$sql = $this->con->prepare("UPDATE topicos SET visitas = ? WHERE id = ?");
		$sql->bind_param("ss", $newvistas, $id);
		$sql->execute();

		if($sql->affected_rows > 0){
			return true;
		}else{
			return false;
		}
	}


	public function get_respostas($id_topico, $id_forum, $id_categoria, $status, $titulo){
		$url = (isset($_GET['pagina'])) ? $_GET['pagina'] : 'inicio';
		$explode = explode('/', $url);

		if(isset($explode['2'])){
	    	$pg = (int)$explode['2'];
	    }else{
	    	$pg = 1;
	    }

	    $maximo = 10;
	    $inicio = ($pg * $maximo) - $maximo;
		$stmt = $this->con->prepare("SELECT * FROM respostas WHERE id_topico = ? ORDER BY id ASC LIMIT $inicio,$maximo");
		$stmt->bind_param("s", $id_topico);
		$stmt->execute();
		$get = $stmt->get_result();

		if($get->num_rows > 0){
			while($dados = $get->fetch_array()){

			$sql = $this->con->prepare("SELECT * FROM usuarios WHERE usuario = ?");
			$sql->bind_param("s", $dados['postador']);
			$sql->execute();
			$dadosU = $sql->get_result()->fetch_assoc();
			

			switch ($dadosU['nivel']) {
				case 0:
					$class = 'color: blue;';
					$ntipo = 'Membro';
				break;

				case 1:
					$class = 'color: limegreen;';
					$ntipo = 'Moderador';
				break;

				case 2:
					$class = 'color: red;';
					$ntipo = 'Administrador';
				break;
			}

			if(isset($_SESSION['userLogin'])){
				$valor = 'location.href="curtir_resposta/'.$id_topico.'/'.$dados['id'].'/'.$dados['curtidas'].'/'.$dados['postador'].'"';
			}

			echo "<div class='table-responsive-xl'>
			<table class='table'>
				<tr>
					<th class='w-15 p-3'>{$dadosU['nome']}</th>
					<th class='w-75 p-3'>Postado {$this->calculaDias($dados['data'], $this->get_data())}</th>
					<th>";

					if($dados['postador'] == $this->usuario){
						echo "<div class='btn-group float-right'>
						<a href='#' id='btnGroupDrop1' class='dropdown-toggle nolink ' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='fas fa-ellipsis-v'></i></a>
						<div class='dropdown-menu' aria-labelledby='btnGroupDrop1' style='padding-top: 0px; border-bottom: 0px;'>
						  <a href='editar-resposta/{$dados['id']}' class='btn btn-info btn-sm white float-right' style='width: 100%;'><i class='fas fa-edit'></i> Editar Resposta</a>
						  <a href='deletar-resposta/{$dados['id']}' class='btn btn-danger btn-sm white float-right' style='width: 100%;'><i class='fas fa-trash'></i> Deletar Resposta</a>
						</div>
					</div>";
					}else if($dados['postador'] == $this->usuario || $this->nivel >=1){
						echo "<div class='btn-group float-right'>
						<a href='#' id='btnGroupDrop1' class='dropdown-toggle nolink ' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='fas fa-ellipsis-v'></i></a>
						<div class='dropdown-menu' aria-labelledby='btnGroupDrop1' style='padding-top: 0px; border-bottom: 0px;'>
						  <a href='deletar-resposta/{$dados['id']}' class='btn btn-danger btn-sm white float-right' style='width: 100%;'><i class='fas fa-trash'></i> Deletar Resposta</a>
						</div>
					</div>";
					}

		echo "</th></tr>
				<tr>
					<td>
						<img src='{$dadosU['foto']}' class='img-fluid'><br>
						<p class='small' style='{$class}'>{$ntipo}";
						if($dadosU['ativo'] == 0){
							echo "<br><span class='badge badge-dark size'><s>BANIDO</s></span>";
						}
						echo "<br><span class='badge badge-dark'><i class='fas fa-thumbs-up'></i> {$dadosU['pontos']}</span>";
						$this->get_mynivel($dadosU['pontos'], false);
						$nresposta = stripslashes($dados['resposta']);
					echo "</p></td>
					<td class='topic-left'>{$nresposta}</td>
					<td class='float-right right20px'><i class='fas fa-thumbs-up' onclick='"; echo $valor; echo "'></i> <span class='badge badge-dark'>{$dados['curtidas']}</span></td>
				</tr>
		</table></div>
		";

		}
		echo "<ul class='pagination justify-content-center'>";
		$selsql = $this->con->prepare('SELECT id FROM respostas WHERE id_topico = ?');
		$selsql->bind_param("s", $id_topico);
		$selsql->execute();
		$dsql = $selsql->get_result();
		$totalPosts = $dsql->num_rows;

		$pags = ceil($totalPosts/$maximo);
		$links = 2;	
		echo "<li class='page-item'><a class='page-link' href='topico/{$id_topico}/1' aria-label='Página Inicial'><span aria-hidden='true'>&laquo;</span></a></li>";
		for($i = $pg - $links; $i <= $pg - 1; $i++){
      	if($i <= 0){}else{
		echo "<li class='page-item'><a class='page-link' href='topico/{$id_topico}/{$i}'>{$i}</a></li>";
		}}
		echo "<li class='page-item'><a class='page-link' href='topico/{$id_topico}/{$pg}'>{$pg}</a></li>";
		for($i = $pg + 1; $i <= $pg + $links; $i++){
    	if($i > $pags){}else{
    	echo "<li class='page-item'><a class='page-link' href='topico/{$id_topico}/{$i}'>{$i}</a></li>";
    	}}
    	echo "<li class='page-item'><a class='page-link' href='topico/{$id_topico}/{$pags}' aria-label='Última Página'><span aria-hidden='true'>&raquo;</span></a></li>
      </ul>";
	}

	if($status == 1 && isset($_SESSION['userLogin'])){
			$this->reply_topic($this->usuario, $id_topico, $id_forum, $id_categoria, $titulo);
		}else if($status == 0 && isset($_SESSION['userLogin'])){
			echo "<div class='alert alert-danger'><i class='fas fa-lock'></i> Tópico fechado. Você não pode comentar!</div>";
		}else if($status >= 0 && !isset($_SESSION['userLogin'])){
			echo "<div class='alert alert-danger'><i class='fas fa-lock'></i> Você precisa estar logado para comentar!</div>";
		}

		
  }

	public function reply_topic($postador, $id_topico, $id_forum, $id_categoria, $titulo){
		if($this->ativo == 1){
		echo "<div class='table-responsive-xl'><table class='table'>
				<tr>
				<td class='reply-width'>
					<img src='{$this->foto}' class='img-fluid reply-img'>
				</td>
				<td>
				<form method='POST'>
					<textarea name='resposta' id='editable' class='form-control'></textarea>
					<br><input type='submit' value='Responder' class='btn btn-primary btn-sm float-right'>
					<input type='hidden' name='env' value='resp'>
				</form>
				</td>
				</tr>
			</table></div>
		";}

	if(isset($_POST['env']) && $_POST['env'] == "resp"){
		$resposta = addslashes($_POST['resposta']);
		$data = $this->get_data();
		
		$sql = $this->con->prepare("INSERT INTO respostas (id_topico, id_forum, id_categoria, postador, resposta, data) VALUES (?, ?, ?, ?, ?, ?)");
		$sql->bind_param("ssssss", $id_topico, $id_forum, $id_categoria, $postador, $resposta, $data);
		$sql->execute();

		if($sql->affected_rows > 0){
			$this->alert(false, false, true, "topico/{$id_topico}-".strtolower($this->strReplace($titulo)));
		}else{
			return false;
		}
		}	
	}

	public function update_likes_topicos($id, $curtidas, $usuario){
		$likesAtualizados = ($curtidas) + 1;

		$stmt = $this->con->prepare("UPDATE topicos SET curtidas = ? WHERE id = ?");
		$stmt->bind_param("ss", $likesAtualizados, $id);
		$stmt->execute();
		$this->update_points_reputation($usuario);

		$this->alert(false, false, true, "topico/".$id.'-'.strtolower($this->strReplace($this->get_titulo_topico($id))));
	}


	public function update_likes_respostas($id_topico, $id, $curtidas, $usuario){
		$likesAtualizados = ($curtidas) + 1;

		$stmt = $this->con->prepare("UPDATE respostas SET curtidas = ? WHERE id = ?");
		$stmt->bind_param("ss", $likesAtualizados, $id);
		$stmt->execute();
		$this->update_points_reputation($usuario);

		$this->alert(false, false, true, "topico/".$id_topico.'-'.strtolower($this->strReplace($this->get_titulo_topico($id_topico))));
	}

	public function update_points_reputation($usuario){
		$sql = $this->con->prepare("SELECT * FROM usuarios WHERE usuario = ?");
		$sql->bind_param("s", $usuario);
		$sql->execute();
		$get = $sql->get_result();

		if($get->num_rows > 0){
			$dados = $get->fetch_assoc();
			$pontos = $dados['pontos'];
			$npoints = $dados['pontos'] + ($this->get_siteinfos("pontos_por_curtidas"));

			$qr = $this->con->prepare("UPDATE usuarios SET pontos = ? WHERE usuario = ?");
			$qr->bind_param("ss", $npoints, $usuario);
			$qr->execute();
		}
	}

	public function get_mynivel($pontos, $perfil){
		if($pontos > 0){
			$npontos = $pontos + 1;
		}else{
			$npontos = $pontos;
		}
		
		$sql = $this->con->prepare("SELECT * FROM reputacao_niveis WHERE (SELECT MAX(pontos) FROM reputacao_niveis WHERE pontos < ?) = pontos OR (SELECT MIN(pontos) FROM reputacao_niveis WHERE pontos > ?) = pontos");
		$sql->bind_param("ss", $npontos, $npontos);
		$sql->execute();
		$get = $sql->get_result();
		$total = $get->num_rows;
		$dados = $get->fetch_assoc();

		if($dados['bg_cor'] == null && $dados['bg_cor'] == null){
			$dados['bg_cor'] = "#333";
			$dados['cor'] = "#FFF";
		}

		if($perfil == true){
			echo "<span style='color: {$dados['cor']}; padding: 5px; text-align:center;'>".$dados['nome']."</span>";
		}else if($perfil == false){
			echo "<div style='color: {$dados['cor']}; background-color: {$dados['bg_cor']}; padding: 5px; text-align:center;'>".$dados['nome']."</div>";
		}

		
		
	}

	public function get_chatbox(){

		$sql = $this->con->prepare("SELECT * FROM chatbox");
		$sql->execute();
		$get = $sql->get_result();
		$dados = $get->fetch_assoc();

		echo "
		<div class='chatbox-full'>
		<div class='row'>
				<div class='col-sm-12'>
					<div class='alert alert-success'>
						{$dados['regras']}
					</div>
				</div>
			";


		$query = $this->con->prepare("SELECT * FROM chatbox_mensagens ORDER BY id DESC LIMIT 25");
		$query->execute();
		$getq = $query->get_result();
		$total = $getq->num_rows;
		$style = null;
		$placeholder = null;
		$show = null;
		$col = "col-sm-9";
		if(!isset($_SESSION['userLogin'])){
   			$style = "style='display:none;'";
   			$col = "col-sm-12";
   			$show = "disabled";
   		}else if(isset($_SESSION['userLogin']) && $this->ativo_chat == 0 || $this->ativo == 0){
   			$col = "col-sm-9";
   			$show = "disabled";
   			$placeholder = "placeholder='Você está bloquado.'";

   		}else if(isset($_SESSION['userLogin']) && $this->nivel < $dados['min_permission']){
   			$col = "col-sm-9";
   			$show = "disabled";
   			$placeholder = "placeholder='Usuários com este nível não podem utilizar o chat'";
   		}
		echo "
			<div class='{$col}'>
				<div class='chatbox'>
				<ul>";

		if($total > 0){
			while($resultado = $getq->fetch_array()){
				$id_de = $resultado['id_de'];
				$stmt = $this->con->prepare("SELECT * FROM usuarios WHERE usuario = ?");
				$stmt->bind_param("s", $id_de);
				$stmt->execute();
				$dadost = $stmt->get_result();
				$result = $dadost->fetch_assoc();

				switch($result['nivel']){
					case 0:
						$class = "user";
					break;

					case 1:
						$class = "mod";
					break;

					case 2:
						$class = "admin";
					break;
					}
				
				echo "<li>
						<img src='{$result['foto']}'> 
						<span class='at'>@</span> 
						<span class='{$class}'>{$result['nome']} ";
						if($this->usuario == $resultado['id_de']){ 
							echo "<span class='badge badge-danger' onclick="."location.href='deletar-mensagem/{$resultado['id']}'"."><i class='fas fa-trash'></i></span>";
						}

						if($this->nivel > $result['nivel']){
							echo "<span class='badge badge-danger' onclick="."location.href='deletar-mensagem/{$resultado['id']}'"."><i class='fas fa-trash'></i></span> ";
							echo "<span class='badge badge-danger' onclick="."location.href='mutar-user/{$resultado['id_de']}/0'"."><i class='fas fa-ban'></i></span>";
						}
						echo "</span>
						<span class='message'  data-toggle='tooltip' data-placement='top' title='{$this->calculaDias($this->get_data(), $resultado['data'])}'>{$resultado['mensagem']}</span>
					   </li>";
			}
		}	

		echo "
			</ul>
		</div>
   	</div>";


   		echo "<div class='col-sm-3' "; echo $style; echo ">
   			<form method='POST'>
   				<textarea class='form-control' rows='4' name='msg' "; echo $placeholder; echo $show; echo"></textarea>

   				<div class='options' align='center'>
	   				<button type='submit' class='btn btn-info btn-sm' {$show}>Enviar</button>
	   				<button type='reset' class='btn btn-primary btn-sm'>Limpar</button>
	   				<input type='hidden' name='env' value='envchat'>
   				</div>
   			</form>";


   			if(isset($_POST['env']) && $_POST['env'] == "envchat"){
   				if($_POST['msg']){
   					$msg = addslashes($_POST['msg']);
   					$data = $this->get_data();
   					$id_de = $this->usuario;


   					$update = $this->con->prepare("INSERT INTO chatbox_mensagens (id_de, mensagem, data) VALUES (?, ?, ?)");
   					$update->bind_param("sss", $id_de, $msg, $data);
   					$update->execute();

   					if($update->affected_rows > 0){
   						$this->alert(false, false, true, 'inicio');
   					}

   				}
   			}

   		echo "</div></div></div>";

	}

	public function deleta_mensagem($id){
		$d = $this->con->prepare("SELECT * FROM chatbox_mensagens WHERE id = ?");
		$d->bind_param("s", $id);
		$d->execute();
		$gd = $d->get_result();
		$rd = $gd->fetch_assoc();

		$nivelUser = $this->get_dadosUser($rd['id_de'], "nivel");

		if($this->usuario == $rd['id_de'] || $this->nivel > $nivelUser){
		$sql = $this->con->prepare("DELETE FROM chatbox_mensagens WHERE id = ?");
		$sql->bind_param("s", $id);
		$sql->execute();

		$this->alert(false, false, true, "inicio");
		
		}
	}

	public function getIp(){
		return $_SERVER['REMOTE_ADDR'];
	}

	public function getTime(){
		date_default_timezone_set('America/Sao_Paulo');
		return time() + (60 * 10);
	}

	public function verfica_ip_online(){
		$ip = $this->getIp();

		$sql = $this->con->prepare("SELECT * FROM usuarios_online WHERE ip = ?");
		$sql->bind_param("s", $ip);
		$sql->execute();

		return $sql->get_result()->num_rows;
	}

	public function deleta_linhas(){
		$tempo = $this->getTime() - (60 * 20);
		$sql = $this->con->prepare("DELETE FROM usuarios_online WHERE tempo < ?");
		$sql->bind_param("s", $tempo);
		$sql->execute();
	}

	public function grava_ip_online(){
		$this->deleta_linhas();

		$ip = $this->getIp();
		$tempo = $this->getTime();

		if($this->verfica_ip_online() <= 0){
			if(!isset($_SESSION['userLogin'])){
				$sql = $this->con->prepare("INSERT INTO usuarios_online (tempo, ip) VALUES (?,?)");
				$sql->bind_param("ss", $tempo, $ip);
				$sql->execute();
			}else if(isset($_SESSION['userLogin'])){
				$query = $this->con->prepare("INSERT INTO usuarios_online (tempo, ip, sessao) VALUES (?,?,?)");
				$query->bind_param("sss", $tempo, $ip, $_SESSION['userLogin']);
				$query->execute();
			}
		}else{
			if(!isset($_SESSION['userLogin'])){
				$sql = $this->con->prepare("UPDATE usuarios_online SET tempo = ?, ip = ? WHERE ip = ?");
				$sql->bind_param("sss", $tempo, $ip, $ip);
				$sql->execute();
			}else if(isset($_SESSION['userLogin'])){
				$query = $this->con->prepare("UPDATE usuarios_online SET tempo = ?, ip = ?, sessao = ? WHERE ip = ?");
				$query->bind_param("ssss", $tempo, $ip, $_SESSION['userLogin'], $ip);
				$query->execute();
			}
		}
	}

	public function get_totalMembersOnline(){
		$sql = $this->con->prepare("SELECT * FROM usuarios_online WHERE sessao IS NOT NULL");
		$sql->execute();
		return $sql->get_result()->num_rows;
	}

	public function get_totalVisitantesOnline(){
		$sql = $this->con->prepare("SELECT * FROM usuarios_online WHERE sessao IS NULL");
		$sql->execute();
		return $sql->get_result()->num_rows;
	}

	public function get_numTopics(){
		$sql = $this->con->prepare("SELECT * FROM topicos");
		$sql->execute();
		return $sql->get_result()->num_rows;
	}

	public function get_numrespostas(){
		$sql = $this->con->prepare("SELECT * FROM respostas");
		$sql->execute();
		return $sql->get_result()->num_rows;
	}

	public function get_numusers(){
		$sql = $this->con->prepare("SELECT * FROM usuarios");
		$sql->execute();
		return $sql->get_result()->num_rows;
	}

	public function get_lastuser($valor){
		$sql = $this->con->prepare("SELECT * FROM usuarios ORDER BY id DESC LIMIT 1");
		$sql->execute();
		$get = $sql->get_result();
		$dados = $get->fetch_assoc();

		return $dados[$valor];
	}

	public function get_dadosUser($usuario, $valor){
		$sql = $this->con->prepare("SELECT * FROM usuarios WHERE usuario = ?");
		$sql->bind_param("s", $usuario);
		$sql->execute();
		$get = $sql->get_result();
		$dados = $get->fetch_assoc();

		return $dados[$valor];
	}

	public function get_siteinfos($valor){
		$sql = $this->con->prepare("SELECT * FROM configs_site");
		$sql->execute();
		$get = $sql->get_result();
		$dados = $get->fetch_assoc();

		return $dados[$valor];
	}


	public function rightMenu(){
		echo "
		<div class='col-sm-3'>

    <div class='right-menu-title'><i class='fas fa-globe'></i> Usuários Online</div>
    <div class='right-menu'>
      <ul>
        <li><i class='fas fa-users'></i> Membros <span class='float-right badge badge-primary'>{$this->get_totalMembersOnline()}</span></li>
        <li><i class='fas fa-user-secret'></i> Visitantes <span class='float-right badge badge-dark'>{$this->get_totalVisitantesOnline()}</span></li>
      </ul>
	</div>

  <div class='right-menu-title'><i class='fas fa-chart-bar'></i> Estatísticas</div>
    <div class='right-menu'>
      <ul>
        <li><i class='fas fa-comments'></i> Tópicos <span class='float-right badge badge-dark'>{$this->get_numTopics()}</span></li>
        <li><i class='fas fa-comment-alt'></i> Respostas <span class='float-right badge badge-dark'>{$this->get_numrespostas()}</span></li>
        <li><i class='fas fa-users'></i> Membros <span class='float-right badge badge-dark'>{$this->get_numusers()}</span></li>
        <li><i class='fas fa-user'></i> Último Membro <span class='float-right'><a href='perfil/{$this->get_lastuser('usuario')}' class='text-primary'>{$this->get_lastuser('nome')}</a></span></li>
      </ul>
  </div>

  <div class='right-menu-title'><i class='fas fa-rss-square'></i> Tópicos Recentes</div>
    <div class='right-menu'>";

      $sql = $this->con->prepare("SELECT * FROM topicos ORDER BY id DESC LIMIT 10");
		$sql->execute();
		$get = $sql->get_result();
		$total = $get->num_rows;

		if($total > 0){
			while($dados = $get->fetch_array()){
				switch($this->get_dadosUser($dados['postador'], 'nivel')){
					case "0":
						$class = "type-user";
					break;

					case "1":
						$class = "type-moderator";
					break;

					case "2":
						$class = "type-admin";
					break;

				}

				echo "<div class='media'>
		        <img class='mr-3' width='40' height='40' src='{$this->get_dadosUser($dados['postador'], 'foto')}'> 
		        <div class='media-body'>
		          <a href='topico/{$dados['id']}-".strtolower($this->strReplace($dados['titulo']))."' class='title'>{$dados['titulo']}</a><br>
		          <a href='perfil/{$dados['postador']}' class='{$class}'>{$this->get_dadosUser($dados['postador'], 'nome')}</a>, <span class='data'>{$this->calculaDias($this->get_data(), $dados['data'])}</span>
		        </div>
		      </div>";
			}
		}

  echo "</div>
</div>";
	}


	public function badgesMessages(){
		if(isset($_SESSION['userLogin'])){
			$sql = $this->con->prepare("SELECT * FROM messages_private WHERE id_para = ? AND lido = 0");
			$sql->bind_param("s", $_SESSION['userLogin']);
			$sql->execute();
			$get = $sql->get_result();

			if($get->num_rows > 0){
				$total =  $get->num_rows;
				return "<span class='dbg'>{$total}</span>";	
			}
		}
	}

	public function badgesNotifications(){
		if(isset($_SESSION['userLogin'])){
			$sql = $this->con->prepare("SELECT * FROM notifications WHERE id_para = ? AND lido = 0");
			$sql->bind_param("s", $_SESSION['userLogin']);
			$sql->execute();
			$get = $sql->get_result();

			if($get->num_rows > 0){
				$total =  $get->num_rows;
				return "<span class='dbg'>{$total}</span>";	
			}
		}
	}

	public function badgesSolicitations(){
		if(isset($_SESSION['userLogin'])){
			$sql = $this->con->prepare("SELECT * FROM amigos WHERE id_para = ? AND status = 0");
			$sql->bind_param("s", $_SESSION['userLogin']);
			$sql->execute();
			$get = $sql->get_result();

			if($get->num_rows > 0){
				$total =  $get->num_rows;
				return "<span class='dbg'>{$total}</span>";	
			}
		}
	}

	public function get_topicsbysearch($resultado){
		$url = (isset($_GET['pagina'])) ? $_GET['pagina'] : 'inicio';
		$explode = explode('/', $url);
		if(isset($_POST['resultado']) || isset($explode['2'])){

			if(isset($explode['2'])){
		    	$pg = (int)$explode['2'];
		    }else{
		    	$pg = 1;
		    }

		    $maximo = 25;
		    $inicio = ($pg * $maximo) - $maximo;
			$newresult = $this->con->real_escape_string($resultado);
			$busca = "%{$newresult}%";
			$stmt = $this->con->prepare("SELECT * FROM topicos WHERE (titulo LIKE ?) OR (mensagem LIKE ?) ORDER BY id DESC LIMIT $inicio,$maximo");
			$stmt->bind_param("ss", $busca, $busca);
			$stmt->execute();
			$get = $stmt->get_result();
			$total = $get->num_rows;


		if($total > 0){
			echo "<div class='table-responsive-xl'> <table class='table topics'>";
			echo "<tr>";
			echo "<th><i class='fas fa-layer-group'></i> Título</th>";
			echo "<th class='options-topics'>Informações</span></th>";
			echo "</tr>";
			while($dados = $get->fetch_array()){
				if($dados['resolvido'] == 1){ 
					$nclass =  "class='active-topic'";
					$ntext = "<span class='badge badge-success'>Resolvido</span>";
				}else{
					$nclass = "";
					$ntext = "";
				}

				if($dados['fixo'] == 1){ 
					$ftext = "<span class='badge badge-dark'><i class='fas fa-thumbtack'></i></span>";
				}else{
					$ftext = "";
				}

				if($dados['status'] == 0){ 
					$ctext = "<span class='badge badge-danger'><i class='fas fa-lock'></i></span>";
				}else{
					$ctext = "";
				}

				$qr = $this->con->prepare("SELECT * FROM usuarios WHERE usuario = ?");
				$qr->bind_param("s", $dados['postador']);
				$qr->execute();
				$duser = $qr->get_result()->fetch_assoc();

			echo "
				<tr>
				<td {$nclass}>{$ntext} {$ftext} {$ctext}
					<a href='topico/{$dados['id']}-".strtolower($this->strReplace($dados['titulo']))."'>{$dados['titulo']}</a>
					<br><small>Criado por <a href='perfil/{$dados['postador']}'>{$duser['nome']}</a>, {$this->calculaDias($dados['data'], $this->get_data())}</small>
				</td>
				<td>
					<span class='small'>{$this->get_total_respostas($dados['id'], $dados['forum'], $dados['categoria'])} Respostas</span>
					<br>
					<span class='small'>{$dados['visitas']} Visualizações</span>
				</td>
				</tr>";
				}
			echo "</table></div>";
			echo "<ul class='pagination justify-content-center'>";
			$selsql = $this->con->prepare('SELECT id FROM topicos WHERE (titulo LIKE ?) OR (mensagem LIKE ?)');
			$selsql->bind_param("ss", $busca, $busca);
			$selsql->execute();
			$dsql = $selsql->get_result();
			$totalPosts = $dsql->num_rows;

			$pags = ceil($totalPosts/$maximo);
			$links = 2;	
			echo "<li class='page-item'><a class='page-link' href='buscar/pagina/1' aria-label='Página Inicial'><span aria-hidden='true'>&laquo;</span></a></li>";
			for($i = $pg - $links; $i <= $pg - 1; $i++){
	      	if($i <= 0){}else{
			echo "<li class='page-item'><a class='page-link' href='buscar/pagina/{$i}'>{$i}</a></li>";
			}}
			echo "<li class='page-item'><a class='page-link' href='buscar/pagina/{$pg}'>{$pg}</a></li>";
			for($i = $pg + 1; $i <= $pg + $links; $i++){
	    	if($i > $pags){}else{
	    	echo "<li class='page-item'><a class='page-link' href='buscar/pagina/{$i}'>{$i}</a></li>";
	    	}}
	    	echo "<li class='page-item'><a class='page-link' href='buscar/pagina/{$pags}' aria-label='Última Página'><span aria-hidden='true'>&raquo;</span></a></li>
	      </ul>";
			}else{
				echo "<div class='table-responsive-xl'><table class='table topics'>";
				echo "<tr>";
				echo "<th>Título</th>";
				echo "<th class='options-topics'>Informações</th>";
				echo "</tr>";
				echo "<tr><td class='alert alert-warning' align='center'>Nenhum resultado encontrado</div></td>";
				echo "<td></td></table></div>";
			}
		}
	}	

	public function new_topic($idforum, $idcategoria){
		$sql = $this->con->prepare("SELECT * FROM forums WHERE id = ?");
		$sql->bind_param("s", $idforum);
		$sql->execute();
		
		$dadosf = $sql->get_result()->fetch_assoc();
		if(isset($_SESSION['userLogin']) && $this->nivel >= $dadosf['permissao'] && $dadosf['status'] == 1){
			$forumid = $idforum;
			$categoriaid = $idcategoria;
				echo "
					<form method='POST' class='form-newtopic'>
						<input type='text' name='titulo' class='form-control' placeholder='Título'><br>
						<textarea id='editable' name='post' class='form-control' rows='10'></textarea><br>
						<p align='right'><input type='submit' value='publicar' class='btn btn-primary btn-lg'></p>
						<input type='hidden' name='env' value='post'>
					</form>";
				if(isset($_POST['env']) && $_POST['env'] == "post"){
						if($_POST['titulo'] && $_POST['post']){
							$titulo = $_POST['titulo'];
							$post = addslashes($_POST['post']);
							$data = $this->get_data();


							$sql = $this->con->prepare("INSERT INTO topicos (forum, categoria, titulo, mensagem, postador, data) VALUES (?, ?, ?, ?, ?, ?)");
							$sql->bind_param("ssssss", $forumid, $categoriaid, $titulo, $post, $this->usuario, $data);
							$sql->execute();

							if($sql->affected_rows > 0){
								$this->alert(false, false, true, "topico/".$sql->insert_id.'-'.strtolower($this->strReplace($titulo)));
							}else{
								echo "Erro ao enviar...".$sql->error;
							}
						}else{
							echo "<div class='alert alert-danger'>Preencha todos os campos!</div>";
						}
				}
		}else{
			echo "<script>window.history.back(-1);</script>";
		}
	}	


public function edit_topic($id_topico){
		$sql = $this->con->prepare("SELECT * FROM topicos WHERE id = ?");
		$sql->bind_param("s", $id_topico);
		$sql->execute();
		
		$dadosf = $sql->get_result()->fetch_assoc();
		if(isset($_SESSION['userLogin']) && $this->usuario == $dadosf['postador'] || isset($_SESSION['userLogin']) && $this->nivel >= 1){
			//$forumid = $idforum;
			//$categoriaid = $idcategoria;
			$nmensagem = stripslashes($dadosf['mensagem']);
				echo "
					<form method='POST' class='form-newtopic'>
						<input type='text' name='titulo' class='form-control' placeholder='Título' value='{$dadosf['titulo']}'><br>
						<textarea id='editable' name='post' class='form-control' rows='10'>{$nmensagem}</textarea><br>
						<p align='right'><input type='submit' value='Alterar Tópico' class='btn btn-primary btn-lg'></p>
						<input type='hidden' name='env' value='post'>
					</form>";
				if(isset($_POST['env']) && $_POST['env'] == "post"){
						if($_POST['titulo'] && $_POST['post']){
							$titulo = $_POST['titulo'];
							$post = addslashes($_POST['post']);
							$data = $this->get_data();


							$sql = $this->con->prepare("UPDATE topicos SET titulo = ?, mensagem = ? WHERE id = ?");
							$sql->bind_param("sss", $titulo, $post, $id_topico);
							$sql->execute();

							if($sql->affected_rows > 0){
								$this->alert(false, false, true, "topico/".$id_topico.'-'.strtolower($this->strReplace($this->get_titulo_topico($id_topico))));
							}else{
								echo "Erro ao alterar...".$sql->error;
							}
						}else{
							echo "<div class='alert alert-danger'>Preencha todos os campos!</div>";
						}
				}
		}else{
			echo "<script>window.history.back(-1);</script>";
		}
	}


	public function editar_resposta($id_resposta){
		$sql = $this->con->prepare("SELECT resposta,postador,id_topico FROM respostas WHERE id = ?");
		$sql->bind_param("s", $id_resposta);
		$sql->execute();
		$get = $sql->get_result();
		$total = $get->num_rows;

		if($total > 0){
			$dados = $get->fetch_assoc();
			if($this->usuario == $dados['postador']){
				$nresposta = stripslashes($dados['resposta']);
				echo "
					<form method='POST' class='form-newtopic'>
						<textarea id='editable' name='post' class='form-control' rows='10'>{$dados['resposta']}</textarea><br>
						<p align='right'><input type='submit' value='Editar Resposta' class='btn btn-primary btn-lg'></p>
						<input type='hidden' name='env' value='post'>
					</form>";
				if(isset($_POST['env']) && $_POST['env'] == "post"){
					if($_POST['post']){
						$publicacao = addslashes($_POST['post']);

						$query = $this->con->prepare("UPDATE respostas SET resposta = ? WHERE id = ?");
						$query->bind_param("ss", $publicacao, $id_resposta);
						$query->execute();

						if($query->affected_rows > 0){
							$this->alert(false, false, true, "topico/".$dados['id_topico'].'-'.strtolower($this->strReplace($this->get_titulo_topico($dados['id_topico']))));
						}else{
							$this->alert(false, false, true, "topico/".$dados['id_topico'].'-'.strtolower($this->strReplace($this->get_titulo_topico($dados['id_topico']))));
						}
					}else{
						echo "<div class='alert alert-danger'>Preencha todos os campos!</div>";
					}
				}
			}else{
				echo "<script>window.history.back(-1);</script>";
			}
		}
	}

	public function deletar_resposta($id_resposta){
		$sql = $this->con->prepare("SELECT postador, id_topico FROM respostas WHERE id = ?");
		$sql->bind_param("s", $id_resposta);
		$sql->execute();
		$get = $sql->get_result();
		$total = $get->num_rows;

		if($total > 0){
			$dados = $get->fetch_assoc();

			if($dados['postador'] == $this->usuario || $this->nivel >= 1){
				$qr = $this->con->prepare("DELETE FROM respostas WHERE id = ?");
				$qr->bind_param("s", $id_resposta);
				$qr->execute();

				if($qr->affected_rows > 0){
					$this->alert(false, false, true, "topico/".$dados['id_topico'].'-'.strtolower($this->strReplace($this->get_titulo_topico($dados['id_topico']))));
				}else{
					$this->alert(false, false, true, "topico/".$dados['id_topico'].'-'.strtolower($this->strReplace($this->get_titulo_topico($dados['id_topico']))));
				}
			}
		}
	}

	public function calculaIdade($nascimento){
		date_default_timezone_set('America/Sao_Paulo');
		$dataAtual = date('d-m-Y');
		$data1 = new DateTime($dataAtual);
		$data2 = new DateTime($nascimento);
		$intervalo = $data1->diff( $data2 );
		return $intervalo->y;
	}


	public function total_CountsK($total){
		if($total >= 1000){
			$number = number_format($total,1,',','.');
			return round($number, 1)."K";
		}else if($total < 1000){
			return $total;
		}
	    
	}

	public function get_totalTopicsByUser($postador, $option){
		$sql = $this->con->prepare("SELECT id FROM {$option} WHERE postador = ?");
		$sql->bind_param("s", $postador);
		$sql->execute();
		$result = $sql->get_result()->num_rows;
		return str_replace(".", ",", $this->total_CountsK($result));
	}

	public function verifi_ifisFriend($id_de, $id_para){
		if(isset($_SESSION['userLogin'])){
		$sql = $this->con->prepare("SELECT * FROM amigos WHERE (id_de = ? AND id_para = ?) OR (id_para = ? AND id_de = ?)");
		$sql->bind_param("ssss", $id_de, $id_para, $id_de, $id_para);
		$sql->execute();
		$get = $sql->get_result();
		$total = $get->num_rows;
		if($total > 0){
			$dados = $get->fetch_assoc();

			if($dados['status'] == 1){
				echo "<a href='change-invites/{$dados['id_para']}/2/true' class='btn btn-danger btn-sm'><i class='fas fa-user-plus'></i> Desfazer amizade</a> ";
			}

			if($dados['id_para'] == $this->usuario && $dados['id_de'] == $this->usuario && $dados['status'] == 0){
				echo "<a href='change-invites/{$dados['id_para']}/2/true' class='btn btn-warning btn-sm'><i class='fas fa-user-plus'></i> Cancelar Solicitação</a> ";
			}

			if($dados['id_de'] == $this->usuario && $dados['id_para'] == $this->usuario && $dados['status'] == 0){
				echo "<a href='change-invites/{$dados['id_para']}/1' class='btn btn-info btn-sm'><i class='fas fa-user-plus'></i> Aceitar Solicitação</a> ";
				echo "<a href='change-invites/{$dados['id_para']}/0' class='btn btn-danger btn-sm'><i class='fas fa-user-minus'></i> Recusar Solicitação</a>";
			}
			
		}else if($total <= 0 && $id_para != $this->usuario){
			echo "<a href='add-friend/{$id_para}' class='btn btn-success btn-sm'><i class='fas fa-user-plus'></i> Enviar Solicitação</a>";
		}}
	}

	public function friends_send_solicitation($id_para){
		$sql = $this->con->prepare("INSERT INTO amigos (id_de, id_para) VALUES (?, ?)");
		$sql->bind_param("ss", $this->usuario, $id_para);
		$sql->execute();

		if($sql->affected_rows > 0){
			$this->alert(false, false, true, 'invites/');
		}else{
			$this->alert(false, false, true, 'invites/');
		}
	}


	public function get_userprofile($user){
	$sql = $this->con->prepare("SELECT * FROM usuarios WHERE usuario = ?");
	$sql->bind_param("s", $user);
	$sql->execute();
	$get = $sql->get_result();
	$total = $get->num_rows;

	if($total > 0){
		$dados = $get->fetch_assoc();
		$status = $this->get_userstatus($dados['usuario']);

		switch($status){
			case 0:
				$status = "<span class='badge badge-secoundary'>Offline</span>";
			break;

			case 1:
				$status = "<span class='badge badge-success'>Online</span>";
			break;

			case 2:
				$status = "<span class='badge badge-success'>Online</span>";
			break;
		}

		if(is_null($dados['sexo'])){
			$dados['sexo'] = "<span class='text-muted'>Não informado</span>";
		}else if($dados['sexo'] == 0){
			$dados['sexo'] = "<i class='fas fa-mars'></i> Masculino";
		}else if($dados['sexo'] == 1){
			$dados['sexo'] = "<i class='fas fa-venus'></i> Feminino";
		}

		switch($dados['nivel']){
			case 0:
				$nivel = "<span class='type-user'>Membro</span>";
			break;

			case 1:
				$nivel = "<span class='type-moderator'>Moderador</span>";
			break;

			case 2:
				$nivel = "<span class='type-admin'>Administrador</span>";
			break;
		}

		if($dados['nascimento'] == null){
			 $nascimento = "<span class='text-muted'>Não informado</span>";
			 $idade = "<span class='text-muted'>Não informado</span>";
		}else{
			$nascimento = str_replace("-", "/", $this->inverteData($dados['nascimento']));
			$idade = $this->calculaIdade($dados['nascimento'])." Anos";
		}

		if($dados['pais'] == null){
			 $dados['pais'] = "<span class='text-muted'>Não informado</span>";
		}else{
			$dados['pais'] = $dados['pais'];
		}

		if($dados['estado'] == null){
			 $dados['estado'] = "<span class='text-muted'>Não informado</span>";
		}else{
			$dados['estado'] = $dados['estado'];
		}

		if($dados['sobre'] == null){
			 $dados['sobre'] = "<span class='text-muted'>Não informado</span>";
		}else{
			$dados['sobre'] = $dados['sobre'];
		}

		$totalSkill = null;
		$explodeSkill = null;

		if($dados['skills'] == null){
			 $dados['skills'] = "<span class='text-muted'>Não informado</span>";
		}else{
			$explodeSkill = explode(',', $dados['skills']);
			$totalSkill = count($explodeSkill);
		}

		if($dados['hobbies'] == null){
			 $dados['hobbies'] = "<span class='text-muted'>Não informado</span>";
		}else{
			$dados['hobbies'] = $dados['hobbies'];
		}

		switch($dados['ativo_chat']){
			case 0:
				$ativo_chat = "<a class='dropdown-item success' href='mutar-user/{$dados['usuario']}/1'><i class='fas fa-user-check'></i> Permitir no chat</a>";
			break;

			case 1:
				$ativo_chat = "<a class='dropdown-item danger' href='mutar-user/{$dados['usuario']}/0'><i class='fas fa-user-lock'></i> Bloquar do chat</a>";
			break;
		}

		switch($dados['ativo']){
			case 0:
				$ativo = "<a class='dropdown-item success' href='banir-user/{$dados['usuario']}/1'><i class='fas fa-user-check'></i> Desbanir</a>";
				$dados['nome'] = "<s>".$dados['nome']."</s> <span class='badge badge-dark'>BANIDO</span>";
			break;

			case 1:
				$ativo = "<a class='dropdown-item danger' href='banir-user/{$dados['usuario']}/0'><i class='fas fa-user-lock'></i>  Banir do fórum</a>";
			break;
		}

		echo "
	<div class='perfil-content'>
	<div class='profile-nome'>{$dados['nome']}</div>
	<div class='profile'>
		<ul>
			<li class='foto'><img src='{$dados['foto']}' class='img-fluid'></li>
			<li class='bio'>
				<h3>{$dados['nome']}</h3>
				<p>
					<small>Cadastrado: {$this->calculaDias($this->get_data(), $dados['data_cadastro'])}</small><br>
					<small>Atualmente: {$status}</small> 
				</p>
				<span class='float-right'>";
				echo $this->verifi_ifisFriend($this->usuario, $dados['usuario']);
				if($user != $this->usuario){
					echo "<a class='btn btn-primary btn-sm' href='conversa/{$dados['usuario']}'><i class='fas fa-comments'></i>  Enviar Mensagem</a>";
				}

				if($user == $this->usuario){
					echo "<a class='btn btn-info btn-sm' href='editar-perfil/'><i class='fas fa-user-edit'></i> Editar Perfil</a>";
				}
				
					if(isset($_SESSION['userLogin']) && $this->nivel >=1){
						if($this->nivel >= $dados['nivel'] && $user != $this->usuario){
						echo "
						<button class='btn btn-success btn-sm dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' id='btnGroupDrop1'>
						<i class='fas fa-user-cog'></i> Gerenciar
					</button>
					<div class='dropdown-menu' aria-labelledby='btnGroupDrop1'>
						{$ativo_chat}
						{$ativo}
				    </div>";
					}}
					
				echo "</span>
			</li>
		</ul>

		<div class='perfil-stats'>
			<div class='profile-nome'>Estatísticas</div>
			<div class='row'>
				<div class='col-sm-4 text-center'>
	                <h2><strong> {$this->get_totalTopicsByUser($dados['usuario'], 'topicos')} </strong></h2>                    
	                <p><small>Tópicos</small></p>
	            </div>   

	            <div class='col-sm-4 text-center'>
	                <h2><strong> {$this->get_totalTopicsByUser($dados['usuario'], 'respostas')}  </strong></h2>                    
	                <p><small>Respostas</small></p>
	            </div>  

	            <div class='col-sm-4 text-center'>
	                <h2><strong> {$dados['pontos']} </strong></h2>                    
	                <p><small>Pontos</small></p>
	            </div>      
			</div>
		</div>";

			if($user == $this->usuario){
			echo "<div class='perfil-stats'>
					<div class='profile-nome'>Atividade Recente</div>
					<div class='row'>
						<div class='col-sm-6'>
							<h5 align='center'>Tópicos Recentes"; 
							if($user == $this->usuario){
								echo " <a href='meus-topicos/' class='btn btn-info btn-sm' style='color: #FFF; border-radius: 0px;'> Ver todos</a>";
							}
							echo "</h5><hr>
							<ul class='recents-actives-profile'>";
							$this->get_lastsTopicsUser($user);
							echo "</ul>
						</div>

						<div class='col-sm-6'>
							<h5 align='center'>Últimas Respostas</h5><hr>
							<ul class='recents-actives-profile'>";
							$this->get_lastsReplysUser($user);
							echo "</ul>
						</div>
					</div>
				</div>";
			}

		echo "<div class='table-responsive-lx'>
			<table class='table'>
				<tr>
					<th>Informações</th>
					<th></th>
				</tr>

				<tr>
					<td align='left' class='title'>Grupo:</td>
					<td align='left'>{$nivel}</td>
				</tr>

				<tr>
					<td align='left' class='title'>Nível:</td>
						<td align='left'>"; 
						echo $this->get_mynivel($dados['pontos'], true); 
		 				echo "</td>
				</tr>

				<tr>
					<td align='left' class='title'>Idade:</td>
					<td align='left'>{$idade}</td>
				</tr>

				<tr>
					<td align='left' class='title'>Nascimento:</td>
					<td align='left'>{$nascimento}</td>
				</tr>

				<tr>
					<td align='left' class='title'>Sexo:</td>
					<td align='left'>{$dados['sexo']}</td>
				</tr>

				<tr>
					<td align='left' class='title'>País:</td>
					<td align='left'>{$dados['pais']}</td>
				</tr>

				<tr>
					<td align='left' class='title'>Localização:</td>
					<td align='left'>{$dados['estado']}</td>
				</tr>

				<tr>
					<td align='left' class='title'>Sobre:</td>
					<td align='left'>{$dados['sobre']}</td>
				</tr>

				<tr>
					<td align='left' class='title'>Hobbies:</td>
					<td align='left'>{$dados['hobbies']}</td>
				</tr>

				<tr>
					<td align='left' class='title'>Skills:</td>
					<td align='left'>";
					for($i = 0; $i<$totalSkill; $i++){
						echo "<span class='badge badge-info'>".$explodeSkill[$i]."</span> ";
					}
				echo "</td>
				</tr>
			</table>

			<div class='perfil-stats'>
			<div class='profile-nome'>Amigos</div>";
				echo $this->get_listfriends($user);
			echo "</div>
		</div>
	</div>
</div>";
		}
	}

	public function get_mytopics(){
		$sql = $this->con->prepare("SELECT * FROM topicos WHERE postador = ? ORDER BY id DESC");
		$sql->bind_param("s", $this->usuario);
		$sql->execute();
		$get = $sql->get_result();
		$total = $get->num_rows;

		if($total > 0){
			$id = $total + 1;
			while($dados = $get->fetch_array()){
				$id --;

				echo "<tr>
				<td>{$id}</td>
				<td style='font-size:15px;'>{$dados['titulo']}</td>
				<td><button class='btn btn-success btn-sm dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' id='btnGroupDrop'>
						<i class='fas fa-cog'></i> Gerenciar
					</button>
					<div class='dropdown-menu' aria-labelledby='btnGroupDrop'>
						<a class='dropdown-item' href='topico/{$dados['id']}-".strtolower($this->strReplace($dados['titulo']))."'><i class='fas fa-eye'></i> Ver Tópico</a>
						<a class='dropdown-item' href='deletar-topico/{$dados['id']}'><i class='fas fa-user-lock'></i> Deletar Tópico</a>
				    </div></td>
			</tr>";
			}
		}
	}

	public function get_lastsTopicsUser($user){
		$sql = $this->con->prepare("SELECT * FROM topicos WHERE postador = ? ORDER BY id DESC LIMIT 10");
		$sql->bind_param("s", $user);
		$sql->execute();
		$get = $sql->get_result();
		$total = $get->num_rows;

		if($total > 0){
			while($dados = $get->fetch_array()){
				echo "<li><a href='topico/{$dados['id']}-".strtolower($this->strReplace($dados['titulo']))."'>{$dados['titulo']}</a></li><br>";
			}
		}
	}

	public function get_lastsReplysUser($user){
		$sql = $this->con->prepare("SELECT * FROM respostas WHERE postador = ? ORDER BY id DESC LIMIT 10");
		$sql->bind_param("s", $user);
		$sql->execute();
		$get = $sql->get_result();
		$total = $get->num_rows;

		if($total > 0){
			while($dados = $get->fetch_array()){
				$titulo = $this->get_dados_topico($dados['id_topico'], 'titulo');
				echo "<li><a href='topico/{$dados['id_topico']}-".strtolower($this->strReplace($titulo))."'>{$titulo}</a></li><br>";
			}
		}
	}

	public function get_listfriends($id_para){
		$sql = $this->con->prepare("SELECT * FROM amigos WHERE (id_de = ?) OR (id_para = ?) AND status = 1");
		$sql->bind_param("ss", $id_para, $id_para);
		$sql->execute();
		$get = $sql->get_result();
		$total = $get->num_rows;

		if($total > 0){
			while($dados = $get->fetch_array()){
				$sq = $this->con->prepare("SELECT nome, usuario, foto FROM usuarios WHERE usuario = ?");
				$sq->bind_param("s", $dados['id_para']);
				$sq->execute();
				$dq = $sq->get_result()->fetch_assoc();

				if($id_para != $dados['id_para']){
					echo "<a href='perfil/{$dados['id_para']}'><img src='{$dq['foto']}' class='friend img-fluid'></a>";
				}
			}
		}


		$qr = $this->con->prepare("SELECT * FROM amigos WHERE (id_para = ?) OR (id_de = ?) AND status = 1");
		$qr->bind_param("ss", $id_para, $id_para);
		$qr->execute();
		$getr = $qr->get_result();
		$totalr = $getr->num_rows;

		if($total > 0){
			while($dadosr = $getr->fetch_array()){
				$sqr = $this->con->prepare("SELECT nome, usuario, foto FROM usuarios WHERE usuario = ?");
				$sqr->bind_param("s", $dadosr['id_de']);
				$sqr->execute();
				$dqr = $sqr->get_result()->fetch_assoc();

				if($id_para != $dadosr['id_de']){
					echo "<a href='perfil/{$dadosr['id_de']}'><img src='{$dqr['foto']}' class='friend img-fluid'></a>";
				}
			}
		}
	}


	public function friends_accept_solicitation($usuario, $status, $recuse){
		$sql = $this->con->prepare("SELECT * FROM amigos WHERE id_de = ? OR id_para = ?");
		$sql->bind_param("ss", $usuario, $usuario);
		$sql->execute();
		$get = $sql->get_result();
		$total = $get->num_rows;

		if($total > 0 && $id_para = $usuario || $total > 0 && $recuse == true){
			if($status == 1){
				$qr = $this->con->prepare("UPDATE amigos SET status = 1 WHERE id_para = ? OR id_de = ?");
				$qr->bind_param("ss", $usuario, $usuario);
				$qr->execute();

				if($qr->affected_rows > 0){
					$this->alert(false, false, true, 'invites/');
				}else{
					$this->alert(false, false, true, 'invites/');
				}

			}else if($status == 0){
				$qr1 = $this->con->prepare("DELETE FROM amigos WHERE id_para = ? OR id_de = ?");
				$qr1->bind_param("ss", $usuario, $usuario);
				$qr1->execute();

				if($qr1->affected_rows > 0){
					$this->alert(false, false, true, 'invites/');
				}else{
					$this->alert(false, false, true, 'invites/');
				}
			}else if($status == 2 && $recuse == true){
				$qr1 = $this->con->prepare("DELETE FROM amigos WHERE id_para = ? OR id_de = ?");
				$qr1->bind_param("ss", $usuario, $usuario);
				$qr1->execute();

				if($qr1->affected_rows > 0){
					$this->alert(false, false, true, 'invites/');
				}else{
					$this->alert(false, false, true, 'invites/');
				}}
	
		}else{
			$this->alert(false, false, true, 'invites/');
		}
	}


	public function get_userstatus($user){
		$sql = $this->con->prepare("SELECT * FROM usuarios_online WHERE sessao = ?");
		$sql->bind_param("s", $user);
		$sql->execute();

		return $sql->get_result()->num_rows;
	}

	public function mute_user($user, $var){
		$sq = $this->con->prepare("SELECT nivel FROM usuarios WHERE usuario = ?");
		$sq->bind_param("s", $user);
		$sq->execute();
		$dados = $sq->get_result()->fetch_assoc();

		if(isset($_SESSION['userLogin']) && $this->nivel >= 1 && $dados['nivel'] < 2){
		$sql = $this->con->prepare("UPDATE usuarios SET ativo_chat = ? WHERE usuario = ?");
		$sql->bind_param("ss", $var, $user);
		$sql->execute();

		if($sql->affected_rows > 0){
			$this->alert(false, false, true, 'perfil/'.$user);
		}else{
			$this->alert(false, false, true, 'perfil/'.$user);
		}
	}else{
		$this->alert(false, false, true, 'perfil/'.$user);
	}
}


	public function ban_user($user, $var){
			$sq = $this->con->prepare("SELECT nivel FROM usuarios WHERE usuario = ?");
			$sq->bind_param("s", $user);
			$sq->execute();
			$dados = $sq->get_result()->fetch_assoc();

			if(isset($_SESSION['userLogin']) && $this->nivel >= 1 && $dados['nivel'] < 2){
			$sql = $this->con->prepare("UPDATE usuarios SET ativo = ? WHERE usuario = ?");
			$sql->bind_param("ss", $var, $user);
			$sql->execute();

			if($sql->affected_rows > 0){
				$this->alert(false, false, true, 'perfil/'.$user);
			}else{
				$this->alert(false, false, true, 'perfil/'.$user);
			}
		}else{
			$this->alert(false, false, true, 'perfil/'.$user);
		}
	}

	public function messages_menu(){
		echo "<div class='btn-group-vertical btn-group-sm'>
		    <button onclick="; echo "location.href='mark-ready/{$this->usuario}'"." class='btn btn-primary'><i class='fas fa-check-double'></i> Marcar todas como lido</button>
		    <!--<button onclick="; echo "location.href='delete-messages/{$this->usuario}'"." class='btn btn-danger'><i class='fas fa-trash'></i> Deletar todas as mensagens</button>--><br>
		  </div>";
	}

	public function get_messages(){
		$sql = $this->con->prepare("SELECT * FROM messages_private WHERE id_para = ? ORDER BY id DESC LIMIT 50");
		$sql->bind_param("s", $this->usuario);
		$sql->execute();
		$get = $sql->get_result();
		$total = $get->num_rows;

		if($total > 0){
			while ($dados = $get->fetch_array()) {
				$data = $this->get_data();
				echo "<div class='media'>
					<a href='conversa/{$dados['id_de']}'>
				  <img class='mr-3' src='{$this->get_dadosUser($dados['id_de'], 'foto')}'>
				  <div class='media-body'>
				    <h5 class='mt-0'>{$this->get_dadosUser($dados['id_de'], 'nome')} <span class='float-right text-muted'><small>{$this->calculaDias($data, $dados['data'])}</small>"; 
				    if($dados['lido'] == 1){
				    	echo "<span class='badge badge-success'>LIDO</span>";
				    }else{
				    	echo "<span class='badge badge-primary'>NOVO</span>";
				    }
				    echo "</span></h5>
				    {$dados['mensagem']}</a>
				  </div>
				</div>";
			}
		}
	}

	public function get_chatmessages($id_de){
		$sql = $this->con->prepare("SELECT * FROM (SELECT * FROM messages_private WHERE (id_de = ? AND id_para = ?) OR (id_de = ? AND id_para = ?) ORDER BY id DESC LIMIT 10) sub ORDER BY id ASC");
		$sql->bind_param("ssss", $id_de, $this->usuario, $this->usuario, $id_de);
		$sql->execute();
		$get = $sql->get_result();
		$total = $get->num_rows;
		if($total <= 0){
			echo "<center><code>Você ainda não conversou com este usuário.</code></center>";
		}else{
			$this->update_messagestoRead();
			while($dados = $get->fetch_array()){
				$data = $this->get_data();
				if($dados['id_de'] == $id_de){
					echo "<div class='incoming_msg'>
		              <div class='received_msg'>
		                <div class='received_withd_msg'>
		                  <p>{$dados['mensagem']}</p>
		                  <span class='time_date'> Enviou {$this->calculaDias($data, $dados['data'])}</span></div>
		              </div>
		            </div>";
				}

				if($dados['id_para'] == $id_de){
		            echo "<div class='outgoing_msg'>
		              <div class='sent_msg'>
		                <p>{$dados['mensagem']}</p>
		                <span class='time_date'> Enviou {$this->calculaDias($data, $dados['data'])}</span> </div>
		            </div>";
				}
			}
		}
	}

	public function update_messagestoRead(){
		$sql = $this->con->prepare("UPDATE messages_private SET lido = 1 WHERE id_para = ?");
		$sql->bind_param("s", $this->usuario);
		$sql->execute();
	}

	public function send_message_chat($id_para){
		if(isset($_POST['env']) && $_POST['env'] == "chat"){
			$id_de = $this->usuario;
			$data = $this->get_data();
			$mensagem = addslashes($_POST['mensagem']);

			$sql = $this->con->prepare("INSERT INTO messages_private (id_de, id_para, data, mensagem) VALUES (?,?,?,?)");
			$sql->bind_param("ssss", $id_de, $id_para, $data, $mensagem);
			$sql->execute();

			if($sql->affected_rows > 0){
				$this->alert(null, null, true, "conversa/{$id_para}");
			}else{
				$this->alert(null, null, true, "conversa/{$id_para}");
			}
		}
	}

	public function update_markready($id){
		if($id == $this->usuario){
			$sql = $this->con->prepare("UPDATE messages_private SET lido = 1 WHERE id_para = ?");
			$sql->bind_param("s", $id);
			$sql->execute();

			if($sql->affected_rows > 0){
				$this->alert(null, null, true, "mensagens");
			}else{
				$this->alert(null, null, true, "mensagens");
			}
		}else{
			$this->alert(null, null, true, "inicio");
		}
	}

	public function delete_allmessages($id){
		if($id == $this->usuario){
			$sql = $this->con->prepare("DELETE FROM messages_private WHERE id_para = ?");
			$sql->bind_param("s", $id);
			$sql->execute();

			if($sql->affected_rows > 0){
				$this->alert(null, null, true, "mensagens");
			}else{
				$this->alert(null, null, true, "mensagens");
			}
		}else{
			$this->alert(null, null, true, "inicio");
		}
	}

	public function inverteData($data){
	    if(count(explode("/",$data)) > 1){
	        return str_replace("/", "-", implode("-",array_reverse(explode("/",$data))));
	    }elseif(count(explode("-",$data)) > 1){
	        return str_replace("/", "-", implode("/",array_reverse(explode("-",$data))));
	    }
	}

	public function change_profile_infos(){
		if(isset($_POST['env']) && $_POST['env'] == "altperfil"){
			$nome = $_POST['nome'];
			if($_POST['senha'] == $this->senha){
				$senha = $this->senha;
			}else{
				$senha = md5($_POST['senha']);
			}
			$email = $_POST['email'];
			$nascimento = $_POST['nascimento'];
			$sexo = $_POST['sexo'];
			$pais = $_POST['pais'];
			$estado = $_POST['estado'];
			$sobre = $_POST['sobre'];
			$hobbies = $_POST['hobbies'];
			$skills = $_POST['habiAtual'];

			$uploaddir = "images/uploads/profile/";

			if($_FILES['userfile']['tmp_name'] == null){
				$sql = $this->con->prepare("UPDATE usuarios SET nome = ?, senha = ?, email = ?, nascimento = ?, sexo = ?, pais = ?, estado = ?, sobre = ?, hobbies = ?, skills = ? WHERE usuario = ?");
				$sql->bind_param("sssssssssss", $nome, $senha, $email, $nascimento, $sexo, $pais, $estado, $sobre, $hobbies, $skills, $this->usuario);
			}else{
				$uploadfile = $uploaddir.rand()."_".basename($_FILES['userfile']['name']);
				move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);

				$sql = $this->con->prepare("UPDATE usuarios SET nome = ?, foto = ?, senha = ?, email = ?, nascimento = ?, sexo = ?, pais = ?, estado = ?, sobre = ?, hobbies = ?, skills = ? WHERE usuario = ?");
				$sql->bind_param("ssssssssssss", $nome, $uploadfile, $senha, $email, $nascimento, $sexo, $pais, $estado, $sobre, $hobbies, $skills, $this->usuario);
			}

			$sql->execute();

			switch($sql->affected_rows){
				case -1:
					$this->alert("danger", "Erro ao alterar. Contacte um administradr e informe o erro.", false, false);
				break;

				case 0:
					$this->alert("warning", "Você não alterou nada!", false, false);
				break;

				case 1:
					$this->alert("success", "Dados alterado com sucesso!", false, false);
				break;
			}
		
		}
	}

}


class usuarios{
	public $nome = null;
	public $usuario = null;
	public $senha = null;
	public $foto = null;
	public $email = null;
	public $nivel = null;
	public $ativo = null;
	public $pontos = null;
	public $ativo_chat = null;


	public function logIn(){
		echo 
		"
		<form method='POST' class='logIn'>
			<label>Usuário</label>
			<input type='text' name='usuario' class='form-control'><br>

			<label>Senha</label>
			<input type='password' name='senha' class='form-control'><br>

			<p><input type='submit' class='btn btn-primary btn-lg btn-block' value='Logar-se'></p>
			<input type='hidden' name='env' value='login'>
		<form>
		";

		if(isset($_POST['env']) && $_POST['env'] == "login"){
			
		if($_POST['usuario'] && $_POST['senha']){
			$usuarioL = $this->con->real_escape_string($_POST['usuario']);
			$senhaL = $this->con->real_escape_string(md5($_POST['senha']));
			$query = $this->con->prepare("SELECT * FROM usuarios WHERE usuario = ? AND senha = ?");
			$query->bind_param("ss", $usuarioL, $senhaL);
			$query->execute();
			$get = $query->get_result();
			$total = $get->num_rows;

			if($total > 0){
				$dados = $get->fetch_assoc();

				if($dados['ativo'] == 0){
					echo "<script> alert('SEU LOGIN FOI NEGADO. MOTIVO: Você está banido do fórum');</script>";
					$this->alert('danger', 'Você está banido.', true, 'inicio');
					exit();
				}

				$_SESSION['userLogin'] = $dados['usuario'];

				$this->alert('danger', 'Usuário ou senha inválidos.', true, 'inicio');

			}else{
				$this->alert('danger', 'Usuário ou senha inválidos.', false, false);
			}
		}else{
				$this->alert('danger', 'Preencha todos os campos!', false, false);
			}
		}
	}

	public function logOut(){
		if(session_destroy()){
			$this->alert(false, false, true, 'inicio');
		}else{
			return false;
		}
		
	}

	public function register(){
		if(isset($_SESSION['userLogin'])){
			$this->alert(false, false, true, "inicio");
			exit();
		}
		if(isset($_POST['env']) && $_POST['env'] == "cad"){
			$nome = $_POST['nome'];
			$usuario = $_POST['usuario'];
			$senha = md5($_POST['senha']);
			$email = $_POST['email'];

			$sql = $this->con->prepare("SELECT nome FROM usuarios WHERE (usuario = ?) OR (email = ?)") or die($this->con->error);
			$sql->bind_param("ss", $usuario, $email) or die($sql->error);
			$sql->execute();
			$get = $sql->get_result();
			$total = $get->num_rows;

			if($total > 0){
				$this->alert("danger", "Já existe um usuário cadastrado com este usuário ou email, tente outro.", false, false);
			}else{
				$sql->close();
				$envq = $this->con->prepare("INSERT INTO usuarios (nome, usuario, senha, email) VALUES (?,?,?,?)") or die($this->con->error);
				$envq->bind_param("ssss", $nome, $usuario, $senha, $email) or die($envq->error);
				$envq->execute();

				if($envq->affected_rows > 0){
					$this->alert("success", "Cadastro efetuado com sucesso! Agora logue-se para continuar.", false, false);
					$envq->close();
				}
			}

		}
	}


	public function alert($tipo, $mensagem, $redirect, $dir){
		if($mensagem != false){
			echo "<div class='alert alert-{$tipo}'>{$mensagem}</div>";
		}
		
		if($redirect == true){
			echo "<meta http-equiv='refresh' content='0; url={$dir}'>";			
		}
	}
}

class admcp extends forum{
		public $con = null;


		public function __construct($con){
			$this->con = $con;

			if(isset($_SESSION['admLogin'])){
				$adm = $_SESSION['admLogin'];
				$sql = $this->con->prepare("SELECT * FROM usuarios WHERE usuario = ?");
				$sql->bind_param("s", $adm);
				$sql->execute();
				$dados = $sql->get_result()->fetch_assoc();

				$this->nome = $dados['nome'];
				$this->usuario = $dados['usuario'];
				$this->senha = $dados['senha'];
				$this->foto = $dados['foto'];
				$this->nivel = $dados['nivel'];
			}
		}

		public function redireciona($tempo, $url){
			echo "<meta http-equiv='refresh' content='{$tempo}; url=admin/{$url}'>";	
		}

		public function alerta($tipo, $mensagem){
			echo "<div class='alert alert-{$tipo}'>{$mensagem}</div>";
		}

		public function get_siteinfos($valor){
			$sql = $this->con->prepare("SELECT * FROM configs_site");
			$sql->execute();
			$get = $sql->get_result();
			$dados = $get->fetch_assoc();

			return $dados[$valor];
		}

		public function carrega_pagina($con){
			$url = (isset($_GET['pagina'])) ? $_GET['pagina'] : 'login';
			$explode = explode('/', $url);
			$dir = "pags/";
			$ext = ".php";

			if(file_exists($dir.$explode['0'].$ext)){
				if(file_exists($dir.$explode['0'].$ext) && isset($_SESSION['admLogin'])){
					include($dir.$explode['0'].$ext);
				}else if(file_exists($dir.$explode['0'].$ext) && !isset($_SESSION['admLogin'])){
					$paginas_permitidas = array("login");
				if(in_array($explode['0'], $paginas_permitidas)){
					include($dir.$explode['0'].$ext);
				}else{
					$this->redireciona(0, "login");
				}
			}
		}else{
				$this->alerta("danger", "PÁGINA NÃO ENCONTADA");
			}
	}

		public function gera_titulo(){
			$titulo = $this->get_siteinfos("titulo");
			$url = (isset($_GET['pagina'])) ? $_GET['pagina'] : 'login';
			$explode = explode('/', $url);
			switch($explode['0']):
				case 'login':
					$titulo = $titulo." - ADMCP	";
				break;


				case 'dashboard':
					$titulo = "Dashboard";
				break;

				case 'n-categoria':
					$titulo = "Cadastrar Categoria";
				break;

				case 'g-categorias':
					$titulo = "Gerenciar Categorias";
				break;

				case 'e-categoria':
					$titulo = "Editar Categoria";
				break;

				case 'n-forum':
					$titulo = "Cadastrar Fórum";
				break;

				case 'g-forums':
					$titulo = "Gerenciar Fórums";
				break;

				case 'e-forum':
					$titulo = "Editar Fórum";
				break;

				case 'b-topicos':
					$titulo = "Buscar Tópicos";
				break;

				case 'g-topicos':
					$titulo = "Gerenciar Tópicos";
				break;

				case 'c-cbox':
					$titulo = "Configurações do Chatbox";
				break;

				case 'c-site':
					$titulo = "Configurações do site";
				break;

				case 'c-reputacao':
					$titulo = "Gerenciar Reputação";
				break;

				case 'c-outras':
					$titulo = "Outras Configurações";
				break;

				case 'e-nivel':
					$titulo = "Editar Nível";
				break;

			endswitch;
			echo $titulo;
		}

		public function loginADM(){
			if(isset($_POST['env']) && $_POST['env'] == "login"){
				$usuario = addslashes($_POST['usuario']);
				$senha = addslashes(md5($_POST['senha']));

				$sql = $this->con->prepare("SELECT * FROM usuarios WHERE usuario = ? AND senha = ?");
				$sql->bind_param("ss", $usuario, $senha);
				$sql->execute();
				$get = $sql->get_result();
				$total = $get->num_rows;

				if($total > 0){
					$dados = $get->fetch_assoc();
					if($dados['nivel'] > 0){
						$_SESSION['admLogin'] = $dados['usuario'];
						$this->alerta("success", "Logado com sucesso...");
						$this->redireciona(3, "dashboard");

					}else{
						$this->alerta("danger", "Usuário ou senha inválidos.");
					}
				}else{
					$this->alerta("danger", "Usuário ou senha inválidos");
				}
			}
		}

		public function welcome_title(){
			if($this->nivel == 1){
				return "<span class='text-success'><b>{$this->nome}</b></span>";
			}else if($this->nivel == 2){
				return "<span class='text-danger'><b>{$this->nome}</b></span>";
			}
		}

		public function menu_adm(){
			echo "<ul>
					<li id='menu-adm'></li>
					<div id='content-menu'>

					<li class='inicio'><a href='admin/dashboard'><i class='fas fa-home'></i> Inicio</a></li>

					<li class='categorias'><a><i class='fas fa-layer-group'></i> Categorias</a>
						<ul>
							<li><a href='admin/n-categoria'><i class='fas fa-plus'></i> Nova Categoria</a></li>
							<li><a href='admin/g-categorias'><i class='fas fa-cog'></i> Gerenciar Categorias</a></li>
						</ul>
					</li>

					<li class='forums'><a><i class='fas fa-bars'></i> Forums</a>
						<ul>
							<li><a href='admin/n-forum'><i class='fas fa-plus'></i> Novo Fórum</a></li>
							<li><a href='admin/g-forums'><i class='fas fa-cog'></i> Gerenciar Fórums</a></li>
						</ul>
					</li>

					<li class='topicos'><a><i class='fas fa-th-list'></i> Tópicos</a>
						<ul>
							<li><a href='admin/b-topicos'><i class='fas fa-search'></i> Buscar Tópicos</a></li>
							<li><a href='admin/g-topicos'><i class='fas fa-cog'></i> Gerenciar Tópicos</a></li>
						</ul>
					</li>";

					if($this->nivel == 2){
					echo "<li class='usuarios'><a><i class='fas fa-users'></i> Usuários</a>
						<ul>
							<li><a href='admin/b-usuarios'><i class='fas fa-search'></i> Buscar Usuários</a></li>
							<li><a href='admin/g-usuarios'><i class='fas fa-cog'></i> Gerenciar Usuários</a></li>
						</ul>
					</li>";}

					echo "<li class='chatboxa'><a><i class='fas fa-comments'></i> ChatBox</a>
						<ul>
							<li><a href='admin/c-cbox'><i class='fas fa-cog'></i> Configurações</a></li>
						</ul>
					</li>

					<li class='nreputacao'><a><i class='fas fa-thumbs-up'></i> Níveis de Reputação</a>
						<ul>
							<li><a href='admin/c-reputacao'><i class='fas fa-cogs'></i> Gerenciar Niveis</a></li>
						</ul>
					</li>

					<li class='configs-site'><a><i class='fas fa-cogs'></i> Configurações do fórum</a>
						<ul>
							<li><a href='admin/c-site'><i class='fas fa-cogs'></i> Configurações do site</a></li>
							<li><a href='admin/c-outras'><i class='fas fa-cogs'></i> Outras Configurações</a></li>
						</ul>
					</li>

					<li class='sair'><a href='admin/sair'><i class='fas fa-power-off'></i> Sair</a></li>
				</div>
				</ul>";
		}

		public function get_totalcategorias(){
			$sql = $this->con->prepare("SELECT * FROM categorias");
			$sql->execute();
			$get = $sql->get_result();
			$total = $get->num_rows;

			return $total;
		}

		public function get_totalforums(){
			$sql = $this->con->prepare("SELECT * FROM forums");
			$sql->execute();
			$get = $sql->get_result();
			$total = $get->num_rows;

			return $total;
		}

		public function get_ntotaltopics(){
			$sql = $this->con->prepare("SELECT * FROM topicos");
			$sql->execute();
			$get = $sql->get_result();
			$total = $get->num_rows;

			return $total;
		}

		public function get_ntotalrespostas(){
			$sql = $this->con->prepare("SELECT * FROM respostas");
			$sql->execute();
			$get = $sql->get_result();
			$total = $get->num_rows;

			return $total;
		}

		public function get_ntotalusuarios(){
			$sql = $this->con->prepare("SELECT id FROM usuarios");
			$sql->execute();
			$get = $sql->get_result();
			$total = $get->num_rows;

			return $total;
		}

		public function verifica_logado(){
			if(isset($_SESSION['admLogin'])){
				$this->redireciona(0, "dashboard");
				exit();
			}
		}

		public function new_categoria(){
			if(isset($_POST['env']) && $_POST['env'] == "categoria"){
				$categoria = $_POST['categoria'];

				$sql = $this->con->prepare("INSERT INTO categorias (categoria) VALUES (?)");
				$sql->bind_param("s", $categoria);
				$sql->execute();

				if($sql->affected_rows > 0){
					$this->alerta("success noborder", "Categoria criada com sucesso");
					$this->redireciona(3, "n-categoria");
				}else{
					$this->alerta("danger noborder", "Erro ao criar a categoria: ".$sql->error);
				}

			}
		}

		public function get_categorias(){
			$sql = $this->con->prepare("SELECT * FROM categorias ORDER BY id ASC");
			$sql->execute();
			$get = $sql->get_result();
			$total = $get->num_rows;

			if($total > 0){
				while($dados = $get->fetch_array()){
				echo "<tr>
					<td>{$dados['id']}</td>
					<td>{$dados['categoria']}</td>
					<td>
						<button class='btn btn-success btn-sm dropdown-toggle noborder' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' id='btnGroupDrop1'><i class='fas fa-cog'></i> Gerenciar</button>
						<div class='dropdown-menu' aria-labelledby='btnGroupDrop1'>
							<a class='dropdown-item success' href='admin/e-categoria/{$dados['id']}'><i class='fas fa-user-edit'></i> Editar Categoria</a>
							<a class='dropdown-item dng' href='admin/d-categoria/{$dados['id']}'><i class='fas fa-trash'></i> Deletar Categoria</a>
						</div>
					</td>
				</tr>";
				}
			}
		}

		public function get_dcategoria($id, $var){
			$sql = $this->con->prepare("SELECT * FROM categorias WHERE id = ?");
			$sql->bind_param("s", $id);
			$sql->execute();
			$get = $sql->get_result();
			$total = $get->num_rows;

			if($total > 0){
				$dados = $get->fetch_assoc();
				return $dados[$var];
			}else{
				return $total;
			}
		}

		public function edit_categoria($id){
			if(isset($_POST['env']) && $_POST['env'] == "updcategoria"){
				$categoria = $_POST['categoria'];

				$sql = $this->con->prepare("UPDATE categorias SET categoria = ? WHERE id = ?");
				$sql->bind_param("ss", $categoria, $id);
				$sql->execute();

				if($sql->affected_rows > 0){
					$this->alerta("success noborder", "Categoria alterada com sucesso");
					$this->redireciona(3, "e-categoria/{$id}");
				}else{
					$this->alerta("danger noborder", "Erro ao alterar a categoria: ".$sql->error);
				}
			}
		}

		public function del_categoria($id){
			if(isset($_SESSION['admLogin'])){
				$sql = $this->con->prepare("DELETE FROM categorias WHERE id = ?");
				$sql->bind_param("s", $id);
				$sql->execute();

				if($sql->affected_rows > 0){
					$sqlt = $this->con->prepare("DELETE FROM forums WHERE categoria = ?");
					$sqlt->bind_param("s", $id);
					$sqlt->execute();

					$sqlr = $this->con->prepare("DELETE FROM topicos WHERE categoria = ?");
					$sqlr->bind_param("s", $id);
					$sqlr->execute();

					$this->redireciona(0, "g-categorias");
				}else{
					$this->redireciona(0, "g-categorias");
				}
			}
		}

		public function get_categorias_options(){
			$sql = $this->con->prepare("SELECT * FROM categorias ORDER BY id DESC");
			$sql->execute();
			$get = $sql->get_result();
			$total = $get->num_rows;

			if($total > 0){
				while($dados = $get->fetch_array()){
					echo "<option value='{$dados['id']}'>{$dados['categoria']}</option>";
				}
			}
		}

		public function new_forum(){
			if(isset($_POST['env']) && $_POST['env'] == "forum"){
				$titulo = $_POST['titulo'];
				$categoria = $_POST['categoria'];
				$status = $_POST['status'];
				$permissao = $_POST['permissao'];
				$descricao = $_POST['descricao'];
				$sql = $this->con->prepare("INSERT INTO forums (titulo, categoria, status, permissao, descricao) VALUES (?,?,?,?,?)");
				$sql->bind_param("sssss", $titulo, $categoria, $status, $permissao, $descricao);
				$sql->execute();

				if($sql->affected_rows > 0){
					$this->alerta("success noborder", "Fórum criado com sucesso");
					$this->redireciona(3, "n-forum");
				}else{
					$this->alerta("success noborder", "Erro ao criar o fórum: ".$sql->error);
				}
			}
		}

		public function get_nforums(){
			$sql = $this->con->prepare("SELECT * FROM forums ORDER BY id DESC");
			$sql->execute();
			$get = $sql->get_result();
			$total = $get->num_rows;

			if($total > 0){
				while($dados = $get->fetch_array()){
				echo "<tr>
					<td><b>{$dados['id']}</b></td>
					<td>{$dados['titulo']}</td>
					<td>
						<button class='btn btn-success btn-sm dropdown-toggle noborder' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' id='btnGroupDrop1'><i class='fas fa-cog'></i> Gerenciar</button>
						<div class='dropdown-menu' aria-labelledby='btnGroupDrop1'>
							<a class='dropdown-item success' href='admin/e-forum/{$dados['id']}'><i class='fas fa-user-edit'></i> Editar Fórum</a>
							<a class='dropdown-item dng' href='admin/d-forum/{$dados['id']}'><i class='fas fa-trash'></i> Deletar Fórum</a>
						</div>
					</td>
				</tr>";
				}
			}
		}

		public function get_foruminfos($id, $var){
			$sql = $this->con->prepare("SELECT * FROM forums WHERE id = ?");
			$sql->bind_param("s", $id);
			$sql->execute();
			$get = $sql->get_result();
			$dados = $get->fetch_assoc();

			return $dados[$var];
		}

		public function get_forumcategoria_option($id){
			$sql = $this->con->prepare("SELECT * FROM categorias WHERE id = ?");
			$sql->bind_param("s", $id);
			$sql->execute();
			$get = $sql->get_result();
			$total = $get->num_rows;

			if($total > 0){
				$dados = $get->fetch_assoc();
				echo "<option value='{$dados['id']}' selected>{$dados['categoria']} (Atual)</option>";
			}
		}

		public function get_switchstatuseforum($status){
			switch($status){
				case 0:
					echo "<option value='0' selected>Fechado - Ninguém pode criar tópicos (Atual)</option>";
				break;

				case 1:
					echo "<option value='1' selected>Aberto - Podendo criar tópicos (Atual)</option>";
				break;
			}
		}

		public function get_switchpermissaotopublicinforum($permissao){
			switch($permissao){
				case 0:
					echo "<option value='0' selected>Membros, Moderadores e Administradores (Atual)</option>";
				break;

				case 1:
					echo "<option value='1' selected>Moderadores e Administradores (Atual)</option>";
				break;

				case 2:
					echo "<option value='2' selected>Apenas Administradores (Atual)</option>";
				break;
			}
		}

		public function edit_forum($id){
			if(isset($_POST['env']) && $_POST['env'] == "updforum"){
				$titulo = $_POST['titulo'];
				$categoria = $_POST['categoria'];
				$status = $_POST['status'];
				$permissao = $_POST['permissao'];
				$descricao = $_POST['descricao'];

				$sql = $this->con->prepare("UPDATE forums SET categoria = ?, titulo = ?, descricao = ?, status = ?, permissao = ? WHERE id = ?");
				$sql->bind_param("ssssss", $categoria, $titulo, $descricao, $status, $permissao, $id);
				$sql->execute();

				switch($sql->affected_rows){
					case -1:
						$this->alerta("danger noborder", "Erro ao alterar o fórum: ".$sql->error);
					break;

					case 0:
						$this->alerta("warning noborder", "Você não alterou nada. Modifique algum campo para enviar");
					break;

					case 1:
						$this->alerta("success noborder", "Fórum alterado com sucesso...");
						$this->redireciona(3, "e-forum/{$id}");
					break;
				}
			}
		}

		public function del_forums($id){
			if(isset($_SESSION['admLogin'])){
				$sql = $this->con->prepare("DELETE FROM forums WHERE id = ?");
				$sql->bind_param("s", $id);
				$sql->execute();

				if($sql->affected_rows > 0){
					$sqlt = $this->con->prepare("DELETE FROM topicos WHERE forum = ?");
					$sqlt->bind_param("s", $id);
					$sqlt->execute();

					$this->redireciona(0, "g-forums");
				}else{
					$this->redireciona(0, "g-forums");
				}
			}
		}

		public function fix_topico($id){
			$sql = $this->con->prepare("UPDATE topicos SET fixo = 1 WHERE id = ?");
			$sql->bind_param("s", $id);
			$sql->execute();

			if($sql->affected_rows > 0){
				$this->redireciona(0, "g-topicos");
			}else{
				$this->alerta("warning noborder", "Erro ao fixar tópico: ".$sql->error);
			}
		}

		public function unfix_topico($id){
			$sql = $this->con->prepare("UPDATE topicos SET fixo = 0 WHERE id = ?");
			$sql->bind_param("s", $id);
			$sql->execute();

			if($sql->affected_rows > 0){
				$this->redireciona(0, "g-topicos");
			}else{
				$this->alerta("warning noborder", "Erro ao fixar tópico: ".$sql->error);
			}
		}

		public function solved_topico($id){
			$sql = $this->con->prepare("UPDATE topicos SET resolvido = 1 WHERE id = ?");
			$sql->bind_param("s", $id);
			$sql->execute();

			if($sql->affected_rows > 0){
				$this->redireciona(0, "g-topicos");
			}else{
				$this->alerta("warning noborder", "Erro ".$sql->error);
			}
		}

		public function unsolved_topico($id){
			$sql = $this->con->prepare("UPDATE topicos SET resolvido = 0 WHERE id = ?");
			$sql->bind_param("s", $id);
			$sql->execute();

			if($sql->affected_rows > 0){
				$this->redireciona(0, "g-topicos");
			}else{
				$this->alerta("warning noborder", "Erro: ".$sql->error);
			}
		}

		public function open_topico($id){
			$sql = $this->con->prepare("UPDATE topicos SET status = 1 WHERE id = ?");
			$sql->bind_param("s", $id);
			$sql->execute();

			if($sql->affected_rows > 0){
				$this->redireciona(0, "g-topicos");
			}else{
				$this->alerta("warning noborder", "Erro: ".$sql->error);
			}
		}

		public function close_topico($id){
			$sql = $this->con->prepare("UPDATE topicos SET status = 0 WHERE id = ?");
			$sql->bind_param("s", $id);
			$sql->execute();

			if($sql->affected_rows > 0){
				$this->redireciona(0, "g-topicos");
			}else{
				$this->alerta("warning noborder", "Erro: ".$sql->error);
			}
		}

		public function delete_topico($id){
			$sql = $this->con->prepare("DELETE FROM topicos WHERE id = ?");
			$sql->bind_param("s", $id);
			$sql->execute();

			if($sql->affected_rows > 0){
				$sqlr = $this->con->prepare("DELETE FROM respostas WHERE id_topico = ?");
				$sqlr->bind_param("s", $id);
				$sqlr->execute();

				$this->redireciona(0, "g-topicos");
			}else{
				$this->alerta("warning noborder", "Erro: ".$sql->error);
			}
		}

		public function get_ntopicos(){
			$sql = $this->con->prepare("SELECT * FROM topicos ORDER BY id DESC LIMIT 20");
			$sql->execute();
			$get = $sql->get_result();
			$total = $get->num_rows;

			if($total > 0){
				while($dados = $get->fetch_array()){
				echo "<tr>
					<td><b>{$dados['id']}</b></td>
					<td>{$dados['titulo']}</td>
					<td>
						<button class='btn btn-success btn-sm dropdown-toggle noborder' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' id='btnGroupDrop1'><i class='fas fa-cog'></i> Gerenciar</button>
						<div class='dropdown-menu' aria-labelledby='btnGroupDrop1'>";

						if($dados['fixo'] == 0){
							echo "
							<a class='dropdown-item success' href='admin/fix-topico/{$dados['id']}'><i class='fas fa-thumbtack'></i> Fixar no topo</a>";
						}else if($dados['fixo'] == 1){
							echo "<a class='dropdown-item drk' href='admin/unfix-topico/{$dados['id']}'><i class='fas fa-bars'></i> Desfixar do topo</a>";
						}

						if($dados['resolvido'] == 0){
							echo "
							<a class='dropdown-item success' href='admin/solved-topico/{$dados['id']}'><i class='fas fa-check'></i>  Marcar como resolvido</a>";
						}else if($dados['resolvido'] == 1){
							echo "<a class='dropdown-item drk' href='admin/unsolved-topico/{$dados['id']}'><i class='fas fa-ban'></i>  Marcar como não resolvido</a>";
						}

						if($dados['status'] == 0){
							echo "
							<a class='dropdown-item success' href='admin/abrir-topico/{$dados['id']}'><i class='fas fa-check'></i> Reabrir tópico</a>";
						}else if($dados['status'] == 1){
							echo "<a class='dropdown-item drk' href='admin/fechar-topico/{$dados['id']}'><i class='fas fa-ban'></i>  Fechar Tópico</a>";
						}

						echo "
							<a class='dropdown-item dng' href='admin/d-topico/{$dados['id']}'><i class='fas fa-trash'></i> Deletar Tópico</a>
						</div>
					</td>
				</tr>";
				}
			}
		}


		public function get_rtopicos(){
			if(isset($_POST['env']) && $_POST['env'] == "busca"){
				$resultado = "%{$_POST['resultado']}%";
				$sql = $this->con->prepare("SELECT * FROM topicos WHERE (titulo LIKE ?) OR (postador LIKE ?) ORDER BY id DESC");
				$sql->bind_param("ss", $resultado, $resultado);
				$sql->execute();
				$get = $sql->get_result();
				$total = $get->num_rows;

				if($total > 0){
					while($dados = $get->fetch_array()){
					echo "<tr>
						<td><b>{$dados['id']}</b></td>
						<td>{$dados['titulo']}</td>
						<td>
							<button class='btn btn-success btn-sm dropdown-toggle noborder' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' id='btnGroupDrop1'><i class='fas fa-cog'></i> Gerenciar</button>
							<div class='dropdown-menu' aria-labelledby='btnGroupDrop1'>";

							if($dados['fixo'] == 0){
								echo "
								<a class='dropdown-item success' href='admin/fix-topico/{$dados['id']}'><i class='fas fa-thumbtack'></i> Fixar no topo</a>";
							}else if($dados['fixo'] == 1){
								echo "<a class='dropdown-item drk' href='admin/unfix-topico/{$dados['id']}'><i class='fas fa-bars'></i> Desfixar do topo</a>";
							}

							if($dados['resolvido'] == 0){
								echo "
								<a class='dropdown-item success' href='admin/solved-topico/{$dados['id']}'><i class='fas fa-check'></i>  Marcar como resolvido</a>";
							}else if($dados['resolvido'] == 1){
								echo "<a class='dropdown-item drk' href='admin/unsolved-topico/{$dados['id']}'><i class='fas fa-ban'></i>  Marcar como não resolvido</a>";
							}

							if($dados['status'] == 0){
								echo "
								<a class='dropdown-item success' href='admin/abrir-topico/{$dados['id']}'><i class='fas fa-check'></i> Reabrir tópico</a>";
							}else if($dados['status'] == 1){
								echo "<a class='dropdown-item drk' href='admin/fechar-topico/{$dados['id']}'><i class='fas fa-ban'></i>  Fechar Tópico</a>";
							}

							echo "
								<a class='dropdown-item dng' href='admin/d-topico/{$dados['id']}'><i class='fas fa-trash'></i> Deletar Tópico</a>
							</div>
						</td>
					</tr>";
					}
				}else{
					$this->alerta("danger noborder", "Nenhum resultado encontrado");
				}
			}
		}

		public function get_nusuarios(){
			$sql = $this->con->prepare("SELECT * FROM usuarios ORDER BY id DESC");
			$sql->execute();
			$get = $sql->get_result();
			$total = $get->num_rows;

			if($total > 0){
				while($dados = $get->fetch_array()){
					if($dados['usuario'] != $this->usuario){
					echo "<tr>
						<td><b>{$dados['id']}</b></td>
						<td>{$dados['nome']}(<b>@<small>{$dados['usuario']}</small></b>)</td>
						<td>
							<button class='btn btn-success btn-sm dropdown-toggle noborder' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' id='btnGroupDrop1'><i class='fas fa-cog'></i> Gerenciar</button>
							<div class='dropdown-menu' aria-labelledby='btnGroupDrop1'>";

								echo "<a class='dropdown-item success' href='admin/alt-senha/{$dados['usuario']}'><i class='fas fa-user-edit'></i> Alterar Senha</a>";

								echo "<a class='dropdown-item success' href='admin/e-nivel/{$dados['usuario']}'><i class='fas fa-user-edit'></i> Editar Nivel</a>";

							if($dados['ativo'] == 0){
								echo "
								<a class='dropdown-item success' href='admin/unban-usuario/{$dados['usuario']}'><i class='fas fa-user-check'></i>  Desbanir Usuário</a>";
							}else if($dados['ativo'] == 1){
								echo "<a class='dropdown-item dng' href='admin/ban-usuario/{$dados['usuario']}'><i class='fas fa-user-slash'></i>  Banir Usuário</a>";
							}

							if($dados['ativo_chat'] == 0){
								echo "
								<a class='dropdown-item success' href='admin/unmute-usuario/{$dados['usuario']}'><i class='fas fa-user-check'></i> Desbanir do chat</a>";
							}else if($dados['ativo_chat'] == 1){
								echo "<a class='dropdown-item dng' href='admin/mute-usuario/{$dados['usuario']}'><i class='fas fa-user-slash'></i> Banir do chat</a>";
							}

							echo "
								<a class='dropdown-item dng' href='admin/d-usuario/{$dados['usuario']}'><i class='fas fa-user-times'></i> Deletar Usuário</a>
							</div>
						</td>
					</tr>";
					}
				}
			}
		}

		public function get_searchusuarios(){
			if(isset($_POST['env']) && $_POST['env'] == "buscau"){
				$resultado = "%{$_POST['resultado']}%";

				$sql = $this->con->prepare("SELECT * FROM usuarios WHERE (nome LIKE ?) OR (usuario LIKE ?) OR (email LIKE ?) ORDER BY id DESC");
				$sql->bind_param("sss", $resultado, $resultado, $resultado);
				$sql->execute();
				$get = $sql->get_result();
				$total = $get->num_rows;

				if($total > 0){
					while($dados = $get->fetch_array()){
					echo "<tr>
						<td><b>{$dados['id']}</b></td>
						<td>{$dados['nome']}(<b>@<small>{$dados['usuario']}</small></b>)</td>
						<td>
							<button class='btn btn-success btn-sm dropdown-toggle noborder' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' id='btnGroupDrop1'><i class='fas fa-cog'></i> Gerenciar</button>
							<div class='dropdown-menu' aria-labelledby='btnGroupDrop1'>";

								echo "<a class='dropdown-item success' href='admin/alt-senha/{$dados['usuario']}'><i class='fas fa-user-edit'></i> Alterar Senha</a>";

								echo "<a class='dropdown-item success' href='admin/e-nivel/{$dados['usuario']}'><i class='fas fa-user-edit'></i> Editar Nivel</a>";

							if($dados['ativo'] == 0){
								echo "
								<a class='dropdown-item success' href='admin/unban-usuario/{$dados['usuario']}'><i class='fas fa-user-check'></i>  Desbanir Usuário</a>";
							}else if($dados['ativo'] == 1){
								echo "<a class='dropdown-item dng' href='admin/ban-usuario/{$dados['usuario']}'><i class='fas fa-user-slash'></i>  Banir Usuário</a>";
							}

							if($dados['ativo_chat'] == 0){
								echo "
								<a class='dropdown-item success' href='admin/unmute-usuario/{$dados['usuario']}'><i class='fas fa-user-check'></i> Desbanir do chat</a>";
							}else if($dados['ativo_chat'] == 1){
								echo "<a class='dropdown-item dng' href='admin/mute-usuario/{$dados['usuario']}'><i class='fas fa-user-slash'></i> Banir do chat</a>";
							}

							echo "
								<a class='dropdown-item dng' href='admin/d-usuario/{$dados['usuario']}'><i class='fas fa-user-times'></i> Deletar Usuário</a>
							</div>
						</td>
					</tr>";
					}
				}
			}
		}

		public function get_userinfos($id, $var){
			$sql = $this->con->prepare("SELECT * FROM usuarios WHERE usuario = ?");
			$sql->bind_param("s", $id);
			$sql->execute();
			$get = $sql->get_result();
			$dados = $get->fetch_assoc();

			return $dados[$var];
		}

		public function upd_senhaUser($usuario){
			if(isset($_POST['env']) && $_POST['env'] == "updsenha"){
				$senha = $this->get_userinfos($usuario, 'senha');
				$nsenha = md5($_POST['nsenha']);

				if($senha == $nsenha){
					$this->alerta("danger noborder", "As senhas são idênticas, coloque uma diferente.");
				}else{
					$sql = $this->con->prepare("UPDATE usuarios SET senha = ? WHERE usuario = ?");
					$sql->bind_param("ss", $nsenha, $usuario);
					$sql->execute();

					if($sql->affected_rows > 0){
						$this->alerta("success noborder", "Senha alterada com sucesso");
						$this->redireciona(3, "alt-senha/{$usuario}");
					}else{
						$this->alerta("danger noborder", "Erro ao alterar a senha");
					}
				}
			}
		}

		public function nban_user($usuario){
			$sql = $this->con->prepare("UPDATE usuarios SET ativo = 0 WHERE usuario = ?");
			$sql->bind_param("s", $usuario);
			$sql->execute();

			if($sql->affected_rows > 0){
				$this->redireciona(0, "g-usuarios");
			}else{
				$this->alerta("warning noborder", "Erro: ".$sql->error);
			}
		}

		public function unban_user($usuario){
			$sql = $this->con->prepare("UPDATE usuarios SET ativo = 1 WHERE usuario = ?");
			$sql->bind_param("s", $usuario);
			$sql->execute();

			if($sql->affected_rows > 0){
				$this->redireciona(0, "g-usuarios");
			}else{
				$this->alerta("warning noborder", "Erro: ".$sql->error);
			}
		}

		public function nmutechat_user($usuario){
			$sql = $this->con->prepare("UPDATE usuarios SET ativo_chat = 0 WHERE usuario = ?");
			$sql->bind_param("s", $usuario);
			$sql->execute();

			if($sql->affected_rows > 0){
				$this->redireciona(0, "g-usuarios");
			}else{
				$this->alerta("warning noborder", "Erro: ".$sql->error);
			}
		}

		public function unmutechat_user($usuario){
			$sql = $this->con->prepare("UPDATE usuarios SET ativo_chat = 1 WHERE usuario = ?");
			$sql->bind_param("s", $usuario);
			$sql->execute();

			if($sql->affected_rows > 0){
				$this->redireciona(0, "g-usuarios");
			}else{
				$this->alerta("warning noborder", "Erro: ".$sql->error);
			}
		}

		public function delete_usuario($id){
			$sql = $this->con->prepare("DELETE FROM usuarios WHERE usuario = ?");
			$sql->bind_param("s", $id);
			$sql->execute();

			if($sql->affected_rows > 0){
				$sqlt = $this->con->prepare("DELETE FROM topicos WHERE postador = ?");
				$sqlt->bind_param("s", $id);
				$sqlt->execute();

				$sqlr = $this->con->prepare("DELETE FROM respostas WHERE postador = ?");
				$sqlr->bind_param("s", $id);
				$sqlr->execute();

				$this->redireciona(0, "g-usuarios");
			}else{
				$this->alerta("warning noborder", "Erro: ".$sql->error);
			}
		}

		public function chatbox_infos($var){
			$sql = $this->con->prepare("SELECT * FROM chatbox WHERE id = 1");
			$sql->execute();
			$get = $sql->get_result();
			$dados = $get->fetch_assoc();

			return $dados[$var];
		}

		public function chatbox_permissionoption(){
			$min = $this->chatbox_infos('min_permission');
			switch($min){
				case 0:
					echo "<option value='0'>Membros, Moderadores, Administradores (Atual)</option>";
				break;

				case 1:
					echo "<option value='1'>Moderadores e Administradores (Atual)</option>";
				break;

				case 2:
					echo "<option value='2'>Apenas Administradores (Atual)</option>";
				break;
			}
		}

		public function chatbox_send_updates(){
			if(isset($_POST['env']) && $_POST['env'] == "chatboxupd"){
				$regras = $_POST['regras'];
				$permissao = $_POST['permissao'];

				$sql = $this->con->prepare("UPDATE chatbox SET regras = ?, min_permission = ? WHERE id = 1");
				$sql->bind_param("ss", $regras, $permissao);
				$sql->execute();

				if($sql->affected_rows > 0){
					$this->alerta("success noborder", "Alteração efetuada com sucesso");
					$this->redireciona(3, "c-cbox");
				}else{
					$this->alerta("danger noborder", "Erro: ".$sql->error);
				}
			}
		}

		public function get_logo(){
			$logo = $this->replaceit($this->get_siteinfos("banner"));
			if($logo != null){
				echo "<img src='{$logo}' class='img-fluid' style='max-width: 200px'><br><br>";
			}
		}

		public function get_icon(){
			$icon = $this->replaceit($this->get_siteinfos("icon"));
			if($icon != null){
				echo "<img src='{$icon}' class='img-fluid' style='max-width: 200px'><br><br>";
			}
		}


		public function update_configs_site(){
			if(isset($_POST['env']) && $_POST['env'] == "csite"){
				$titulo = $_POST['titulo'];
				$keywords = $_POST['keywords'];
				$description = $_POST['description'];
				$uploaddir = '../images/uploads/';

				if(!empty($_FILES['bannerfile']['name']) && is_null($this->get_siteinfos("banner"))){
					$uploadfavicon = $uploaddir.rand()."_".basename($_FILES['bannerfile']['name']);
					move_uploaded_file($_FILES['bannerfile']['tmp_name'], $uploadfavicon);
				}else if(empty($_FILES['bannerfile']['name']) && !is_null($this->get_siteinfos("banner"))){
					$uploadfavicon = $this->get_siteinfos("banner");
				}else if(!empty($_FILES['bannerfile']['name']) && !is_null($this->get_siteinfos("banner"))){
					$uploadfavicon = $uploaddir.rand()."_".basename($_FILES['bannerfile']['name']);
					move_uploaded_file($_FILES['bannerfile']['tmp_name'], $uploadfavicon);
				}


				if(!empty($_FILES['iconfile']['name']) && is_null($this->get_siteinfos("icon"))){
					$uploadlogo = $uploaddir.rand()."_".basename($_FILES['iconfile']['name']);
					move_uploaded_file($_FILES['iconfile']['tmp_name'], $uploadlogo);
				}else if(empty($_FILES['iconfile']['name']) && !is_null($this->get_siteinfos("icon"))){
					$uploadlogo = $this->get_siteinfos("icon");
				}else if(!empty($_FILES['iconfile']['name']) && !is_null($this->get_siteinfos("icon"))){
					$uploadlogo = $uploaddir.rand()."_".basename($_FILES['iconfile']['name']);
					move_uploaded_file($_FILES['iconfile']['tmp_name'], $uploadlogo);
				}

				$sql = $this->con->prepare("UPDATE configs_site SET titulo = ?, description = ?, keywords = ?, banner = ?, icon = ? WHERE id  = 1")or die($this->con->error);
				$sql->bind_param("sssss", $titulo, $description, $keywords, $uploadfavicon, $uploadlogo)or die($sql->error);
				$sql->execute();


				switch($sql->affected_rows){
					case -1:
						$this->alerta("danger noborder", "Erro ao salvar".$sql->error);
					break;

					case 0:
						$this->alerta("warning noborder", "Você não alterou nada... Não pode enviar sem alterar...");
					break;

					case 1:
						$this->alerta("success  noborder", "Configurações alteradas com sucesso!");
						$this->redireciona(3, "c-site");
					break;
				}
			}
		}

		public function get_reputation(){
			$sql = $this->con->prepare("SELECT * FROM reputacao_niveis ORDER BY pontos ASC");
			$sql->execute();
			$get = $sql->get_result();
			$total = $get->num_rows;

			if($total > 0){
				while($dados = $get->fetch_array()){
					echo "<li style='background-color: whitesmoke; text-align:right; margin-bottom: 5px;'><b>{$dados['nome']}</b> - Pontos: ({$dados['pontos']}) <a href='admin/d-reputacao/{$dados['id']}' class='btn btn-danger btn-sm' style='font-size: 10px; padding:5px; color: #FFF; margin: 5px;'><i class='fas fa-trash'></i></a></li>";
				}
			}
		}

		public function add_reputation(){
			if(isset($_POST['env']) && $_POST['env'] == "reputacao"){
				$nome = $_POST['nome'];
				$nivel = $_POST['nivel'];
				$cor = $_POST['cor'];
				$bg_cor = $_POST['bg_cor'];

				$sql = $this->con->prepare("INSERT INTO reputacao_niveis (nome, pontos, cor, bg_cor) VALUES (?,?,?,?)");
				$sql->bind_param("ssss", $nome, $nivel, $cor, $bg_cor);
				$sql->execute();

				if($sql->affected_rows > 0){
					$this->alerta("success noborder", "Nivel adicionado com sucesso...");
					$this->redireciona(3, "c-reputacao");
				}else{
					$this->alerta("danger noborder", "Erro ao enviar: ".$sql->error);
				}
			}
		}

		public function delete_reputacao($id){
			$sql = $this->con->prepare("DELETE FROM reputacao_niveis WHERE id = ?");
			$sql->bind_param("s", $id);
			$sql->execute();


			if($sql->affected_rows > 0){
				$this->redireciona(0, "c-reputacao");
			}else{
				$this->redireciona(0, "c-reputacao");
			}
		}

		public function edit_others(){
			if(isset($_POST['env']) && $_POST['env'] == "upd"){
				$pontos = $_POST['pontos'];
				$sql = $this->con->prepare("UPDATE configs_site SET pontos_por_curtidas = ? WHERE id = 1");
				$sql->bind_param("s", $pontos);
				$sql->execute();

				if($sql->affected_rows > 0){
					$this->alerta("success col-sm-6 noborder", "Alterações efetuadas com sucesso!");
					$this->redireciona(3, "c-outras");
				}else if($sql->affected_rows == -1){
					$this->alerta("danger col-sm-6 noborder", "Erro ao salvar: ".$sql->error);
				}
			}
		}

		public function get_userniveloption($user){
			echo $nivel = $this->get_userinfos($user, "nivel");
			switch($nivel){
				case 0:
					echo "<option value='0'>Membro (Atual)</option>";
				break;

				case 1:
					echo "<option value='1'>Moderador (Atual)</option>";
				break;

				case 2:
					echo "<option value='2'>Administrador  (Atual)</option>";
				break;
			}
		}

		public function show_onlyadmin(){
			if($this->nivel < 2){
				$this->redireciona(0, "dashboard");
				exit();
			}
		}

		public function replaceit($var){
			return str_replace("../", "", $var);
		}

		public function edit_nivel($usuario){
			if(isset($_POST['env']) && $_POST['env'] == "nvupd"){
				$nivel = $_POST['nivel'];

				$sql = $this->con->prepare("UPDATE usuarios SET nivel = ? WHERE usuario = ?");
				$sql->bind_param("ss", $nivel, $usuario);
				$sql->execute();

				if($sql->affected_rows > 0){
					$this->alerta("success col-sm-6 noborder", "Alterações efetuadas com sucesso!");
					$this->redireciona(3, "e-nivel/{$usuario}");
				}else if($sql->affected_rows == -1){
					$this->alerta("success col-sm-6 noborder", "Erro ao salvar: ".$sql->error);
				}
			}
			
		}
	}
?>
