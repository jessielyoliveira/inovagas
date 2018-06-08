<?php
require_once("Repository.php");
class VagaRepository extends Repository {
    public function criar($dados) {
     $dados['prazo_inscricoes'] = converter_data($_POST['prazo_inscricoes']);
        try {
            $this->connection->getPDO()->beginTransaction();
            $this->connection->execute("INSERT INTO vaga(remuneracao, prazo_inscricoes, area, descricao, titulo, carga_horaria, meses_duracao, data_cadastro) #add idEmpresa ainda
            VALUES (:remuneracao, :prazo_inscricoes, :area, :descricao, :titulo, :carga_horaria, :meses_duracao, NOW())", [
                ':remuneracao' => $dados['remuneracao'],
                ':prazo_inscricoes' => $dados['prazo_inscricoes'],
                ':area' => $dados['area'],
                ':descricao' => $dados['descricao'],
                ':titulo' => $dados['titulo'],
                ':carga_horaria' => $dados['carga_horaria'],
                ':meses_duracao' => $dados['meses_duracao']
            ]);
            $this->connection->getPDO()->commit();
            return true;
        }
        catch(Exception $e) {
            $this->connection->getPDO()->rollBack();
            echo $e->getMessage();
            return false;
        }
    }

    public function listar(){
        $query = "SELECT * FROM vaga";
         try {
            $result = $this->connection->execute($query);
            return $result;
        }
        catch(Exception $e) {
            throw new Exception("Erro: " . $e->getMessage());
        }
    }

    public function buscarPorId($idvaga) {
        $query = "SELECT * FROM vaga WHERE idvaga = :idvaga";
        try {
            $result = $this->connection->execute($query, [
                'idvaga' => $idvaga
            ]);
        }
        catch(Exception $e) {
            throw new Exception("Erro: " . $e->getMessage());
        }
        if(count($result) > 0) {
            return $result[0];
        }
        else {
            return null;
        }
    }
}