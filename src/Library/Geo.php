<?php
namespace Clumsy\Utils\Library;

use GeoIp2\Database\Reader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request as RequestFacade;
use Illuminate\Support\Str;

class Geo
{
    public static function postalToAddress($postal = '', $country = false)
    {
        if (!$country) {
            $country = App::getLocale();
        }

        switch ($country) {
            case 'es':
                $result = DB::table('utils_geo_es_cities')
                            ->join('utils_geo_es_subregions', 'utils_geo_es_cities.subregion_id', '=', 'utils_geo_es_subregions.id')
                            ->join('utils_geo_es_regions', 'utils_geo_es_subregions.region_id', '=', 'utils_geo_es_regions.id')
                            ->where('postal', '<=', $postal)
                            ->orderBy('postal', 'desc')
                            ->first();

                if ($result) {
                    $address = [];
                    $address['country'] = $country;
                    $address['region'] = $result->region;
                    $address['subregion'] = $result->subregion;
                    $address['city'] = $result->city;

                    // TODO?: Build locations table

                    return $address;
                }

                return false;

            case 'pt':
                if (!str_contains($postal, '-')) {
                    $postal = substr_replace($postal, '-', 4, 0);
                }

                list($prefix, $suffix) = explode('-', $postal);

                if ($suffix) {
                    $result = DB::table('utils_geo_pt_address_lookup')
                                ->where('code_prefix', $prefix)
                                ->where('code_suffix', $suffix)
                                ->first();
                } else {
                    $result = false;
                }

                // If address lookup fails with prefix-suffix, attempt to use only prefix as a fallback
                if (!$result) {
                    $result = DB::table('utils_geo_pt_address_lookup')->where('code_prefix', $prefix)->first();

                    $suffix = false;
                }

                if ($result) {
                    $address = [];
                    $address['country'] = $country;
                    $address['region'] = $result->region;
                    $address['subregion'] = $result->subregion;
                    $address['city'] = Str::title(Str::lower($result->city));
                    $address['location'] = $result->location;

                    if ($suffix) {
                        $address['address'] = implode(' ', array_filter([$result->street_type, $result->street_type_suffix, $result->street_name_prefix_1, $result->street_name_prefix_2, $result->street_name]));
                    }

                    return $address;
                }

                return false;
        }
    }

    public static function subregionToRegion($country = 'pt')
    {
        switch ($country) {
            case 'pt':
                $results = DB::table('utils_geo_pt_subregions')
                             ->select('utils_geo_pt_subregions.desig as subregion', 'utils_geo_pt_regions.desig as region')
                             ->join('utils_geo_pt_regions', 'utils_geo_pt_subregions.dd', '=', 'utils_geo_pt_regions.dd')
                             ->get();

                break;

            case 'es':
                $results = DB::table('utils_geo_es_subregions')
                             ->select('utils_geo_es_subregions.subregion', 'utils_geo_es_regions.region')
                             ->join('utils_geo_es_regions', 'utils_geo_es_regions.id', '=', 'utils_geo_es_subregions.region_id')
                             ->get();

                break;
        }

        $subregions = [];

        foreach ($results as $result) {
            $subregions[$result->subregion] = $result->region;
        }

        return $subregions;
    }

    /**
     *
     * Gets Information by IP
     *
     * @param  array        $params     Parameters for the function to return (country,coordinates,countryCode)
     * @param  string       $ip         Ip that you want to fetch the data for. If none, will fetch from the request
     * @return array|string             Requested data. If no parameters, will return Country name
     */
    public function getInfoByIP($params = 'country', $ip = null)
    {
        if ($ip == null) {
            $ip = RequestFacade::getClientIp();
        }

        $reader = new Reader(__DIR__.'/../../../support/GeoLite2-City.mmdb');
        $record = $reader->city($ip);

        $toReturn = [];
        foreach ((array)$params as $param) {
            switch ($param) {
                case 'country':
                    $locale = App::getLocale();
                    if (isset($record->country->names[$locale])) {
                        $country = $record->country->names[$locale];
                    } else {
                        $country = $record->country->names['en'];
                    }
                    $toReturn['country'] = $country;
                    break;
                case 'coordinates':
                    $toReturn['coordinates'] = [
                        'lat' => $record->location->latitude,
                        'lng' => $record->location->longitude,
                    ];
                    break;
                case 'countryCode':
                    $toReturn['countryCode'] = $record->country->isoCode;
                    break;
            }
        }

        return sizeof($toReturn) > 1 ? $toReturn : head($toReturn);
    }
}
