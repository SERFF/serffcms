<?php
namespace Serff\Cms\Core\Macros\Html;

use Serff\Cms\Modules\Core\UsersModule\Domain\Models\User\User;

/**
 * Class NavigationMacro
 *
 * @package Serff\Cms\Core\Macros\Html
 */
class NavigationMacro
{
    /**
     * @var User
     */
    protected $user;

    /**
     * NavigationMacro constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $html = [];
        $html[] = '<ul class="sidebar-menu">';
        $html = array_merge($html, $this->buildMenu(\Request::getUri()));
        $html[] = '</ul>';

        return implode("\n", $html);
    }

    /**
     * @return array
     */
    protected function buildMenu($current_url)
    {
        $items = app('AdminMenu')->getMenu();
        $html = [];
        $html[] = sprintf("<li class=\"header\">%s</li>", trans('admin/navigation.title'));
        foreach ($items as $main_item) {
            $submenu_items = array_get($main_item, 'items');
            $active_item = $this->hasActiveSubItem($submenu_items, $current_url);
            $expander = count($submenu_items) > 0 ? "<i class=\"fa fa-angle-left pull-right\"></i>" : "";
            $html[] = sprintf("<li class='treeview %s'><a href=\"%s\"><i class='fa %s'></i> <span>%s</span>%s</a>",
                $active_item === true ? 'active' : '',
                array_get($main_item, 'link', '#'),
                array_get($main_item, 'icon'),
                array_get($main_item, 'label'),
                $expander);
            if (count($submenu_items) > 0) {
                $html[] = "<ul class=\"treeview-menu\">";
                foreach ($submenu_items as $sub_item) {
                    $html[] = sprintf("<li%s><a href=\"%s\"><i class='fa %s'></i> <span>%s</span></a></li>",
                        array_get($sub_item, 'link') === $current_url ? " class='active'" : '',
                        array_get($sub_item, 'link'),
                        array_get($sub_item, 'icon'),
                        array_get($sub_item, 'label'));
                }
                $html[] = "</ul>";
            }
            $html[] = "</li>";
        }

        return $html;
    }

    /**
     * @param $subitems
     * @param $url
     *
     * @return bool
     */
    protected function hasActiveSubItem($subitems, $url)
    {
        foreach ($subitems as $item) {
            if (array_get($item, 'link') === $url) {
                return true;
            }
        }

        return false;
    }

}