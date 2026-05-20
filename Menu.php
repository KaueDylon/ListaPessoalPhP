<?php

class Menu{

    public function __construct(
        private UsuarioRepository $usuarioRepository
    )
    {}

    public function menu($usuarioRepository)
    {

        echo "+----------------------------+\n";
        echo "|           MENU\n";
        echo "+----------------------------+\n";
        echo "| 1 - Listar\n";
        echo "| 2 - Criar\n";
        echo "| 3 - Editar\n";
        echo "| 4 - Excluir\n";
        echo "| 5 - Sair\n";
        echo "+----------------------------+\n";
        echo ("> SELECIONE: ");

        while (true){
            $valor = readline();

            $resultado = match ((int)$valor) {
                1 => $this->listar($usuarioRepository),
                2 => $this->criar($usuarioRepository),
                3 => $this->editar($usuarioRepository),
                4 => $this->excluir($usuarioRepository),
                5 => exit(),
                default => 'Comando Inválido',
            };

            echo $resultado . PHP_EOL;
        }

    }

    public function listar($usuarioRepository)
    {
        echo "+----------------------------+\n";
        echo "|         USUARIOS\n";
        echo "+----------------------------+\n";
        $pag = 1;
        while(true){

            $resultado = $usuarioRepository->listar($pag,5);

            $usuarios = $resultado['usuarios'];
//            $total = $resultado['quantidade'];
            $totalPaginas = $resultado['totalPaginas'];

            foreach ($usuarios as $usuario){

                echo "| Id) ". $usuario->getId() ." - ". $usuario->getNome() ." - " . $usuario->getEmail() ."\n";
            }
            echo "| -- Total de Pág.: " . $totalPaginas;
            echo "\n";
            echo "+----------------------------+\n";
            echo "|     *".$pag."  (<)  PÁG  (>)  ".($pag+1)."\n";
            echo "|        > VOLTAR? (S)\n";
            echo "+----------------------------+\n";

                $valor = readline();
                $resultado = match (mb_strtoupper($valor)) {
                    "S" => $this->menu($usuarioRepository),
                    ">" => $pag += 1,
                    "<" => $pag -= 1,
                    default => 'desconhecido',
                };

                echo $resultado .PHP_EOL;

        }

    }

    public function criar($usuarioRepository){
        echo "+----------------------------+\n";
        echo "|       CRIAR USUARIO\n";
        echo "+----------------------------+\n";
        echo "| > INSIRA O NOME DO USUÁRIO:\n";
        echo "| ". $nome = readline();
        echo "\n| > INSIRA O EMAIL DO USUÁRIO:\n";
        echo "| ". $email = readline();
        echo "\n| > INSIRA A SENHA DO USUÁRIO:\n";
        echo "| ". $senha = readline();
        echo "\n+----------------------------+\n";
        $novoUsuario = new UsuarioEntity(null, $nome, $email, $senha);

        if ($usuarioRepository->criar($novoUsuario)){
            echo "| > USUÁRIO CRIADO COM \n";
            echo "|   SUCESSO.";
        }else{
            echo "| ERRO AO CRIAR USUÁRIO (fazer exception).";
        }

        echo "\n+----------------------------+\n";
        echo "|  > VOLTAR? (1) | > NOVO CAD.? (2) \n";
        echo "+----------------------------+\n";

        $valor = readline();

        $resultado = match ($valor) {
            "1" => $this->menu($usuarioRepository),
            "2" => $this->criar($usuarioRepository),
            default => 'desconhecido',
        };

    }

