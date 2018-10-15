<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * This view helper class displays a menu bar.
 */
class Menu extends AbstractHelper {

    /**
     * Menu items array.
     * @var array 
     */
    protected $items = [];

    /**
     * Active item's ID.
     * @var string  
     */
    protected $activeItemId = '';

    /**
     * Constructor.
     * @param array $items Menu items.
     */
    public function __construct($items = []) {
        $this->items = $items;
    }

    /**
     * Sets menu items.
     * @param array $items Menu items.
     */
    public function setItems($items) {
        $this->items = $items;
    }

    /**
     * Sets ID of the active items.
     * @param string $activeItemId
     */
    public function setActiveItemId($activeItemId) {
        $this->activeItemId = $activeItemId;
    }

    /**
     * Renders the menu.
     * @return string HTML code of the menu.
     */
    public function render() {
        if (count($this->items) == 0)
            return ''; // Do nothing if there are no items.

        $result = '<nav class="navbar navbar-expand-lg navbar-dark bg-dark row">';
        $result .= '<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">';
        $result .= '<span class="navbar-toggler-icon"></span>';
        $result .= '</button>';
        $result .= '<div class="collapse navbar-collapse" id="navbarNav">';

        $resultLeft = '<ul class="navbar-nav mr-auto">';
        // Render items
        foreach ($this->items as $item) {
            if (!isset($item['float']) || $item['float'] == 'left')
                $resultLeft .= $this->renderItem($item);
        }
        $resultLeft .= '</ul>';

        $resultRight = '<ul class="navbar-nav float-right">';
        // Re$resultRightnder items
        foreach ($this->items as $item) {
            if (isset($item['float']) && $item['float'] == 'right')
                $resultRight .= $this->renderItem($item);
        }
        $resultRight .= '</ul>';


        $result .= $resultLeft;
        $result .= $resultRight;
        $result .= '</div>';
        $result .= '</nav>';

        return $result;
    }

    /**
     * Renders an item.
     * @param array $item The menu item info.
     * @return string HTML code of the item.
     */
    protected function renderItem($item) {
        $id = isset($item['id']) ? $item['id'] : '';
        $isActive = ($id == $this->activeItemId);
        $label = isset($item['label']) ? $item['label'] : '';

        $result = '';

        $escapeHtml = $this->getView()->plugin('escapeHtml');

        if (isset($item['dropdown'])) {

            $dropdownItems = $item['dropdown'];

            $result .= '<li class="nav-item dropdown">';
            $result .= '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            $result .= $escapeHtml($label);
            $result .= '</a>';

            $result .= '<div class="dropdown-menu" aria-labelledby="navbarDropdown">';
            foreach ($dropdownItems as $item) {
                $link = isset($item['link']) ? $item['link'] : '#';
                $label = isset($item['label']) ? $item['label'] : '';
                $result .= '<a class="dropdown-item" href="' . $escapeHtml($link) . '">' . $escapeHtml($label) . '</a>';
            }
            $result .= '</div>';
            $result .= '</li>';
        } else {
            $link = isset($item['link']) ? $item['link'] : '#';

            $result .= $isActive ? '<li class="nav-item active">' : '<li class="nav-item">';
            $result .= '<a class="nav-link" href="' . $escapeHtml($link) . '">' . $escapeHtml($label) . '</a>';
            $result .= '</li>';
        }

        return $result;
    }

}
