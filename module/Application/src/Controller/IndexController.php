<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Barcode\Barcode;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function someAction()
    {
        // Get the single 'id' parameter from route.
        $id = $this->params()->fromRoute('id', -1);

        // Get all route parameters at once as an array.
        $params = $this->params()->fromRoute();

        //...
    }
    public function indexAction()
    {
        return new ViewModel();
    }
    public function aboutAction()
    {
        $appName = 'Hello World';
        $appDescription = 'Hello World sample application for Using Zend Framework 3 book';

        // Return variables to view script with the help of
        // ViewObject variable container
        return new ViewModel([
            'appName' => $appName,
            'appDescription' => $appDescription
        ]);
    }
    public function barcodeAction()
    {
        // Get parameters from route.
        $type = $this->params()->fromRoute('type', 'code39');
        $label = $this->params()->fromRoute('label', 'HELLO-WORLD');

        // Set barcode options.
        $barcodeOptions = ['text' => $label];
        $rendererOptions = [];

        // Create barcode object
        $barcode = Barcode::factory($type, 'image',
            $barcodeOptions, $rendererOptions);

        // The line below will output barcode image to standard
        // output stream.
        $barcode->render();

        // Return Response object to disable default view rendering.
        return $this->getResponse();
    }
    public function docAction()
    {
        $pageTemplate = 'application/index/doc'.
            $this->params()->fromRoute('page', 'documentation.phtml');

        $filePath = __DIR__.'/../../view/'.$pageTemplate.'.phtml';
        if(!file_exists($filePath) || !is_readable($filePath)) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $viewModel = new ViewModel([
            'page'=>$pageTemplate
        ]);
        $viewModel->setTemplate($pageTemplate);

        return $viewModel;
    }
    public function contactUsAction()
    {
        // Check if user has submitted the form
        if($this->getRequest()->isPost()) {

            // Retrieve form data from POST variables
            $data = $this->params()->fromPost();

            // ... Do something with the data ...
            var_dump($data);
        }

        // Pass form variable to view
        return new ViewModel([
            'form' => $form
        ]);
    }
}
