<?php

namespace Projects\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Projects\Controller\ProjectTypeController;
use Projects\Service\projectTypeService;

/**
 * This is the factory for AuthController. Its purpose is to instantiate the controller
 * and inject dependencies into its constructor.
 */
class ProjectTypeControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $vhm = $container->get('ViewHelperManager');
        $projectTypeService = new projectTypeService($entityManager);
        return new ProjectTypeController($vhm, $entityManager, $projectTypeService);
    }

}
