<?php

namespace sistema\Modelo;

require_once '../Suporte/Conexao.php';

use sistema\Suporte\Conexao;

class UsuarioModelo {

    public function ler(string $termos = null): array {

        if ($termos == null) {
            $clausula = "";
        }

        else {
            $clausula = $termos;
        }

        $query = "SELECT * FROM tb_users ".$clausula;
        $stmt = Conexao::getInstancia()->query($query);
        $resultado = $stmt->fetchAll();

        return $resultado;
    }

    public function contar(): int {

        $query = "SELECT COUNT(*) FROM tb_users";
        $stmt = Conexao::getInstancia()->query($query);
        $resultado = $stmt->fetchColumn();

        return $resultado;
    }

    public function contarEm(string $email): int {

        $query = "SELECT COUNT(*) FROM tb_users WHERE email = ?";
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute([$email]);
        
        // Obter o resultado (contagem de registros)
        $resultado = $stmt->fetchColumn();
        
        return (int) $resultado; // Retorna o número de ocorrências
    }

    public function lerEm(string $email): ?array {

        $query = "SELECT * FROM tb_users WHERE email = ?";
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute([$email]);
        $resultado = $stmt->fetch(); 
        
        return $resultado ? (array) $resultado : null;
    }

    public function inserir(array $dados): void {

        $passwordHash = password_hash($dados['password'], PASSWORD_DEFAULT);

        $query = "INSERT INTO `tb_users` (`email`, `password`, `role`) VALUES (?, ?, ?)";       
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute([$dados['email'], $passwordHash, $dados['role']]);     
    }

    public function atualizar (array $dados, int $id):void {
        
        $query = "UPDATE tb_professores SET nome = ?, nascimento = ?, admissao = ?, tb_user_id = ? WHERE id = ?"; 
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute([$dados['nome'], $dados['nascimento'], $dados['admissao'], $dados['tb_user_id'], $id]);
    }

    public function deletar (int $id):void {
        
        $query = "DELETE FROM tb_professores WHERE id = ?"; 
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute([$id]);
    }




}

?>