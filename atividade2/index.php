					<?php
						function inicializa(){	
							$conn= mysqli_connect("localhost","root", "");

							$sql = "use atividade2;";
							if (!mysqli_query($conn, $sql)){ 
								$sql = "CREATE DATABASE IF NOT EXISTS atividade2;";
								if(mysqli_query($conn, $sql)){
									$sql = "use atividade2;";
									mysqli_query($conn, $sql);

									$sql = "CREATE TABLE IF NOT EXISTS bio (id int(255) NOT NULL AUTO_INCREMENT, nome varchar(255) NOT NULL, idade int(255), profissao varchar(255), bio varchar(255), foto varchar(255), PRIMARY KEY (id))";
									mysqli_query($conn, $sql);
									if(!mysqli_query($conn, $sql)){
										echo "NÃO FOI POSSIVEL CRIAR BASE";
									}
								}
							}
							
						}

						function obtemBiosAsJson(){	
							$conexaoSql= mysqli_connect("localhost","root", "", "atividade2");
							$resultadoSql = mysqli_query($conexaoSql, "SELECT nome, idade, profissao, bio, foto from BIO");
							$resultadosArray = array();

							if(mysqli_num_rows($resultadoSql)>0){
								while ($linha = $resultadoSql->fetch_assoc()){
									$resultadosArray[] = $linha;
								}
								echo json_encode($resultadosArray);
							}else{
								echo "null";
							}
						}

						inicializa();
					?>

<head>

	<title>Grupo Jean | Home</title>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="estilos/genericStyle.css">
	<link rel="stylesheet" href="estilos/indexStyle.css">

	<script type = "application/javascript">

		const bios = 
					<?php
						obtemBiosAsJson();
					?>;
			
		function montarBios(){
			let registrosElement = document.getElementById("registros");
			
			if(bios){
				bios.forEach((bio, index) =>{
					let registroElement =  document.createElement('div');
					registroElement.id = 'registro_' + index;
					registroElement.classList.add('registro');
					
					
					let fotoElement =  document.createElement('div');
					fotoElement.classList.add('foto');
					fotoElement.style.backgroundImage = 'url("./'+bio.foto+'")';
					fotoElement.style.backgroundPosition = 'center';
					fotoElement.style.backgroundRepeat = 'no-repeat';
					fotoElement.style.backgroundSize = '120px 140px';
					registroElement.appendChild(fotoElement);
					
					let nomeElement =  document.createElement('div');
					nomeElement.classList.add('txts');
					nomeElement.classList.add('nome');
					nomeElement.innerHTML = bio.nome;
					registroElement.appendChild(nomeElement);
					
					let idadeElement =  document.createElement('div');
					idadeElement.classList.add('txts');
					idadeElement.classList.add('info');
					idadeElement.innerHTML = bio.idade + " anos";
					registroElement.appendChild(idadeElement);
					
					let profissaoElement =  document.createElement('div');
					profissaoElement.classList.add('txts');
					profissaoElement.classList.add('info');
					profissaoElement.innerHTML = bio.profissao;
					registroElement.appendChild(profissaoElement);
					
					let bioElement =  document.createElement('div');
					bioElement.classList.add('txts');
					bioElement.classList.add('bio');
					bioElement.innerHTML = bio.bio;
					registroElement.appendChild(bioElement);
					
					registrosElement.appendChild(registroElement);
				});
			}else{
				registrosElement.innerHTML =  "Nenhum bio cadastrado";
				registrosElement.style.textAlign = 'center';
			}
		}

		function adicionarComportamento(){
			document.getElementById('botaoAdicionar').addEventListener('click', ()=> window.open('cadastro.php', '_self'));
		}

		window.addEventListener('load', ()=>{
			adicionarComportamento();
			montarBios();
		});
	</script>

</head>
<body>
	<div class = 'headerGenerico'>Sobre o grupo "Jean"</div>
	<div id = "registros" class = 'registros'></div>
	<div id ="botaoAdicionar" class = 'botaoGenerico'>Incluir novo</div>
</body>

