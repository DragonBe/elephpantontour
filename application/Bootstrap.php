<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    public function _initSetupView()
    {
        // Initialize view
        $view = $this->getPluginResource('view')->getView();
        $view->headTitle('Elephpant on Tour');
        $view->headTitle()->setSeparator(' : ');
        $view->headLink()->appendStylesheet($view->baseUrl('/style/style.css'));
        $view->headMeta()->setHttpEquiv('Content-type', 'text/html; Charset=UTF-8');

        // Add it to the ViewRenderer
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper(
            'ViewRenderer'
        );
        $viewRenderer->setView($view);
        // Return it, so that it can be stored by the bootstrap
        return $view;
    }
}

