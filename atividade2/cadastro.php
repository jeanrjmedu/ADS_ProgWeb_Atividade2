                    <?php
                        function realizaCadastro(){
                            try{
                                $extensaoArquivo = strtolower(pathinfo($_FILES["file"]["name"],PATHINFO_EXTENSION));
                                $diretorioArquivoDestino = "fotos/";
                                $nomeArquivoDestino  = "foto". $_POST["nome"];
                                $enderecoArquivoDestino = $diretorioArquivoDestino . $nomeArquivoDestino . "." . $extensaoArquivo;
                        
                                move_uploaded_file($_FILES["file"]["tmp_name"], $enderecoArquivoDestino);
                        
                                $conn= mysqli_connect("localhost","root", "");
                                $sql = "use atividade2;";
                                if (mysqli_query($conn, $sql)){
                                	http_response_code(200);
                                }else{
                                	throw new Exception ("");
                                }
                        
                                $nome = $_POST["nome"];
                                $idade = isset($_POST["idade"]) ? $_POST["idade"] : 0;
                                $profissao = isset($_POST["profissao"]) ? $_POST["profissao"] : '';
                                $bio = isset($_POST["bio"]) ? $_POST["bio"] : '';
                                $linkFoto = isset($enderecoArquivoDestino) ? $enderecoArquivoDestino : '';
                        
                                $sql = "INSERT INTO bio (nome, idade, profissao, bio, foto) 
                                VALUES ('" . $nome . "', " . $idade . ", '" . $profissao . "' , '" . $bio . "', '" . $linkFoto . "')";
                                if (mysqli_query($conn, $sql)){
                               		http_response_code(200);
                                }else{
                                	throw new Exception ("");
                                }
                            
                            }catch(Exception $EX){
                                http_response_code(500);
                            }
                        }

                        if($_SERVER["REQUEST_METHOD"] == "POST"){
                            realizaCadastro();
                        }else{
                    ?>

<head>
	<title>Grupo Jean | Cadastrar novo</title>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="estilos/genericStyle.css">
	<link rel="stylesheet" href="estilos/cadastroStyle.css">

	<script type = "application/javascript">

		class CaixaMensagemEnvio {
			criarCaixa(mensagem){
				let canvasMensagem = document.createElement('div');
				canvasMensagem.id = 'canvasMensagens'
				canvasMensagem.classList.add('canvasMensagem');

				let caixaMensagem = document.createElement('div');
				caixaMensagem.id = 'caixaMensagem'
				caixaMensagem.classList.add('caixaMensagem');
				caixaMensagem.classList.add('caixaMensagemNeutra');
				caixaMensagem.innerHTML = mensagem;
				
				let caixaComponente = document.createElement('div');
				caixaComponente.id = 'caixaComponente'
				caixaComponente.classList.add('caixaComponente');
				caixaMensagem.appendChild(caixaComponente);

				canvasMensagem.appendChild(caixaMensagem);
				document.body.appendChild(canvasMensagem);
			}


			atualizarMensagemErro(mensagem){
				let caixaMensagem = document.getElementById('caixaMensagem');
				caixaMensagem.classList.remove('caixaMensagemNeutra');
				caixaMensagem.classList.add('caixaMensagemErro');
				caixaMensagem.innerHTML = mensagem;

				setTimeout(()=> this.destruir(), 1000);
			}

			atualizarMensagemSucesso(mensagem, eventoFechar){
				let caixaMensagem = document.getElementById('caixaMensagem');
				caixaMensagem.classList.remove('caixaMensagemNeutra');
				caixaMensagem.classList.add('caixaMensagemSucesso');
				caixaMensagem.innerHTML = mensagem;
				
				setTimeout(()=> {
					this.destruir().then(()=> window.open('index.php', '_self'));
				}, 1000);
			}

			async destruir(){
				document.getElementById('canvasMensagens').remove();
			}

		}

		class Servico {
			constructor(){
				this.caixaMensagem = new CaixaMensagemEnvio();
			}

			async cadastraBio(){
				this.caixaMensagem.criarCaixa('Cadastrando...')

				
				setTimeout(()=>{
					const fotoUpload = document.getElementById('fotoUpload').files[0];
					const nomeForm =  document.getElementById('nomeForm').value;
					const idadeForm =  document.getElementById('idadeForm').value;
					const profissaoForm =  document.getElementById('profissaoForm').value;
					const bioForm =  document.getElementById('bioForm').value;

					let formData = new FormData();           
					formData.append('file', fotoUpload);
					formData.append('nome', nomeForm);
					formData.append('idade', idadeForm);
					formData.append('profissao', profissaoForm);
					formData.append('bio', bioForm);

					fetch('./cadastro.php', {
						method: "POST", 
						body: formData
					}).then(response=>{
						response.status == 200 ? this.caixaMensagem.atualizarMensagemSucesso('Bio cadastrada com sucesso') : this.caixaMensagem.atualizarMensagemErro('Não foi possivel cadastrar a bio');	
					});   
				}, 2000);
			}

		}

	

		window.addEventListener('load', ()=>{
			document.getElementById('enviaDados').addEventListener('click', ()=>{
				new Servico().cadastraBio();
			});
		});
	</script>

</head>
<body>

	<div class = "canvasPrincipal">
		<div class= 'headerGenerico'>Adicionar nova bio</div>
		<div id="area" class= 'areaEdicao'>
			<div class= 'descrInput'>Foto</div>
			<div class= 'areaInput'><input id="fotoUpload" type="file" name="fotoUpload" class = "fotoInput" /></div>
			<div class= 'descrInput'>Nome</div>
			<div class= 'areaInput'><input id="nomeForm" type="text" name="nomeForm" class = "textInput" /></div>
			<div class= 'descrInput'>Idade</div>
			<div class= 'areaInput'><input id="idadeForm" type="number" name="idadeForm" class = "textInput" /></div>
			<div class= 'descrInput'>Profissao</div>
			<div class= 'areaInput'><input id="profissaoForm" type="text" name="profissaoForm" class = "textInput" /></div>
			<div class= 'descrInput'>Bio</div>
			<div class= 'areaInput'><textarea  id="bioForm"  name="bioForm" class = "textInput bioInput"></textarea></div>
		</div>
		<div id="enviaDados" class= 'botaoGenerico'>Cadastrar</div>
			
	</div>
	
</body>

                    <?php
                        }
                    ?>
