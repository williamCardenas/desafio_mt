<?php

class CriptografiaController extends Zend_Controller_Action
{

  public function init()
  {
    /* Initialize action controller here */
  }

  public function indexAction()
  {
    $request = $this->getRequest();
    $form    = new Application_Form_Criptografia();

    if ($request->isPost())
    {
      if ($form->isValid($request->getPost()))
      {
        $criptografia = new Application_Model_Criptografia();
        try {
          if($request->getPost('action') == 'cript')
          {
            $message = $criptografia->encrypt($request->getPost('text'),$request->getPost('key'));
            $flashMessenger = $this->_helper->getHelper('FlashMessenger');
            $flashMessenger->addMessage('mensagem criptografada: '.$message);
            $this->view->message = $flashMessenger->getMessages();
            //descriptografar a mensagem para teste
            $message = $criptografia->decrypt($message,$request->getPost('key'));
            $flashMessenger = $this->_helper->getHelper('FlashMessenger');
            $flashMessenger->addMessage('mensagem descriptografada: '.$message);
            $this->view->message = $flashMessenger->getMessages();
          }elseif ($request->getPost('action') == 'descript')
          {
            $message = $criptografia->decrypt($request->getPost('text'),$request->getPost('key'));
            $flashMessenger = $this->_helper->getHelper('FlashMessenger');
            $flashMessenger->addMessage('mensagem descriptografada: '.$message);
            $this->view->message = $flashMessenger->getMessages();
          }
        } catch (Exception $e) {
          $flashMessenger = $this->_helper->getHelper('FlashMessenger');
          $flashMessenger->addMessage($e->getMessage());
          $this->view->message = $flashMessenger->getMessages();
        }
      }
    }
    $this->view->controllerName = $request->getControllerName();
    $this->view->form = $form;
  }

}
