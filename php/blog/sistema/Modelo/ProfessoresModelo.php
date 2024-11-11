<?php

namespace sistema\Modelo;

require_once 'sistema/Suporte/Conexao.php';

use sistema\Suporte\Conexao;

class ProfessoresModelo {

    public function ler(string $termos = null): array {

        if ($termos == null) {
            $clausula = "";
        }

        else {
            $clausula = $termos;
        }

        $query = "SELECT * FROM tb_professores ".$clausula;
        $stmt = Conexao::getInstancia()->query($query);
        $resultado = $stmt->fetchAll();

        return $resultado;
    }

    public function contar(): int {

        $query = "SELECT COUNT(*) FROM tb_professores";
        $stmt = Conexao::getInstancia()->query($query);
        $resultado = $stmt->fetchColumn();

        return $resultado;
    }

    public function inserir(array $dados): void {

        $query = "INSERT INTO `tb_professores` (`nome`, `nascimento`, 'admissao', `tb_user_id`) VALUES (?, ?, ?, ?)";       
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute([$dados['nome'], $dados['nascimento'], $dados['admissao'], $dados['tb_user_id']]);     
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