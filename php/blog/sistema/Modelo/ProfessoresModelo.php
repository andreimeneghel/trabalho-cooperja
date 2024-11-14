<?php

namespace sistema\Modelo;

require_once 'sistema/Suporte/Conexao.php';

use sistema\Suporte\Conexao;

class ProfessoresModelo
{

    public function ler(string $termos = null): array
    {

        if ($termos == null) {
            $clausula = "";
        } else {
            $clausula = $termos;
        }

        $query = "SELECT * FROM tb_professores " . $clausula;
        $stmt = Conexao::getInstancia()->query($query);
        $resultado = $stmt->fetchAll();

        return $resultado;
    }

    public function contar(): int
    {

        $query = "SELECT COUNT(*) FROM tb_professores";
        $stmt = Conexao::getInstancia()->query($query);
        $resultado = $stmt->fetchColumn();

        return $resultado;
    }

    public function inserir(array $dados): void
    {

        $query = "INSERT INTO `tb_professores` (`nome`, `nascimento`, 'admissao', `tb_user_id`) VALUES (?, ?, ?, ?)";
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute([$dados['nome'], $dados['nascimento'], $dados['admissao'], $dados['tb_user_id']]);
    }

    public function atualizar(array $dados, int $id): void
    {

        $query = "UPDATE tb_professores SET nome = ?, nascimento = ?, admissao = ?, tb_user_id = ? WHERE id = ?";
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute([$dados['nome'], $dados['nascimento'], $dados['admissao'], $dados['tb_user_id'], $id]);
    }

    public function deletar(int $id): void
    {

        $query = "DELETE FROM tb_professores WHERE id = ?";
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute([$id]);
    }

    public function lerTudo(int $id): ?array
    {
        $query = "SELECT 
                    p.id AS professor_id,
                    p.nome AS professor_nome,
                    p.nascimento AS professor_nascimento,
                    p.admissao AS professor_admissao,
                    u.email AS professor_username,    
                    u.password AS professor_senha,    
                    GROUP_CONCAT(t.nome ORDER BY t.nome) AS turmas, 
                    GROUP_CONCAT(m.nome ORDER BY m.nome) AS materias  
                FROM 
                    tb_professores p
                JOIN 
                    tb_users u ON p.tb_user_id = u.id
                LEFT JOIN 
                    tb_turmas t ON p.id = t.tb_professor_id
                LEFT JOIN 
                    tb_materias m ON t.tb_materia_id = m.id
                WHERE 
                    u.id = ? 
                GROUP BY 
                    p.id, u.email, u.password;
                ";

        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute([$id]);
        $resultado = $stmt->fetch();

        return $resultado ? (array) $resultado : null;
    }
}
