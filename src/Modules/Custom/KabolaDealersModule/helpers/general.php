<?php

use Geocoder\Provider\FreeGeoIp;
use Ivory\HttpAdapter\CurlHttpAdapter;

/**
 * @param $lat1
 * @param $lon1
 * @param $lat2
 * @param $lon2
 * @param string $unit
 *
 * @return float
 */
function distance($lat1, $lon1, $lat2, $lon2, $unit = "K")
{

    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "K") {
        return ($miles * 1.609344);
    } else {
        if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }
}

/**
 * @return mixed
 */
function get_location()
{
    $cacheManager = app(\Serff\Cms\Modules\Custom\KabolaDealersModule\Cache\DealersCacheManager::class);

    return $cacheManager->rememberLocation(\Request::session()->getId(), function () {
        try {
            $curl = new CurlHttpAdapter;
            $nomatim = new FreeGeoIp($curl, 'http://nominatim.openstreetmap.org/');
            $ip = \Request::ip();
            $geocoder = $nomatim->geocode($ip);
            if ($geocoder->first()->getCoordinates() === null) {
                throw new \Exception('IP not converted to address');
            }
            $lat = $geocoder->first()->getCoordinates()->getLatitude();
            $lng = $geocoder->first()->getCoordinates()->getLongitude();
        } catch (\Exception $e) {
            $lat = 52.090737;
            $lng = 5.121420;
        }

        return ['lat' => $lat, 'lng' => $lng];
    });

}

/**
 * @param null $location
 * @param int $limit
 *
 * @return \Illuminate\Database\Eloquent\Collection|static
 */
function get_dealers($location = null, $limit = 5)
{
    if ($location === null) {
        $location = get_location();
    }

    return app(\Serff\Cms\Modules\Custom\KabolaDealersModule\Domain\Repositories\DealerRepository::class)->getByLatAndLong(array_get($location, 'lat'), array_get($location, 'lng'), $limit);
}