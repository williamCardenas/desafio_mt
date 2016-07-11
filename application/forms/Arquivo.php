<?php

class Application_Form_Arquivo extends Zend_Form
{

  public function init()
  {
    // Set the method for the display form to POST
    $this->setMethod('post');
    $this->setAttrib('enctype', 'multipart/form-data');

    $element = new Zend_Form_Element_File('fileUpload');
    $element->setLabel('Arquivo')
    ->addValidator('Size', false, 102400)
    ->setDestination(PUBLIC_PATH.'/upload');
    $this->addElement($element, 'file');

    // Add the submit button
    $this->addElement('submit', 'submit', array(
      'ignore'   => true,
      'label'    => 'Enviar',
    ));

    $this->addElement('hidden', 'id', array(
      'ignore' => true,
    ));

    // And finally add some CSRF protection
    $this->addElement('hash', 'csrf', array(
      'ignore' => true,
    ));
  }


}
