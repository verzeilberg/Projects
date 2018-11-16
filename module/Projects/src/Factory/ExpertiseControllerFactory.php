<?php

namespace Projects\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Projects\Controller\ExpertiseController;
use Projects\Service\expertiseService;

/**
 * This is the factory for AuthController. Its purpose is to instantiate the controller
 * and inject dependencies into its constructor.
 */
class ExpertiseControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $vhm = $container->get('ViewHelperManager');
        $serviceManager = new expertiseService($entityManager);
        return new ExpertiseController($vhm, $entityManager, $serviceManager);
    }

}
