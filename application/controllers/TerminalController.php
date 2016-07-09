<?php

class TerminalController extends Zend_Controller_Action
{

  public function init()
  {
    /* Initialize action controller here */
  }

  public function indexAction()
  {
    Zend_Session::start();
    $request = $this->getRequest();
    $form    = new Application_Form_SshLogin();
    if ($this->getRequest()->isPost())
    {
      if ($form->isValid($request->getPost()))
      {
        try{
          $defaultSession = new Zend_Session_Namespace('ssh');
          $defaultSession->ssh = new Application_Model_Ssh($request->getPost('server'),$request->getPost('user'),$request->getPost('password'));
          $this->view->sshConnection = $defaultSession->ssh;
        }catch(Exception $e){
          $flashMessenger = $this->_helper->getHelper('FlashMessenger');
          $flashMessenger->addMessage($e->getMessage());
          $this->view->message = $flashMessenger->getMessages();
        }
      }
    }
    $this->view->controllerName = $request->getControllerName();
    $this->view->form = $form;
  }

  public function execAction()
  {
    $request = $this->getRequest();
    Zend_Session::start();
    // $defaultSession = new Zend_Session_Namespace();
    if ($request->isXmlHttpRequest()) {
      if ($request->isPost()) {
        if(Zend_Session::namespaceIsset("ssh")) {
          $ssh = new Zend_Session_Namespace('ssh');
          $stream = $ssh->ssh->exec($request->getPost('command'));
          $this->_helper->json(stream_get_contents($stream));
        }
        $this->_helper->json('teste');
      }
      echo 'only post';
    }
    echo 'Not Ajax';
  }

}
