<?php

namespace sistema\Modelo;

use sistema\nucleo\Conexao; 

class CategoriasModelo {
     
    public function ler (): array {
        
        $query = "SELECT * FROM Categorias";
        $stmt = Conexao::getInstancia()->query($query);
        $resultado = $stmt->fetchAll();

        //var_dump($resultado);

        return $resultado;
    }

         
    public function lerCond (): array {
        
        $query = "SELECT * FROM Categorias WHERE idCategorias >= 2 AND status = 0";
        $stmt = Conexao::getInstancia()->query($query);
        $resultado = $stmt->fetch();

        //var_dump($resultado);

        return $resultado;
    }   

    public function lerId (int $id = null): array {

        if ($id != null) {
            $where = "WHERE idCategorias = {$id}";
        }

        else {
            $where = "";
        }

        $query = "SELECT * FROM Categorias {$where}";
        $stmt = Conexao::getInstancia()->query($query);
        $resultado = $stmt->fetchAll();

        //var_dump($resultado);

        return $resultado; //retorna arry de objetos
    }

    public function countEspecializado(string $exp = null): int {

        if ($exp != null) {
            $comWhere = "WHERE ".$exp;
        }
        
        $query = "SELECT COUNT(*) FROM Categorias ".$comWhere;
        $stmt = Conexao::getInstancia()->query($query);
        $resultado = $stmt->fetchColumn();

        //var_dump($resultado);

        return $resultado;
    }   

    public function posts(int $id): array {
        
        $query = "SELECT * FROM Posts WHERE categorias_id = {$id} ORDER BY idPosts DESC";
        $stmt = Conexao::getInstancia()->query($query);
        $resultado = $stmt->fetchAll();

        //var_dump($resultado);

        return $resultado;
    }


    public function inserir (array $dados):void {
        
        //echo $dados['titulo']; echo $dados['texto']; echo $dados['status'];
        $query = "INSERT INTO `Categorias` (`titulo`, `texto`, `status`) VALUES (?, ?, ?)";       
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute([$dados['titulo'], $dados['texto'], $dados['status']]);
    }

    public function atualizar (array $dados, int $id):void {
        
        //echo $dados['titulo']; echo $dados['texto']; echo $dados['status'];
        $query = "UPDATE Categorias SET titulo = ?, texto = ?, status = ? 
                  WHERE Categorias.idCategorias = ?"; 
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute([$dados['titulo'], $dados['texto'], $dados['status'], $id]);
    }

    public function deletar (int $id):void {
        
        //echo $dados['titulo']; echo $dados['texto']; echo $dados['status'];
        $query = "DELETE FROM Categorias WHERE `Categorias`.`idCategorias` = ?"; 
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute([$id]);
    }

    public function total ():int {
        
        //echo $dados['titulo']; echo $dados['texto']; echo $dados['status'];
        $query = "SELECT COUNT(*) FROM Categorias"; 
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute();
        
        //var_dump($stmt->fetchColumn());

        return $stmt->fetchColumn();
    }
}
?>