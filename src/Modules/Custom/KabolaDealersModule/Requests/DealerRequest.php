<?php
namespace Serff\Cms\Modules\Custom\KabolaDealersModule\Requests;

use Serff\Cms\Core\Request\Request;

class DealerRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'     => 'required',
            'street'   => 'required',
            'postcode' => 'required',
            'city'     => 'required',
            'country'  => 'required',

        ];
    }

    public function attributes()
    {
        return [
            'name'            => 'Naam',
            'street'          => 'Straat',
            'postcode'        => 'Postcode',
            'city'            => 'Plaats',
            'country'         => 'Land',
            'contact_address' => 'Website / e-mail adres',
            'phone'           => 'Telefoonnummer',
            'emergency_phone' => 'Noodnummer',
        ];
    }

}