<?php

namespace Customers\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CustomerController extends AbstractActionController {

    protected $vhm;
    protected $em;
    protected $cs;

    public function __construct($vhm, $em, $cs) {
        $this->vhm = $vhm;
        $this->em = $em;
        $this->cs = $cs;
    }

    public function indexAction() {
        $customers = $this->cs->getCustomers();

        return new ViewModel(
                array(
            'customers' => $customers
                )
        );
    }

    public function addAction() {
        $customer = $this->cs->newCustomer();
        $form = $this->cs->createForm($customer);

        return new ViewModel(
                array(
            'form' => $form
                )
        );
    }

}
