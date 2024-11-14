<?php

namespace sistema\Modelo;

require_once 'sistema/Suporte/Conexao.php';

use sistema\Suporte\Conexao;

class TurmasModelo
{

    public function ler(string $termos = null): array
    {

        if ($termos == null) {
            $clausula = "";
        } else {
            $clausula = $termos;
        }

        $query = "SELECT * FROM tb_turmas " . $clausula;
        $stmt = Conexao::getInstancia()->query($query);
        $resultado = $stmt->fetchAll();

        return $resultado;
    }

    public function contar(): int
    {

        $query = "SELECT COUNT(*) FROM tb_turmas";
        $stmt = Conexao::getInstancia()->query($query);
        $resultado = $stmt->fetchColumn();

        return $resultado;
    }

    public function inserir(array $dados): void
    {

        $query = "INSERT INTO `tb_turmas` (`nome`, `tb_professor_id`, `tb_materia_id`) VALUES (?, ?, ?)";
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute([$dados['nome'], $dados['tb_professor_id'], $dados['tb_materia_id']]);
    }

    public function atualizar(array $dados, int $id): void
    {

        $query = "UPDATE tb_turmas SET nome = ?, tb_professor_id = ?, tb_materia_id = ? WHERE id = ?";
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute([$dados['nome'], $dados['tb_professor_id'], $dados['tb_materia_id'], $id]);
    }

    public function deletar(int $id): void
    {

        $query = "DELETE FROM tb_turmas WHERE id = ?";
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute([$id]);
    }
}
