<?php

class Application_Form_SshLogin extends Zend_Form
{

  public function init()
  {
    // Set the method for the display form to POST
    $this->setMethod('post');

    $this->addElement('text', 'server', array(
      'label'      => 'Ip do servidor:',
      'required'   => true,
      'filters'    => array('StringTrim'),
      'validators' => array(
        array('validator' => 'NotEmpty')
      )
    ));

    $this->addElement('text', 'user', array(
      'label'      => 'Usuario:',
      'required'   => true,
      'filters'    => array('StringTrim'),
      'validators' => array(
        array('validator' => 'NotEmpty')
      )
    ));

    $this->addElement('password', 'password', array(
      'label'      => 'Senha:',
      'required'   => true,
      'filters'    => array('StringTrim'),
      'validators' => array(
        array('validator' => 'NotEmpty')
      )
    ));
    // Add the submit button
    $this->addElement('submit', 'submit', array(
      'ignore'   => true,
      'label'    => 'Login',
    ));

    // And finally add some CSRF protection
    $this->addElement('hash', 'csrf', array(
      'ignore' => true,
    ));
  }


}
