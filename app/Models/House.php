<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    use HasFactory;

    public $timestamps = false;

    public static function selectListOfHouses($data)
    {
        $filteredData = array_filter($data);

        $houses = House::all()->toQuery();

        foreach ($filteredData as $key => $value) {
            if ($key == 'name') {
                $houses = $houses->where($key, 'like', '%' . $value . '%');
            } elseif ($key == 'minPrice') {
                $houses = $houses->where('price', '>=', $value);
            } elseif ($key == 'maxPrice') {
                $houses = $houses->where('price', '<=', $value);
            } else {
                $houses = $houses->where($key, $value);
            }

        }

        return $houses->get();
    }
}
