<?php
namespace Serff\Cms\Modules\Custom\KabolaDealersModule\Observers;

use Geocoder\Provider\Nominatim;
use Ivory\HttpAdapter\CurlHttpAdapter;

class DealerObserver
{
    protected $geocoder;

    public function __construct()
    {
        $curl = new CurlHttpAdapter;
        $this->geocoder = new Nominatim($curl, 'http://nominatim.openstreetmap.org/');
        
    }
    
    public function saved($model)
    {
        if($model->latitude == null) {
            $dealer = $model->toArray();
            $query = sprintf('%s, %s, %s', array_get($dealer, 'street')  , array_get($dealer, 'city'), array_get($dealer, 'country'));
            $result = null;
            try {
                $result = $this->geocoder->geocode($query);
            } catch (\Exception $e) {
				dd($query, $e);
            }
            
            if($result === null) {
                return;
            }

            $model->latitude = $result->first()->getCoordinates()->getLatitude();
            $model->longitude = $result->first()->getCoordinates()->getLongitude();
            $model->save();
        }
    }

}