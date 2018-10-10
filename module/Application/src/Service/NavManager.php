<?php

namespace Application\Service;

/**
 * This service is responsible for determining which items should be in the main menu.
 * The items may be different depending on whether the user is authenticated or not.
 */
class NavManager {

    /**
     * Auth service.
     * @var Zend\Authentication\Authentication
     */
    private $authService;

    /**
     * Url view helper.
     * @var Zend\View\Helper\Url
     */
    private $urlHelper;

    /**
     * RBAC manager.
     * @var User\Service\RbacManager
     */
    private $rbacManager;

    /**
     * Constructs the service.
     */
    public function __construct($authService, $urlHelper, $rbacManager) {
        $this->authService = $authService;
        $this->urlHelper = $urlHelper;
        $this->rbacManager = $rbacManager;
    }

    /**
     * This method returns menu items depending on whether user has logged in or not.
     */
    public function getMenuItems() {
        $url = $this->urlHelper;
        $items = [];

        // Display "Login" menu item for not authorized user only. On the other hand,
        // display "Admin" and "Logout" menu items only for authorized users.
        if (!$this->authService->hasIdentity()) {
            $items[] = [
                'id' => 'login',
                'label' => 'Sign in',
                'link' => $url('login'),
                'float' => 'right'
            ];
        } else {

            if ($this->rbacManager->isGranted(null, 'user.manage')) {
                $items[] = [
                    'id' => 'users',
                    'label' => 'Users',
                    'link' => $url('users')
                ];
            }

            if ($this->rbacManager->isGranted(null, 'permission.manage')) {
                $items[] = [
                    'id' => 'permissions',
                    'label' => 'Permissions',
                    'link' => $url('permissions')
                ];
            }

            if ($this->rbacManager->isGranted(null, 'role.manage')) {
                $items[] = [
                    'id' => 'roles',
                    'label' => 'Roles',
                    'link' => $url('roles')
                ];
            }

            if ($this->rbacManager->isGranted(null, 'customer.manage')) {
                $items[] = [
                    'id' => 'customers',
                    'label' => 'Customers',
                    'link' => $url('beheer/customers')
                ];
            }
            
            if ($this->rbacManager->isGranted(null, 'language.manage')) {
                $items[] = [
                    'id' => 'languages',
                    'label' => 'Languages',
                    'link' => $url('beheer/languages')
                ];
            }
            
            if ($this->rbacManager->isGranted(null, 'language.manage')) {
                $items[] = [
                    'id' => 'translators',
                    'label' => 'Translations',
                    'link' => $url('beheer/translators')
                ];
            }

            $items[] = [
                'id' => 'logout',
                'label' => $this->authService->getIdentity(),
                'float' => 'right',
                'dropdown' => [
                    [
                        'id' => 'settings',
                        'label' => 'Settings',
                        'link' => $url('application', ['action' => 'settings'])
                    ],
                    [
                        'id' => 'logout',
                        'label' => 'Sign out',
                        'link' => $url('logout')
                    ],
                ]
            ];
        }

        return $items;
    }

}
