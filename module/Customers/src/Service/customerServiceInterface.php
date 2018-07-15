<?php

namespace Customer\Service;

interface customerServiceInterface {

    /**
     *
     * Get array of customers
     *
     * @return      array
     *
     */
    public function getCustomers();
    
    public function getCustomerFormById($id);
    
    public function deleteCustomerForm($customerForm);

    /**
     *
     * Send mail
     * 
     * @param       customer $customer object
     * @return      void
     *
     */
    public function sendMail($customer);

    /**
     *
     * Get base url
     * 
     * @return      string
     *
     */
    public function getBaseUrl();
}
