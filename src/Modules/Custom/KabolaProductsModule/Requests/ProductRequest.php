<?php
namespace Serff\Cms\Modules\Custom\KabolaProductsModule\Requests;

use Serff\Cms\Core\Request\Request;

class ProductRequest extends Request
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
            'name'            => 'required',
            'title'           => 'required',
            'intro_text'      => 'required',
            'product_image'   => 'required',
            'product_content' => 'required',
        ];

        return $rules;
    }

    public function attributes()
    {
        $attributes = [
            'title'           => 'Titel',
            'intro_text'      => 'Intro Tekst',
            'product_image'   => 'Product Afbeelding',
            'product_content' => 'Product Tekst',
        ];

        return $attributes;
    }

}