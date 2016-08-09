<?php
namespace Serff\Cms\Modules\Core\MediaModule\Requests;

use Serff\Cms\Core\Request\Request;

/**
 * Class UploadRequest
 *
 * @package Serff\Cms\Modules\Core\MediaModule\Requests
 */
class UploadRequest extends Request
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
            'file' => 'required|file|mimes:jpeg,gif,png|max:9000',
        ];

        return $rules;
    }

    /**
     * @return array
     */
    public function attributes()
    {
        $attributes = [];

        return $attributes;
    }

}