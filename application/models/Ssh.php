<?php

class Application_Model_Ssh
{
  private $connect;
  private $pass;
  public $host;
  public $port;
  public $user;

  function __construct($host,$user,$pass,$port = 22)
  {
    if (!function_exists("ssh2_connect")) die("function ssh2_connect doesn't exist");

    $this->host = $host;
    $this->port = $port;
    $this->user = $user;
    $this->pass = $pass;
    $this->connect();
  }

  private function connect()
  {
    $this->connect = ssh2_connect($this->host, $this->port);
    if($this->connect)
    {
      $this->login();
    }else{
      throw new Exception("Não foi possivel acessar o servidor");
    }
  }

  private function login()
  {
    if(!(ssh2_auth_password($this->connect, $this->user, $this->pass)))
    {
      throw new Exception("Não foi possivel acessar o servidor com as credenciais");
    }
  }

  public function exec($command)
  {
    $this->connect();
    return ssh2_exec($this->connect,$command);
  }
}
