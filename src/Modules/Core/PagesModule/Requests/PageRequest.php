<?php
namespace Serff\Cms\Modules\Core\PagesModule\Requests;

use Serff\Cms\Core\Facades\Hook;
use Serff\Cms\Core\Request\Request;

class PageRequest extends Request
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'title'   => 'required',
            'content' => 'required',
        ];

        if ($this->get('method') == 'edit') {
            $rules['slug'] = 'required';
            foreach (Hook::getFormValidation('pages.edit') as $hook_rule) {
                $rules = array_merge($rules, $hook_rule);
            }
        } else {
            foreach (Hook::getFormValidation('pages.create') as $hook_rule) {
                $rules = array_merge($rules, $hook_rule);
            }
        }

        foreach (Hook::getFormValidation('pages.form') as $hook_rule) {
            $rules = array_merge($rules, $hook_rule);
        }


        return $rules;
    }

    public function attributes()
    {
        $attributes = [
            'title'   => 'Titel',
            'content' => 'Content',
            'slug'    => 'Permalink',
        ];

        foreach (Hook::getFormValidationAttributes('pages.form') as $hook_attributes) {
            $attributes = array_merge($attributes, $hook_attributes);
        }

        return $attributes;
    }

}