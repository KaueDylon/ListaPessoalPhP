<?php
//
//namespace repository;

//use entity\UsuarioEntity;

class UsuarioRepository
{
    public function __construct(private readonly PDO $pdo)
    {}


    public function criar(UsuarioEntity $usuario): bool{
        $stmt = $this->pdo->prepare(
            'INSERT INTO usuarios (nome, email, senha)
            VALUES (:nome, :email, :senha)'
        );

        $stmt->execute([

            ':nome' => $usuario->getNome(),
            ':email' => $usuario->getEmail(),
            ':senha' => $usuario->getSenha(),

        ]);

        return true;
    }


    public function buscarPorId(int $id): ?usuarioEntity{

        $stmt = $this->pdo->prepare(
            'SELECT id, nome, email FROM usuarios WHERE id = :id'
        );

        $stmt->execute([':id' => $id]);

        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$dados){
            throw new IdNaoEncontratoException();
        }

        return new UsuarioEntity(
            id: $dados['id'],
            nome: $dados['nome'],
            email: $dados['email'],
            senha: null);

}

    public function listar(int $pagina = 1, int $porPagina = 20): array {

        try {
            if ($pagina < 1){
                throw new PaginacaoException();
            }
        }catch (PaginacaoException $e){
            echo  "| ".$e->getMessage() . "\n";
            $pagina = 1;
        } finally {
            $offset = ($pagina - 1) * $porPagina;
        }


        $stmt = $this->pdo->prepare(
                'SELECT id, nome, email, (SELECT COUNT(id) as pag FROM usuarios) FROM usuarios
            ORDER BY id ASC LIMIT :limite OFFSET :offset'
            );
            $stmt->bindValue(':limite', $porPagina, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

            $stmt->execute();

            $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $quantidade = $dados[0]['pag'] ?? 0;

            $totalPaginas = ceil($quantidade / $porPagina);

            $arrayUsuarios = array_map(
                fn($row) => new UsuarioEntity(
                    $row['id'],
                    $row['nome'],
                    $row['email'],
                    null
                ),
                $dados
            );

            return [
                'usuarios' => $arrayUsuarios,
                'quantidade' => $quantidade,
                'totalPaginas' => $totalPaginas,
            ] ;

    }

    public function atualizar(UsuarioEntity $usuario): bool{
        $stmt = $this->pdo->prepare(
            'UPDATE usuarios SET nome = :nome, email = :email WHERE id = :id'
        );

        $stmt->execute([':id' => $usuario->getId(), ':nome' => $usuario->getNome(), ':email' => $usuario->getEmail()]);
        return $stmt->rowCount() > 0;
    }

    public function excluir(int $id): bool {
        $stmt = $this->pdo->prepare('DELETE FROM usuarios WHERE id = :id');
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount() > 0 ;
    }






}
