<?php
 Class Usuarios {
	private $pdo;  /*criando variavel para usar nas funçoes*/
	public $msgErro="";
	public $id=0;
	
	public function conectar(){
		error_reporting(E_ALL);
        ini_set('display_errors',1);
  		global $pdo;
      	global $msgErro;
		//@session_start();
		if (session_status() !== PHP_SESSION_ACTIVE) {
			session_start();
		}

		//Credenciais de acesso BD
		define('HOST', 'database');
		define('USER', 'root');
		define('PASS', 'root');
		define('DBNAME', 'palpit');

  		try{
		  	$pdo = new PDO('mysql:host='.HOST.';dbname='.DBNAME.';',USER,PASS);

			return $pdo;
  		} catch (PDOException $e){
  			echo ($msgErro . $e->getMessage()); /*pega a mensagem de erro do php e joga na variavel msegErro e mostra pro usuario.*/
  		}
  	}

  	public function cadastrar($nome, $email, $senha, $receber, $confirmacao){
      error_reporting(E_ALL);
      ini_set('display_errors',1);
  	  global $pdo;
      global $msgErro;
	  $foto_p = "assets\img\icon\avatar.svg";
  		//verificando se existe usuario cadastrado.
  		$sql = $pdo->prepare("SELECT id_usuario FROM usuario WHERE email=:e"); //pega o id do usuario buscando pelo emial preenchido no cadastro
  		$sql->bindValue(":e", $email);  //substitui o :e pelo email preenchido no cadastro
  		$sql->execute();
		
  		if($sql->rowCount()>0){ //verificando houve resposta na consulta
			return false; // ja tem cadastro
  		}
  		else{
  			//caso nao tenha
  			$sql = $pdo->prepare("INSERT INTO usuario (nome, email, senha, receber, confirmacao, foto_p) VALUES (:n, :e,:s, :r, :c, :fp)");
	  		$sql->bindValue(":n", $nome);
	  		$sql->bindValue(":e", $email);
			//$sql->bindValue(":p", $profissao);
	  		$sql->bindValue(":s", md5($senha));
			$sql->bindValue(":r", $receber);
			$sql->bindValue(":c", $confirmacao);
			$sql->bindValue(":fp", $foto_p);
			$sql->execute();
					
			return true;
  		}

  	}

  	public function logar($email, $senha){
		error_reporting(E_ALL);
        ini_set('display_errors',1);
  	  global $pdo;
      global $msgErro;
  		/*verificar se o email e senha estao cadastrados, se sim*/
  		$sql= $pdo->prepare("SELECT id_usuario, nome, email, sobre, cidade, receber, foto_p  FROM usuario WHERE email=:e AND senha=:s AND confirmacao=0");
  		$sql->bindValue(":e", $email);
  		$sql->bindValue(":s", md5($senha));
  		$sql->execute();
  		if($sql->rowCount()>0) //verificando houve resposta na consulta
  		{
  			//entrar no sistema criando uma (sessao)
  			$dado = $sql->fetch(); //transforma o retorno da query em array com os nomes das colunas
  			//session_start();  //iniciando a sessao
  			$_SESSION['id_usuario'] = $dado['id_usuario']; //armazena o id do usuario na sessao.
			$_SESSION['nome'] = $dado['nome'];
			$_SESSION['email'] = $dado['email'];
			$_SESSION['sobre'] = $dado['sobre'];
			$_SESSION['cidade'] = $dado['cidade'];
			$_SESSION['receber'] = $dado['receber'];
			$_SESSION['foto_p'] = $dado['foto_p'];
			return true;  //logado com sucesso
  		}
  		else
  		{
  			return false; //erro ao logar.
  		}
  	}

	public function enviar($titulo, $descricao, $foto_v, $foto_t, $status)
  	{
		error_reporting(E_ALL);
        ini_set('display_errors',1);
  		global $pdo;
      	global $msgErro;
				  		
  		$sql= $pdo->prepare("INSERT INTO arquivo (titulo, descricao, foto_v, foto_t, id_usuario_fk, status) VALUES (:t, :d, :fv, :ft,:fku, :s)");
  		$sql->bindValue(":t", $titulo);
		$sql->bindValue(":d", $descricao);
		$sql->bindValue(":fv", $foto_v);
		$sql->bindValue(":ft", $foto_t);
		$sql->bindValue(":fku", $_SESSION['id_usuario']);
		$sql->bindValue(":s", $status);
  		$sql->execute();
		$_SESSION['id_arquivo'] = $pdo->lastInsertId();
		return true;  
  		
  	}
	

	public function confirmar($email, $codigo){
		error_reporting(E_ALL);
        ini_set('display_errors',1);
		global $pdo;
		
		$sql= $pdo->prepare("SELECT id_usuario FROM usuario WHERE email=:e AND confirmacao=:c");
		$sql->bindValue(":e", $email);
  		$sql->bindValue(":c", ($codigo));
		$sql->execute();

		if($sql->rowCount()>0) //verificando houve resposta na consulta
  		{
			$sql = $pdo->prepare('UPDATE usuario SET confirmacao=\'0\' WHERE confirmacao=:c AND email=:e');
			$sql->bindValue(":c", $codigo);
			$sql->bindValue(":e", $email);
			$sql->execute();
  			return true;  //logado com sucesso
  		}
  		else
  		{
  			return false; //erro ao logar.
  		}

	}

	public function alterarperfil($nome,$sobre,$cidade,$receber,$foto_p,$area){
		error_reporting(E_ALL);
        ini_set('display_errors',1);
		global $pdo;
		global $msgErro;

		$uarea= $pdo->prepare("UPDATE assoc_area asa SET asa.id_area_fk = :afk WHERE id_usuario_fk = :ufk");
		$uarea->bindValue(":afk", $area);
		$uarea->bindValue(":ufk", $_SESSION['id_usuario']);
		$uarea->execute();
		
		if($foto_p != null){
			
			$sql= $pdo->prepare("UPDATE usuario SET nome = :n, sobre = :s, cidade = :c, receber = :r, foto_p = :fp WHERE id_usuario = :id");
			$sql->bindValue(":n", $nome);
			$sql->bindValue(":s", $sobre);
			$sql->bindValue(":c", $cidade);
			$sql->bindValue(":r", $receber);
			$sql->bindValue(":fp", $foto_p);
			$sql->bindValue(":id", $_SESSION['id_usuario']);
			$sql->execute();

			//atualizar dados
			$_SESSION['nome'] = $nome;
			$_SESSION['sobre'] = $sobre;
			$_SESSION['cidade'] = $cidade;
			$_SESSION['receber'] = $receber;
			$_SESSION['foto_p'] = $foto_p;
			$_SESSION['area'] = $area;
		 
		}else{
			$sql= $pdo->prepare("UPDATE usuario SET nome = :n, sobre = :s, cidade = :c, receber = :r WHERE id_usuario = :id");
			$sql->bindValue(":n", $nome);
			$sql->bindValue(":s", $sobre);
			$sql->bindValue(":c", $cidade);
			$sql->bindValue(":r", $receber);
			$sql->bindValue(":id", $_SESSION['id_usuario']);
			$sql->execute();

			//atualizar dados
			$_SESSION['nome'] = $nome;
			$_SESSION['sobre'] = $sobre;
			$_SESSION['cidade'] = $cidade;
			$_SESSION['receber'] = $receber;
			$_SESSION['area'] = $area;
		}
		return true; 
  	}

	public function logout(){
		error_reporting(E_ALL);
        ini_set('display_errors',1);
		//remove as variaveis da sessão
		unset($_SESSION['id_usuario']);
		unset($_SESSION['nome']);
		unset($_SESSION['email']);
		unset($_SESSION['area']);
		unset($_SESSION['cidade']);
		unset($_SESSION['foto_p']);
		unset($_SESSION['sobre']);

	}
	
}
