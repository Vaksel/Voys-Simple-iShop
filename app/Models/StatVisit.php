<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class StatVisit extends Model
{
    use HasFactory;

    public static function checkIsMobile()
    {
        $ch = curl_init('http://ip-api.com/json/' . $_SERVER['REMOTE_ADDR'] . '?lang=ru&fields=mobile');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $res = curl_exec($ch);
        curl_close($ch);

        $res = json_decode($res, true);

        return $res;
    }

    public static function getLocation($isAppeal = false)
    {
        $locationArray = [
            'regionName'    => null,
            'city'          => null,
            'mobile'        => false
        ];

        $apiKey = '6f800aa2-8068-4ba3-aa9d-53d693656194';

        if($isAppeal)
        {
            $cookieKey = 'cookie_coord_appeal_' . preg_replace('/\./', '_' ,$_SERVER['REMOTE_ADDR']);
        }
        else
        {
            $cookieKey = 'cookie_coord_' . preg_replace('/\./', '_' ,$_SERVER['REMOTE_ADDR']);
        }

        if(!empty($_COOKIE[$cookieKey]))
        {
            $cookieCoord = json_decode($_COOKIE[$cookieKey], true);
            $latitude = $cookieCoord['lat'];
            $longitude = $cookieCoord['lng'];

            $ch = curl_init("https://graphhopper.com/api/1/geocode?point={$latitude},{$longitude}&reverse=true&locale=ru&debug=true&key={$apiKey}");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HEADER, false);
            $res = curl_exec($ch);
            curl_close($ch);

            $res = json_decode($res, true);

            if(!empty($res['hits'][0]))
            {
                $locationArray['regionName'] = $res['hits'][0]['state'];
                $locationArray['city'] = $res['hits'][0]['city'];
            }
            else
            {
                $locationArray['regionName'] = null;
                $locationArray['city'] = null;
            }
        }

        if(!empty($_COOKIE['location_denied']))
        {
            $ch = curl_init('http://ip-api.com/json/' . $_SERVER['REMOTE_ADDR'] . '?lang=ru&fields=status,message,regionName,city,mobile,query');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HEADER, false);
            $res = curl_exec($ch);
            curl_close($ch);

            $res = json_decode($res, true);

            $locationArray['regionName'] = $res['regionName'];
            $locationArray['city'] = $res['city'];
            $locationArray['mobile'] = $res['mobile'];
        }

        Log::debug('user_location', $locationArray);

        return $locationArray;
    }
}
