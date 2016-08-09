<?php
namespace Serff\Cms\Modules\Core\CustomFieldsModule\Service;

use Serff\Cms\Modules\Core\CustomFieldsModule\Domain\Models\Group;
use Serff\Cms\Modules\Core\CustomFieldsModule\Domain\Models\Rule;
use Serff\Cms\Modules\Core\CustomFieldsModule\Domain\Repositories\FieldRepository;
use Serff\Cms\Modules\Core\CustomFieldsModule\Domain\Repositories\GroupRepository;
use Serff\Cms\Modules\Core\MediaModule\Domain\Repositories\MediaRepository;
use Serff\Cms\Modules\Core\ThemesModule\Core\ThemeView;

/**
 * Class CustomFieldsService
 *
 * @package Serff\Cms\Modules\Core\CustomFieldsModule\Service
 */
class CustomFieldsService
{
    /**
     * @var GroupRepository
     */
    protected $groupRepository;
    /**
     * @var FieldRepository
     */
    protected $fieldRepository;

    /**
     * CustomFieldsService constructor.
     *
     * @param GroupRepository $groupRepository
     */
    public function __construct(GroupRepository $groupRepository, FieldRepository $fieldRepository)
    {
        $this->groupRepository = $groupRepository;
        $this->fieldRepository = $fieldRepository;
    }

    /**
     * @param $record
     * @param $type
     *
     * @return array
     */
    public function getViewsForRecord($record, $type)
    {
        $views = [];
        $inputs = $this->getInputsForRecord($record, $type);

        foreach ($inputs as $input) {
            $views[] = ThemeView::getAdminView('admin.customfields.output.type_' . $input['type'], ['input' => $input, 'record' => $record]);
        }

        return $views;
    }

    /**
     * @param $rule
     * @param $record
     * @param $type
     *
     * @return bool
     */
    protected function checkRule($rule, $record, $type)
    {
        switch ($rule->key) {
            case 'template':
                return $this->checkIfTemplate($rule->value, $rule->comparator, $record);
                break;
            case 'page':
                return $this->checkIfPage($rule->value, $rule->comparator, $record);
                break;
            default:
                return false;
                break;
        }
    }

    /**
     * @param $value
     * @param $comparator
     * @param $record
     *
     * @return bool
     */
    protected function checkIfTemplate($value, $comparator, $record)
    {
        return $this->compareValues(get_meta_value(array_get($record, 'id'), 'page', 'template'), $value, $comparator);
    }

    /**
     * @param $value
     * @param $comparator
     * @param $record
     *
     * @return bool
     */
    protected function checkIfPage($value, $comparator, $record)
    {
        return $this->compareValues($value, array_get($record, 'id'), $comparator);
    }

    /**
     * @param $a
     * @param $b
     * @param $comparator
     *
     * @return bool
     */
    protected function compareValues($a, $b, $comparator)
    {
        switch ($comparator) {
            case 'equals':
                return $a == $b;
                break;
            case 'unequals':
                return $a != $b;
                break;
        }
    }

    /**
     * @param $record
     * @param $type
     *
     * @return array
     */
    public function getInputsForRecord($record, $type)
    {
        $inputs = [];

        foreach ($this->groupRepository->all() as $group) {
            /**
             * @var Group $group
             * @var Rule $rule
             */
            $check_passed = true;
            foreach ($group->rules()->get() as $rule) {
                if (!$this->checkRule($rule, $record, $type)) {
                    $check_passed = false;
                }
            }
            if ($check_passed) {
                $inputs = array_merge($group->fields()->with('group')->get()->toArray(), $inputs);
            }
        }

        return $inputs;
    }


    /**
     * @param $input
     * @param $value
     *
     * @return string
     */
    public function getValueForInput($input, $value)
    {
        $field = $this->fieldRepository->getById(array_get($input, 'id'));
        switch ($field->type) {
            case 'image':
                return $this->getImageValue($value);
                break;
            case 'galery':
                return $this->getGalleryValue($value);
                break;
            case 'partial':
                return $this->getPartialValue($value);
            default:
                return $value;
                break;
        }
    }

    /**
     * @param $value
     *
     * @return string
     */
    protected function getImageValue($value)
    {
        if (is_numeric($value)) {
            $media = app(MediaRepository::class)->getById($value);
            if ($media !== null) {
                return serialize($media);
            }
        }

        return $value;
    }

    /**
     * @param $value
     *
     * @return string
     */
    protected function getGalleryValue($value)
    {
        $items = explode('|', $value);
        $collection = [];
        foreach ($items as $item) {
            if (is_numeric($item)) {
                $media = app(MediaRepository::class)->getById($item);

                if ($media !== null) {
                    $collection[] = $media;
                }
            }
        }

        return serialize(collect($collection));
    }

    /**
     * @param $value
     *
     * @return string
     */
    protected function getPartialValue($value)
    {
        return serialize($value);
    }
}