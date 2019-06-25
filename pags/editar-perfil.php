<?php $forum = new forum($con);?>
<div class='global-content'>
<div class='global-title'>Editar Dados</div>
	<div class="content">
		<form method="POST" enctype="multipart/form-data">
			<div class="form-group row">
			    <label for="staticEmail" class="col-sm-2 col-form-label">Nome</label>
			    <div class="col-sm-10">
			      <input type="text" name="nome" value="<?php echo $this->get_dadosUser($_SESSION['userLogin'], "nome");?>" class="form-control"><br>
			    </div>
		  	</div>

		  	<div class="form-group row">
			    <label for="staticEmail" class="col-sm-2 col-form-label">Usuário</label>
			    <div class="col-sm-10">
			      <input type="text" readonly value="<?php echo $this->get_dadosUser($_SESSION['userLogin'], "usuario");?>" class="form-control-plaintext"><br>
			    </div>
		  	</div>

		  	<div class="form-group row">
			    <label for="staticEmail" class="col-sm-2 col-form-label">Senha</label>
			    <div class="col-sm-10">
			      <input type="password" name="senha" value="<?php echo $this->get_dadosUser($_SESSION['userLogin'], "senha");?>" class="form-control"><br>
			    </div>
		  	</div>

		  	<div class="form-group row">
			    <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
			    <div class="col-sm-10">
			      <input type="email" name="email" value="<?php echo $this->get_dadosUser($_SESSION['userLogin'], "email");?>" class="form-control"><br>
			    </div>
		  	</div>

		  	<div class="form-group row">
			    <label for="staticEmail" class="col-sm-2 col-form-label">Foto</label>
			    <div class="col-sm-10">
			      <input type="file" name="userfile" class="form-control" accept="image/x-png,image/gif,image/jpeg" /><br>
			    </div>
		  	</div>

		  	<div class="form-group row">
			    <label for="staticEmail" class="col-sm-2 col-form-label">Nascimento</label>
			    <div class="col-sm-10">
			      <input type="date" name="nascimento" value="<?php echo $this->get_dadosUser($_SESSION['userLogin'], "nascimento");?>" class="form-control"><br>
			    </div>
		  	</div>

		  	<div class="form-group row">
			    <label for="staticEmail" class="col-sm-2 col-form-label">Sexo</label>
			    <div class="col-sm-10">
			    <?php
			    	if(is_null($this->get_dadosUser($_SESSION['userLogin'], "sexo"))){
						$sexo = "<option>Prefiro Não Informar (Atual)</option>";
					}else if($this->get_dadosUser($_SESSION['userLogin'], "sexo") == 0){
						$sexo = "<option value='0'>Masculino (Atual)</option>";
					}else if($this->get_dadosUser($_SESSION['userLogin'], "sexo") == 1){
						$sexo = "<option value='1'>Feminimo (Atual)</option>";
					}
			    ?>
				<select name="sexo" class="form-control">
					<?php echo $sexo;?>
					<option value="0">Masculino</option>
					<option value="1">Feminino</option>
					<option>Prefiro Não Informar</option>
				</select><br>
			    </div>
		  	</div>

		  	<div class="form-group row">
			    <label for="staticEmail" class="col-sm-2 col-form-label">País</label>
			    <div class="col-sm-10">
			      <select name="pais" class="form-control">
					<option value="Brasil">Brasil</option>
				</select><br>
			    </div>
		  	</div>

		  	<?php
		  		$nstado = null;
		  		switch($this->get_dadosUser($_SESSION['userLogin'], "estado")){
		  			case "AC":
		  				$nstado = "<option value='AC'>Acre (Atual)</option>";
		  			break;

		  			case "AL":
		  				$nstado = "<option value='AL'>Alagoas (Atual)</option>";
		  			break;

		  			case "AP":
		  				$nstado = "<option value='AP'>Amapá (Atual)</option>";
		  			break;

		  			case "AM":
		  				$nstado = "<option value='AM'>Amazonas (Atual)</option>";
		  			break;

		  			case "BA":
		  				$nstado = "<option value='BA'>Bahia (Atual)</option>";
		  			break;

		  			case "CE":
		  				$nstado = "<option value='CE'>Ceará (Atual)</option>";
		  			break;

		  			case "DF":
		  				$nstado = "<option value='DF'>Distrito Federal (Atual)</option>";
		  			break;

		  			case "ES":
		  				$nstado = "<option value='ES'>Espírito Santo (Atual)</option>";
		  			break;

		  			case "GO":
		  				$nstado = "<option value='GO'>Goiás (Atual)</option>";
		  			break;

		  			case "MA":
		  				$nstado = "<option value='MA'>Maranhão (Atual)</option>";
		  			break;

		  			case "MT":
		  				$nstado = "<option value='MT'>Mato Grosso (Atual)</option>";
		  			break;

		  			case "MS":
		  				$nstado = "<option value='MS'>Mato Grosso do Sul (Atual)</option>";
		  			break;

		  			case "MG":
		  				$nstado = "<option value='MG'>Minas Gerais (Atual)</option>";
		  			break;

		  			case "PA":
		  				$nstado = "<option value='PA'>Pará (Atual)</option>";
		  			break;

		  			case "PB":
		  				$nstado = "<option value='PB'>Paraíba (Atual)</option>";
		  			break;

		  			case "PR":
		  				$nstado = "<option value='PR'>Paraná (Atual)</option>";
		  			break;

		  			case "PE":
		  				$nstado = "<option value='PE'>Pernambuco (Atual)</option>";
		  			break;

		  			case "PI":
		  				$nstado = "<option value='PI'>Piauí (Atual)</option>";
		  			break;

		  			case "RJ":
		  				$nstado = "<option value='RJ'>Rio de Janeiro (Atual)</option>";
		  			break;

		  			case "RN":
		  				$nstado = "<option value='RN'>Rio Grande do Norte (Atual)</option>";
		  			break;

		  			case "RS":
		  				$nstado = "<option value='RS'>Rio Grande do Sul (Atual)</option>";
		  			break;

		  			case "RO":
		  				$nstado = "<option value='RO'>Rondônia (Atual)</option>";
		  			break;

		  			case "RR":
		  				$nstado = "<option value='RR'>Roraima (Atual)</option>";
		  			break;

		  			case "SC":
		  				$nstado = "<option value='SC'>Santa Catarina (Atual)</option>";
		  			break;

		  			case "SP":
		  				$nstado = "<option value='SP'>São Paulo (Atual)</option>";
		  			break;

		  			case "SE":
		  				$nstado = "<option value='SE'>Sergipe (Atual)</option>";
		  			break;

		  			case "TO":
		  				$nstado = "<option value='TO'>Tocantins (Atual)</option>";
		  			break;

		  			case "ET":
		  				$nstado = "<option value='ET'>Estrangeiro (Atual)</option>";
		  			break;

		  			default:
		  				$nstado = "<option>Prefiro não dizer (Atual)</option>";
		  			break;


		  		}
		  	?>

		  	<div class="form-group row">
			    <label for="staticEmail" class="col-sm-2 col-form-label">Estado</label>
			    <div class="col-sm-10">
			      <select id="estado" name="estado" class="form-control">
			      	<?php echo $nstado;?>
				    <option value="AC">Acre</option>
				    <option value="AL">Alagoas</option>
				    <option value="AP">Amapá</option>
				    <option value="AM">Amazonas</option>
				    <option value="BA">Bahia</option>
				    <option value="CE">Ceará</option>
				    <option value="DF">Distrito Federal</option>
				    <option value="ES">Espírito Santo</option>
				    <option value="GO">Goiás</option>
				    <option value="MA">Maranhão</option>
				    <option value="MT">Mato Grosso</option>
				    <option value="MS">Mato Grosso do Sul</option>
				    <option value="MG">Minas Gerais</option>
				    <option value="PA">Pará</option>
				    <option value="PB">Paraíba</option>
				    <option value="PR">Paraná</option>
				    <option value="PE">Pernambuco</option>
				    <option value="PI">Piauí</option>
				    <option value="RJ">Rio de Janeiro</option>
				    <option value="RN">Rio Grande do Norte</option>
				    <option value="RS">Rio Grande do Sul</option>
				    <option value="RO">Rondônia</option>
				    <option value="RR">Roraima</option>
				    <option value="SC">Santa Catarina</option>
				    <option value="SP">São Paulo</option>
				    <option value="SE">Sergipe</option>
				    <option value="TO">Tocantins</option>
				    <option value="ET">Estrangeiro</option>
				</select><br>
			    </div>
		  	</div>

		  	<div class="form-group row">
			    <label for="staticEmail" class="col-sm-2 col-form-label">Sobre</label>
			    <div class="col-sm-10">
			      <textarea class="form-control" name="sobre" rows="4"><?php echo $this->get_dadosUser($_SESSION['userLogin'], "sobre");?></textarea><br>
			    </div>
		  	</div>

		  	<div class="form-group row">
			    <label for="staticEmail" class="col-sm-2 col-form-label">Hobbies</label>
			    <div class="col-sm-10">
			      <textarea class="form-control" placeholder="Quais são seus hobbies?" name="hobbies" rows="4"><?php echo $this->get_dadosUser($_SESSION['userLogin'], "hobbies");?></textarea><br>
			    </div>
		  	</div>

			<?php 
				$varhtml = null;
				$varphp = null;
				$varsql = null;
				$varboot = null;
				$varcss = null;
				$varjava = null;
				$varjquery = null;
				$varajax = null;
				$varc = null;
				$varcplus = null;
				$varphyton = null;
				$varandroid = null;

				$skills = $this->get_dadosUser($_SESSION['userLogin'], "skills");
				$explodesk = explode(",", $skills);

				if(in_array("HTML", $explodesk)){
					$varhtml = "checked";
				}

				if(in_array("PHP", $explodesk)){
					$varphp = "checked";
				}

				if(in_array("SQL", $explodesk)){
					$varsql = "checked";
				}

				if(in_array("Bootstrap", $explodesk)){
					$varboot = "checked";
				}

				if(in_array("CSS", $explodesk)){
					$varcss = "checked";
				}

				if(in_array("JavaScript", $explodesk)){
					$varjava = "checked";
				}

				if(in_array("Jquery", $explodesk)){
					$varjquery = "checked";
				}

				if(in_array("Ajax", $explodesk)){
					$varajax = "checked";
				}

				if(in_array("C#", $explodesk)){
					$varc = "checked";
				}

				if(in_array("C++", $explodesk)){
					$varcplus = "checked";
				}

				if(in_array("Phyton", $explodesk)){
					$varphyton = "checked";
				}

				if(in_array("Android", $explodesk)){
					$varandroid = "checked";
				}


			?>


		  	<div class="form-group row">
			    <label for="staticEmail" class="col-sm-2 col-form-label">Habilidades</label>
			    <div class="col-sm-10">
			    	<div class="custom-control custom-checkbox">
					  <input type="checkbox" class="custom-control-input" id="checkboxHTML" <?php echo $varhtml;?>>
					  <label class="custom-control-label" for="checkboxHTML" >HTML</label>
					</div>

			      	<div class="custom-control custom-checkbox">
					  <input type="checkbox" class="custom-control-input" id="checkboxPHP" <?php echo $varphp;?>>
					  <label class="custom-control-label" for="checkboxPHP">PHP</label>
					</div>

					<div class="custom-control custom-checkbox">
					  <input type="checkbox" class="custom-control-input" id="checkboxSQL" <?php echo $varsql;?>>
					  <label class="custom-control-label" for="checkboxSQL">SQL</label>
					</div>

					<div class="custom-control custom-checkbox">
					  <input type="checkbox" class="custom-control-input" id="checkboxBOT" <?php echo $varboot;?>>
					  <label class="custom-control-label" for="checkboxBOT">Bootstrap</label>
					</div>

					<div class="custom-control custom-checkbox">
					  <input type="checkbox" class="custom-control-input" id="checkboxCSS" <?php echo $varcss;?>>
					  <label class="custom-control-label" for="checkboxCSS">CSS</label>
					</div>

					<div class="custom-control custom-checkbox">
					  <input type="checkbox" class="custom-control-input" id="checkboxJS"<?php echo $varjava;?>>
					  <label class="custom-control-label" for="checkboxJS">JavaScript</label>
					</div>

					<div class="custom-control custom-checkbox">
					  <input type="checkbox" class="custom-control-input" id="checkboxJquery" <?php echo $varjquery;?>>
					  <label class="custom-control-label" for="checkboxJquery">Jquery</label>
					</div>

					<div class="custom-control custom-checkbox">
					  <input type="checkbox" class="custom-control-input" id="checkboxAJAX" <?php echo $varajax;?>>
					  <label class="custom-control-label" for="checkboxAJAX">Ajax</label>
					</div>

					<div class="custom-control custom-checkbox">
					  <input type="checkbox" class="custom-control-input" id="checkboxC" <?php echo $varc;?>>
					  <label class="custom-control-label" for="checkboxC">C#</label>
					</div>

					<div class="custom-control custom-checkbox">
					  <input type="checkbox" class="custom-control-input" id="checkboxCplusplus" <?php echo $varcplus;?>>
					  <label class="custom-control-label" for="checkboxCplusplus">C++</label>
					</div>

					<div class="custom-control custom-checkbox">
					  <input type="checkbox" class="custom-control-input" id="checkboxPhyton" <?php echo $varphyton;?>>
					  <label class="custom-control-label" for="checkboxPhyton">Phyton</label>
					</div>

					<div class="custom-control custom-checkbox">
					  <input type="checkbox" class="custom-control-input" id="checkboxAndroid" <?php echo $varandroid;?>>
					  <label class="custom-control-label" for="checkboxAndroid">Android</label>
					</div><br>
					
					<input type="text" class="form-control" id="habiAtual" name="habiAtual"><br>
			    </div>
		  	</div>

		  	<p align="right"><input type="submit" value="Salvar Configurações" class="btn btn-primary btn-lg"></p>
		  	<input type="hidden" name="env" value="altperfil">
		</form>
		<?php echo $forum->change_profile_infos();?>
	</div>
</div>
