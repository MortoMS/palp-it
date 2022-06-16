
<?php
require_once 'classes/usuarios.php';
include "email.php";

$u = new Usuarios;
//$u -> conectar();

//session_start();

//verificar se variavel foi iniciada
if(isset($_POST['nome'])){

	//Recupera informação do formulario
	$nome = addslashes($_POST['nome']); //addslashes evita codigos maliciosos.
	$email = addslashes($_POST['email']);
	//$profissao = addslashes($_POST['profissao']);
	$senha = addslashes($_POST['senha']);
	$area = addslashes($_POST['area']);
	$receber = addslashes(isset($_POST['receber'])) ? true : null;
	$confirmacao = rand (1, getrandmax ());
	
		$u->conectar(); //Conecta ao banco de dados
		if ($u->msgErro==""){
    		$pdo->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);//Ativa o lançamento de exceptions para erros
			$pdo->beginTransaction(); //inicia uma transação
			if ($u->cadastrar($nome, $email, $senha, $receber, $confirmacao)){
				$sql = $pdo->prepare("SELECT id_usuario FROM usuario WHERE email=:e"); //pega o id do usuario buscando pelo emial preenchido no cadastro
  				$sql->bindValue(":e", $email);  //substitui o :e pelo email preenchido no cadastro
  				$sql->execute();
				if($sql->rowCount()>0) //verificando houve resposta na consulta
  				{
  				//entrar no sistema criando uma (sessao)
  				$dado = $sql->fetch(); //transforma o retorno da query em array com os nomes das colunas
  				//session_start();  //iniciando a sessao
  				$id_u = $dado['id_usuario']; //armazena o id do usuario na sessao.
  				}				
				$interesse = $pdo->prepare("SELECT id_area FROM area WHERE nome_area=:na");
				$interesse->bindValue(":na", $area);
				$interesse->execute();
				$resultado = $interesse->fetchAll(PDO::FETCH_OBJ);
				$id_area =(int)$resultado[0]->id_area;
				$assoc_a = $pdo->prepare("INSERT INTO assoc_area (id_usuario_fk, id_area_fk) VALUES (:ufk, :afk)");
				$assoc_a->bindValue(":ufk", $id_u);
				$assoc_a->bindValue(":afk", $id_area);
				$assoc_a->execute();
				//$enviaremail = smtpmailer ($_POST ['email'], 'baille.hub@gmail.com', 'PALP-it', 'Email de confirmação PALP-it', 'Clique no link para confirmar o seu email http://localhost/palp-it/palpit/confirmacao.php?codigo='.$confirmacao.'&email='.$_POST ['email']);
				$enviaremail = smtpmailer ($_POST ['email'], 'baille.hub@gmail.com', 'PALP-it', 'Email de confirmação PALP-it', 'Clique no link para confirmar o seu email http://rnaat.ufpa.br/palp-it/palpit/confirmacao.php?codigo='.$confirmacao.'&email='.$_POST ['email']);
					if ($enviaremail) {
						$pdo->commit(); //envia uma transação
						?>
							<!DOCTYPE html>
								<html lang="pt">
								<head>
									<meta charset="UTF-8">
									<meta name="viewport" content="width=device-width, initial-scale=1.0">
									<title>Palp-it</title>
									<link rel="preconnect" href="https://fonts.googleapis.com">
									<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
									<link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;700&display=swap" rel="stylesheet">
									<link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet"> 
									<link rel="stylesheet" href="public/assets/css/base/base.css">
									<link rel="stylesheet" href="public/assets/css/componentes/cartao.css">
									<link rel="stylesheet" href="public/assets/css/componentes/inputs.css">
									<link rel="stylesheet" href="public/assets/css/componentes/botao.css">
								</head>
								<body>
									<main class="center container-xs">
										<div class="flex flex-coluna px-3">
											<section class=" cartao__container cartao-xs">
												<div class="border-bottom">
													<a href="inicio.php">
														<img src="assets/img/icon/Logo.svg" alt="Logo Palp-it"/>
													</a> 
													<h2 class="container--titulo mb-2">Falta pouco...</h2>
												</div>
												<p class="cartao-xs__txt my-3">  Para concluir seu cadastro, é necessário clicar no link de confirmação enviado para o endereço <a class="link" > <?php echo $email ?> </a>. </p>
												<a href="inicio.php"> <button class="botao--container botao--primario width-full">  Voltar para página inicial </button></a>
											</section>
										</div>
									</main>
								</body>
								</html>

						<?php
					} 
					else {
						$pdo->rollback();  //reverte uma transação
						$_SESSION['erro'] = 'Email de confirmação não enviado <br> contacte palp-it@ufpa.br';
						header("Location: cadastro.php");
					}
			}
			else{
				$_SESSION['erro'] = 'Já existe um usuário com o mesmo email.';
				header("Location: cadastro.php");
				?>
				<?php
			}
			
		}
		else{
			?>
			<div class="msg_erro">
				<?php echo "Erro: ".$u->msgErro;?>
			</div>
			<?php
		}
}
?>

