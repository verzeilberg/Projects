<?php

namespace Customers\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Customers\Controller\ContactController;
use Customers\Service\customerService;
use Customers\Service\contactService;
use UploadImages\Service\imageService;
use UploadImages\Service\cropImageService;

/**
 * This is the factory for AuthController. Its purpose is to instantiate the controller
 * and inject dependencies into its constructor.
 */
class ContactControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $vhm = $container->get('ViewHelperManager');
        $config = $container->get('config');
        $cs = new customerService($entityManager);
        $contactService = new contactService($entityManager, $cs);
        $imageService = new imageService($entityManager, $config);
        $cropImageService = new cropImageService($entityManager, $config);
        return new ContactController($vhm, $entityManager, $cs, $contactService, $imageService, $cropImageService);
    }

}
