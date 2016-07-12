<?php

class ArquivoController extends Zend_Controller_Action
{

  public function init()
  {
    /* Initialize action controller here */
  }

  public function indexAction()
  {
    $request = $this->getRequest();

    $arquivoMapper = new Application_Model_ArquivoMapper();
    $form    = new Application_Form_Arquivo();

    if($this->getRequest()->isPost() and $form->isValid($_POST))
    {
      $form->file->receive();
      $file = $form->file->getFileInfo();
      if(empty($request->getPost('id')))
      {
        $arquivo = new Application_Model_Arquivo(array(
          'name'=>$file['fileUpload']['name'],
          'created'=> date('Y-m-d H:i:s'),
          'updated'=> date('Y-m-d H:i:s'),
        ));
        $arquivoMapper->save($arquivo);
      }else{
        $arquivo = new Application_Model_Arquivo();
        $arquivoMapper->find($request->getPost('id'),$arquivo);
        $arquivo->setName($file['fileUpload']['name']);
        $arquivo->setUpdated(date('Y-m-d H:i:s'));
        $arquivoMapper->save($arquivo);
      }
    }

    $this->view->entries = $arquivoMapper->fetchAll();
    $this->view->controllerName = $request->getControllerName();
    $this->view->form = $form;
  }

}
