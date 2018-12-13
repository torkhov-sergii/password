<?php

namespace App\Models\Traits;

use App\Models\Location;

trait Locationable
{

    // $this->saveLocations($request->only('locations'));
    public function saveLocations($data) {
        $locationModel = new Location();

        //массив всех локаций компании
        $all_locations_arr = $this->locations->pluck('id')->all();
        $item_location = '';

        if(count($data['locations']) > 0) {

            foreach($data['locations']['location'] as $key => $location) {

                //if($location != '' || $data['locations']['country'][$key] != '' || $data['locations']['city'][$key] != '') {
                    $arr = [];
                    if($data['locations']['location'][$key])    $arr['location']    =   $data['locations']['location'][$key];
                    if($data['locations']['lat'][$key])         $arr['lat']         =   number_format($data['locations']['lat'][$key], 2);
                    if($data['locations']['lng'][$key])         $arr['lng']         =   number_format($data['locations']['lng'][$key], 2);
                    if($data['locations']['country'][$key])     $arr['country']     =   $data['locations']['country'][$key];
                    if($data['locations']['city'][$key])        $arr['city']        =   $data['locations']['city'][$key];
                    if($data['locations']['postal_code'][$key]) $arr['postal_code'] =   $data['locations']['postal_code'][$key];
                    if($data['locations']['manually'][$key])    $arr['manually']    =   $data['locations']['manually'][$key];

                    if($arr['country']) $arr['country_slug'] = str_slug($arr['country']);
                    if($arr['city']) $arr['city_slug'] = str_slug($arr['city']);

                    $item_location = $locationModel->firstOrNew($arr);

                    //удаляем из массива локаций элементы которые обновились
                    if(($key = array_search($item_location->id, $all_locations_arr)) !== false) {
                        unset($all_locations_arr[$key]);
                    }
                    $this->locations()->save($item_location);
                //}

                //удалить локацию если пустые поля
                if($location == '' || $data['locations']['country'][$key] == '' || $data['locations']['city'][$key] == '') {
                    $item_location->delete();
                }

            }
        }

        //удаляем локации которых мы не нашли выше
        Location::whereIn('id', $all_locations_arr)->delete();

        //заполним все slug
        $locations = Location::where('country_slug', '=', '')
            ->orWhere('city_slug', '=', '')
            //->limit(1000)
            ->get();
        foreach ($locations as $location) {
            $location->country_slug = str_slug($location->country);
            $location->city_slug = str_slug($location->city);
            $location->save();
        }

        return $item_location;
    }

    public function location_full_readable() {
        if($this->location) {
            $location = $this->location->country.', '.$this->location->city;
            return $location;
        }
    }

    //location
    public function locations() {
        return $this->morphMany('App\Models\Location', 'locations');
    }

    //location
    public function location() {
        return $this->morphOne('App\Models\Location', 'locations');
    }

}
