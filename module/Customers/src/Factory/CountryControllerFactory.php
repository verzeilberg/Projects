<?php

namespace Customers\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Customers\Controller\CountryController;
use UploadFiles\Service\uploadfilesService;
use Customers\Service\countryService;
use UploadImages\Service\cropImageService;
use UploadImages\Service\imageService;

/**
 * This is the factory for AuthController. Its purpose is to instantiate the controller
 * and inject dependencies into its constructor.
 */
class CountryControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {

        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $vhm = $container->get('ViewHelperManager');
        $config = $container->get('config');
        $cs = new countryService($entityManager);
        $uploadfilesService = new uploadfilesService($config, $entityManager);
        $cropImageService = new cropImageService($entityManager, $config);
        $imageService = new imageService($entityManager, $config);
        return new CountryController($vhm, $entityManager, $cs, $uploadfilesService, $cropImageService, $imageService);
    }

}
