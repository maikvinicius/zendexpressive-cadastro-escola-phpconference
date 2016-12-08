<?php
namespace App\Model;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

class Aluno
{
    private $matricula;
    private $nome;
    
    /**
     * @var ContainerInterface
     */
    
    private static $dbAdapter;
    
    /**
     * @param AdapterInterface $dbAdapter
     */
    public static function setDbAdapter(AdapterInterface $dbAdapter)
    {
        self::$dbAdapter = $dbAdapter;
    }
    
    /**
     * @param array $array
     */
    
    public function  __construct(array $array)
    {
        $this->matricula = $array['matricula'];
        $this->nome = $array['nome'];
    }
    
    public static function get($matricula)
    {
        $results = self::getAll([
            'matricula'
            => $matricula]);
        return
        $results->current();
    }
    
    public static function getAll($where = null)
    {
        $sql = new Sql(self::$dbAdapter);
        $select = $sql->select('alunos');
        if
        ($where !== null){
            $select->where($where);
        }
        $statement = $sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        return $results;
    }
    
    
    public function save(){
        $sql = new Sql(self::$dbAdapter);
        if(empty($this->matricula)){
            
            $sqlObject = $sql->insert('alunos');
            $sqlObject->columns(['nome'])->values([$this->nome]);
        }
        else
        {
            $sqlObject = $sql->update('alunos');
            $sqlObject->set(['matricula'=> $this->matricula,'nome'=> $this->nome]);
            $sqlObject->where(['matricula'=> $this->matricula]);
        }
        $statement = $sql->prepareStatementForSqlObject($sqlObject);
        return $statement->execute();
    }
    
    public static function delete($matricula)
    {
        $sql = new Sql(self::$dbAdapter);
        $sqlObject = $sql->delete('alunos');
        $sqlObject->where(['matricula'=> $matricula]);
        $statement = $sql->prepareStatementForSqlObject($sqlObject);
        return $statement->execute();
    }
    
}

?>