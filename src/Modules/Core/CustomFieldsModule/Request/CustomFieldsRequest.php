<?php
namespace Serff\Cms\Modules\Core\CustomFieldsModule\Request;

use Serff\Cms\Core\Request\Request;

/**
 * Class CustomFieldsRequest
 *
 * @package Serff\Cms\Modules\Core\CustomFieldsModule\Request
 */
class CustomFieldsRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name'          => 'required|min:3',
            'input_label.*' => 'required|min:2',
            'input_name.*'  => 'required|min:2',
            'input_type.*'  => 'required|min:2',
            'required.*'    => 'required',
        ];

        if ($this->get('group_id', null) === null) {
            $rules['name'] = array_get($rules, 'name') . '|unique:cf_groups,name';
        }

        return $rules;
    }

    /**
     * @return array
     */
    public function attributes()
    {
        return [
            'name'          => 'Groep naam',
            'input_label.*' => 'Veld label',
            'input_name.*'  => 'Veld naam',
            'required.*'    => 'Veld verplicht',
        ];
    }

}