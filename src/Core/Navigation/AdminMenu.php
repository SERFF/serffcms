<?php
namespace Serff\Cms\Core\Navigation;

/**
 * Class AdminMenu
 *
 * @package Serff\Cms\Core\Navigation
 */
class AdminMenu
{
    /**
     * @var array
     */
    protected $items = [];

    /**
     * @param $name
     * @param $label
     * @param $sort_order
     *
     * @return array
     */
    public function addGroup($name, $item, $sort_order = null)
    {
        $value = [
            'sort_order' => (int)$sort_order,
            'label'      => array_get($item, 'label'),
            'icon'       => array_get($item, 'icon'),
            'items'      => [],
        ];

        $loc = &$this->items;
        $count = 0;
        foreach (explode('.', $name) as $step) {
            if ($count > 0) {
                $loc = &$loc['submenu'][ $step ];
            } else {
                $loc = &$loc[ $step ];
            }
            $count++;
        }

        return $loc = $value;
    }

    /**
     * @param $group
     * @param $item
     *
     * @return mixed
     */
    public function addItem($group, $item)
    {
        $loc = &$this->items;
        $level = [];
        $count = 0;
        $groups_list = explode('.', $group);
        foreach ($groups_list as $step) {
            $level[] = $step;
            if ($count > 0) {
                $loc =  &$this->items;
                $i = 0;
                foreach ($level as $level_item) {
                    $i++;
                    $loc = &$loc[ $level_item ];
                    if ($i < count($groups_list)) {
                        $loc = &$loc['submenu'];
                    }
                }
                $loc = &$loc['items'];
            } else {
                $loc = &$loc[ $step ]['items'];
            }
            $count++;
        }

        return $loc[] = $item;
    }

    /**
     * @return array
     */
    public function getMenu()
    {
        $items = $this->items;
    
        return array_sort($items, function ($item) {
            return $item['sort_order'];
        });
    }
}