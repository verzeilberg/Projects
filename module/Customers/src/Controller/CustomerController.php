<?php

namespace Customers\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CustomerController extends AbstractActionController {

    protected $vhm;
    protected $em;

    public function __construct($vhm, $em) {
        $this->vhm = $vhm;
        $this->em = $em;
    }

    public function indexAction() {
        return new ViewModel();
    }
}
