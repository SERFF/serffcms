<?php
namespace Serff\Cms\Modules\Core\PartialsModule\Requests;

use Serff\Cms\Core\Request\Request;

class PartialRequest extends Request
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
            'name'    => 'required',
            'content' => 'required',
        ];


        return $rules;
    }

    public function attributes()
    {
        $attributes = [
            'naam'    => 'Naam',
            'content' => 'Content',
        ];

        return $attributes;
    }

}