    public function editar($usuarioRepository){
        echo "+----------------------------+\n";
        echo "|       EDITAR USUARIO\n";
        echo "+----------------------------+\n";
        echo "| > INSIRA O ID DO USUÁRIO:\n";
        echo "| ". $id = readline();
        $editarUsuario = null;
        $nomeUsuario = null;
        $emailUsuario = null;
         try{

             $editarUsuario = $usuarioRepository->buscarPorId($id);

             $nomeUsuario = $editarUsuario->getNome();
             $emailUsuario = $editarUsuario->getEmail();

         }catch(IdNaoEncontratoException $e){
             echo PHP_EOL. $e->getMessage() .PHP_EOL;
         }


        echo "\n| ";
        echo "". $emailUsuario ." - " . $nomeUsuario ."\n";
        echo "+----------------------------+\n";
        echo "| > CONFIRME O USUÁRIO\n";
        echo "|   PARA CONTINUAR:\n";
        echo "|   VOLTAR? (1) | EDT. OUTRO? (2)\n";
        echo "|   CONFIRMAR? (3) \n";

        $valor = readline();

        $resultado = match ($valor) {
            "1" => $this->menu($usuarioRepository),
            "2" => $this->editar($usuarioRepository),
            "3" => '...',
        };

        echo "+----------------------------+\n";
        echo "| > INSIRA O NOME DO USUÁRIO\n";
        echo "|   OU DEIXE VAZIO:\n";
        echo "| ". $nome = readline();
        echo "\n| > INSIRA O EMAIL DO USUÁRIO\n";
        echo "|   OU DEIXE VAZIO:\n";
        echo "| ".  $email = readline();
        echo "\n+----------------------------+\n";

        if (!empty($nome)){
            $editarUsuario->setNome($nome);
        }

        if (!empty($email)){
            $editarUsuario->setEmail($email);
        }

        if($usuarioRepository->atualizar($editarUsuario)){
            echo "|  USUÁRIO EDITADO COM SUCESSO     ";
            echo "\n+----------------------------+\n";

        }

        echo "|  > VOLTAR? (1) | > NOVO EDT.? (2) \n";
        echo "+----------------------------+\n";

        $valor = readline();

        $resultado = match ($valor) {
            "1" => $this->menu($usuarioRepository),
            "2" => $this->editar($usuarioRepository),
            "3" => '...',
        };
    }


    public function excluir($usuarioRepository){
        echo "+----------------------------+\n";
        echo "|       EXCLUIR USUÁRIO\n";
        echo "+----------------------------+\n";
        echo "| > INSIRA O ID DO USUÁRIO:\n";
        echo "| ". $id = readline();
        $deletarUsuario = null;
        $nomeUsuario = null;
        $emailUsuario = null;
        try{

            $deletarUsuario = $usuarioRepository->buscarPorId($id);

            $nomeUsuario = $deletarUsuario->getNome();
            $emailUsuario = $deletarUsuario->getEmail();

        }catch(IdNaoEncontratoException $e){
            echo PHP_EOL. $e->getMessage() .PHP_EOL;
        }

        echo "\n| ";
        echo "". $nomeUsuario ." - " . $emailUsuario ."\n";
        echo "+----------------------------+\n";
        echo "| > CONFIRME O USUÁRIO\n";
        echo "|   PARA CONTINUAR:\n";
        echo "|   VOLTAR? (1) | EXC. OUTRO? (2)\n";
        echo "|   CONFIRMAR? (3) \n";

        $valor = readline();

        $resultado = match ($valor) {
            "1" => $this->menu($usuarioRepository),
            "2" => $this->excluir($usuarioRepository),
            "3" => '...',
        };

        $usuarioRepository->excluir($deletarUsuario->getId());
        echo "\n+----------------------------+\n";
        echo "|  USUÁRIO EXCLUIDO COM SUCESSO   ";
        echo "\n+----------------------------+\n";
        echo "|  > VOLTAR? (1) | > NOVO EXC.? (2) \n";
        echo "+----------------------------+\n";

        $valor = readline();

        $resultado = match ($valor) {
            "1" => $this->menu($usuarioRepository),
            "2" => $this->excluir($usuarioRepository),
            "3" => '...',
        };
    }

}