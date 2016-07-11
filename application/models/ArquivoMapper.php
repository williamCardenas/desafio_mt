<?php

class Application_Model_ArquivoMapper
{
  protected $_dbTable;

  public function setDbTable($dbTable)
  {
    if (is_string($dbTable)) {
      $dbTable = new $dbTable();
    }
    if (!$dbTable instanceof Zend_Db_Table_Abstract) {
      throw new Exception('Invalid table data gateway provided');
    }
    $this->_dbTable = $dbTable;
    return $this;
  }

  public function getDbTable()
  {
    if (null === $this->_dbTable) {
      $this->setDbTable('Application_Model_DbTable_Arquivo');
    }
    return $this->_dbTable;
  }

  public function save(Application_Model_Arquivo $arquivo)
  {
    $data = array(
      'name'   => $arquivo->getName(),
      'created' => date('Y-m-d H:i:s'),
      'updated' => date('Y-m-d H:i:s'),
    );

    if (null === ($id = $arquivo->getId())) {
      unset($data['id']);
      $this->getDbTable()->insert($data);
    } else {
      unset($data['created']);
      $this->getDbTable()->update($data, array('id = ?' => $id));
    }
  }

  public function find($id, Application_Model_Arquivo &$arquivo)
  {
    $result = $this->getDbTable()->find($id);
    if (0 == count($result)) {
      return;
    }
    $row = $result->current();
    $arquivo->setId($row->id)
    ->setName($row->name)
    ->setCreated($row->created)
    ->setUpdated($row->updated);
  }

  public function fetchAll()
  {
    $resultSet = $this->getDbTable()->fetchAll(
    $this->getDbTable()->select()->order('id')
  );
  $entries   = array();
  foreach ($resultSet as $row) {
    $entry = new Application_Model_Arquivo();
    $entry->setId($row->id)
    ->setName($row->name)
    ->setCreated($row->created)
    ->setUpdated($row->updated);
    $entries[] = $entry;
  }
  return $entries;
}

}
