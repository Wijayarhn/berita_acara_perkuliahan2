<?php

namespace App\Helpers;

class GeoHelper
{
  public static function getCityFromCoordinates($lat, $lon)
  {
    $url = "https://nominatim.openstreetmap.org/reverse?format=json&lat=$lat&lon=$lon&zoom=10&addressdetails=1";
    $opts = ['http' => ['header' => "User-Agent: BAPApp/1.0\r\n"]];
    $response = file_get_contents($url, false, stream_context_create($opts));
    $data = json_decode($response, true);
    return $data['address']['city']
      ?? $data['address']['town']
      ?? $data['address']['village']
      ?? $data['address']['suburb']
      ?? 'Tidak diketahui';
  }
}
