<?php
class Application_Model_Arquivo
{
  protected $_name;
  protected $_created;
  protected $_updated;
  protected $_id;

  public function __construct(array $options = null)
  {
    if (is_array($options)) {
      $this->setOptions($options);
    }
  }

  public function __set($name, $value)
  {
    $method = 'set' . $name;
    if (('mapper' == $name) || !method_exists($this, $method)) {
      throw new Exception('Propriedade invalida');
    }
    $this->$method($value);
  }

  public function __get($name)
  {
    $method = 'get' . $name;
    if (('mapper' == $name) || !method_exists($this, $method)) {
      throw new Exception('Propriedade invalida');
    }
    return $this->$method();
  }

  public function setOptions(array $options)
  {
    $methods = get_class_methods($this);
    foreach ($options as $key => $value) {
      $method = 'set' . ucfirst($key);
      if (in_array($method, $methods)) {
        $this->$method($value);
      }
    }
    return $this;
  }

  public function setName($name)
  {
    $this->_name = $name;
    return $this;
  }

  public function getName()
  {
    return $this->_name;
  }

  public function setCreated($created)
  {
    $this->_created = $created;
    return $this;
  }

  public function getCreated()
  {
    return $this->_created;
  }

  public function setUpdated($updated)
  {
    $this->_updated = $updated;
    return $this;
  }

  public function getUpdated()
  {
    return $this->_updated;
  }

  public function setId($id)
  {
    $this->_id = $id;
    return $this;
  }

  public function getId()
  {
    return $this->_id;
  }

  public function getStatusFile()
  {
    $fileUpdateDate = new DateTime(date("Y-m-d H:i:s", filemtime(PUBLIC_PATH.'/upload//'.$this->_name)));
    $createdDate = new DateTime($this->_created);
    $updatedDate = new DateTime($this->_updated);
    $diferenceCreatedUpdated = $createdDate->diff($updatedDate);

    //o arquivo já foi modificado pelo usuario
    if(
    $diferenceCreatedUpdated->s > 0 ||
    $diferenceCreatedUpdated->i > 0 ||
    $diferenceCreatedUpdated->h > 0 ||
    $diferenceCreatedUpdated->d > 0 ||
    $diferenceCreatedUpdated->m > 0 ||
    $diferenceCreatedUpdated->y > 0
    )
    {
      return 'Arquivo modificado pelo usuario';
    }

    $diference = $fileUpdateDate->diff($updatedDate);
    if( $diference->s > 0 || $diference->i > 0 || $diference->h > 0 || $diference->d > 0 ||  $diference->m > 0 ||  $diference->y > 0)
    {
      return 'Arquivo sobreposto';
    }
    return 'Arquivo o original';
  }
}
