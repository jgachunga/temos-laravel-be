<?php

namespace App\Helpers;
use Illuminate\Support\Arr;
use App\Models\SaleStructure;

/**
 * Class Socialite.
 */
class LocationHelper
{
    /**
     * List of the accepted third party provider types to login with.
     *
     * @return array
     */
    public function fetchGeocode($lat, $lng){
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.$lat.','.$lng.'&sensor=false&key=AIzaSyDBTHu5OY1ICSPGB8D473jwXF5E-mGzud0';
        $json = @file_get_contents($url);
        $data = json_decode($json);
        $status = $data->status;
        if($status=="OK") {
            //Get address from json data
            for ($j=0;$j<count($data->results[0]->address_components);$j++) {
                $cn=array($data->results[0]->address_components[$j]->types[0]);
                if(in_array("locality", $cn)) {
                    $city= $data->results[0]->address_components[$j]->long_name;
                }
            }
        } else{
        echo 'Location Not Found';
        }
     //Print city
     echo $city;

    }
}
