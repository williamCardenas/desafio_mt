<?php

class Application_Form_Criptografia extends Zend_Form
{

  public function init()
  {
    // Set the method for the display form to POST
    $this->setMethod('post');

    $this->addElement('radio', 'action', array(
      'label'=>'Ação',
      'multiOptions'=>array(
        'cript' => 'Criptografar',
        'descript' => 'Descriptografar',
      ),
    ));

    $this->addElement('textarea', 'text', array(
      'label'      => 'texto a ser criptografado:',
      'required'   => true,
      'filters'    => array('StringTrim'),
      'validators' => array(
        array('validator' => 'NotEmpty')
      )
    ));

    $this->addElement('text', 'key', array(
      'label'      => 'chave salt maior que 32 caracteres:',
      'required'   => true,
      'filters'    => array('StringTrim'),
      'validators' => array(
        array('validator' => 'NotEmpty')
      )
    ));

    // Add the submit button
    $this->addElement('submit', 'submit', array(
      'ignore'   => true,
      'label'    => 'Enviar',
    ));

    // And finally add some CSRF protection
    $this->addElement('hash', 'csrf', array(
      'ignore' => true,
    ));
  }


}
