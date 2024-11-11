<?php

namespace sistema\Modelo;

use Conexao;

class AlunoModelo {

    public function ler(string $termos = null): array {

        if ($termos == null) {
            $clausula = "";
        }

        else {
            $clausula = $termos;
        }

        $query = "SELECT * FROM tb_alunos ".$clausula;
        $stmt = Conexao::getInstancia()->query($query);
        $resultado = $stmt->fetchAll();

        return $resultado;
    }

    public function contar(): int {

        $query = "SELECT COUNT(*) FROM tb_alunos";
        $stmt = Conexao::getInstancia()->query($query);
        $resultado = $stmt->fetchColumn();

        return $resultado;
    }

    public function inserir(array $dados): void {

        $query = "INSERT INTO `tb_alunos` (`nome`, `nascimento`, `tb_user_id`, `tb_turma_id`) VALUES (?, ?, ?, ?)";       
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute([$dados['nome'], $dados['nascimento'], $dados['tb_user_id'], $dados['tb_turma_id']]);     
    }

    public function atualizar (array $dados, int $id):void {
        
        $query = "UPDATE tb_alunos SET nome = ?, nascimento = ?, tb_user_id = ?, tb_turma_id = ? WHERE id = ?"; 
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute([$dados['nome'], $dados['nascimento'], $dados['tb_user_id'], $dados['tb_turma_id'], $id]);
    }

    public function deletar (int $id):void {
        
        $query = "DELETE FROM tb_alunos WHERE id = ?"; 
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute([$id]);
    }




}

?>