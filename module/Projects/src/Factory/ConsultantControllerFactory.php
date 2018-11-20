<?php

namespace Projects\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Projects\Controller\ConsultantController;
use Projects\Service\consultantService;
use Projects\Service\expertiseService;
use Projects\Service\levelService;
use Projects\Service\expertiseLevelService;

/**
 * This is the factory for AuthController. Its purpose is to instantiate the controller
 * and inject dependencies into its constructor.
 */
class ConsultantControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $vhm = $container->get('ViewHelperManager');
        $serviceManager = new consultantService($entityManager);
        $expertiseManager = new expertiseService($entityManager);
        $levelManager = new levelService($entityManager);
        $expertiseLevelManager = new expertiseLevelService($entityManager);
        return new ConsultantController(
                $vhm, 
                $entityManager, 
                $serviceManager, 
                $expertiseManager, 
                $levelManager,
                $expertiseLevelManager);
    }

}
