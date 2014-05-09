<?php

// namespace de localizacao do nosso model
namespace Contato\Model;

// import Zend\Db
use //Zend\Db\Adapter\Adapter,
    //Zend\Db\ResultSet\ResultSet,
    Zend\Db\TableGateway\TableGateway;

class ContatoTable
{

    protected $tableGateway;

    /**
     * Contrutor com dependencia da classe TableGateway
     * 
     * @param \Zend\Db\TableGateway\TableGateway $tableGateway
     */
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * Recuperar todos os elementos da tabela contatos
     * 
     * @return ResultSet
     */
    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    /**
     * Localizar linha especifico pelo id da tabela contatos
     * 
     * @param type $id
     * @return \Model\Contato
     * @throws \Exception
     */
    public function find($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row)
            throw new \Exception("Não foi encontrado contado de id = {$id}");

        return $row;
    }

    /**
     * Inserir um novo contato
     * 
     * @param \Contato\Model\Contato $contato
     * @return id
     */
    public function save(Contato $contato)
    {
        $timeNow = new \DateTime();
        
        $data = [
            'nome'                  => $contato->nome,
            'telefone_principal'    => $contato->telefone_principal,
            'telefone_secundario'   => $contato->telefone_secundario,
            'data_criacao'          => $timeNow->format('Y-m-d H:i:s'), 
            'data_atualizacao'      => $timeNow->format('Y-m-d H:i:s'), # data de criação igual a de atualização 
        ];
        
        return $this->tableGateway->insert($data);
    }
    
    /**
     * Atualizar um contato existente
     * 
     * @param \Contato\Model\Contato $contato
     * @throws \Exception
     */
    public function update(Contato $contato)
    {
        $timeNow = new \DateTime();
        
        $data = [
            'nome'                  => $contato->nome,
            'telefone_principal'    => $contato->telefone_principal,
            'telefone_secundario'   => $contato->telefone_secundario, 
            'data_atualizacao'      => $timeNow->format('Y-m-d H:i:s'),
        ];
        
        $id = (int) $contato->id;
        if ($this->find($id)) {
            $this->tableGateway->update($data, array('id' => $id));
        } else {
            throw new \Exception("Contato #{$id} inexistente");
        }
    }
    
    /**
     * Deletar um contato existente
     * 
     * @param type $id
     */
    public function delete($id)
    {
        $this->tableGateway->delete(array('id' => (int) $id));
    }
    
    /**
     * Contabilizar os elementos da tabela contatos
     * 
     * @return int
     */
    public function count()
    {
        return $this->tableGateway->select()->count();
    }
}
