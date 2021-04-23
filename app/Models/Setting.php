<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Config;

class Setting extends Model
{
    use HasFactory;
    

    /**
     * @var array
     */
    protected $fillable = ['key', 'value'];


    /**
     * @param $key
     * simply querying the record by $key and returning the value for a given key
     * Setting::get() 
     */
    public static function get($key)
    {
        $setting = new self();
        $entry = $setting->where('key', $key)->first();
        if (!$entry) {
            return;
        }
        return $entry->value;
    }

    /**
     * @param $key
     * @param null $value
     * @return bool
     * setting the current key/value for setting to the Laravel Configuration, 
     * so we can load them using the Laravel config() helper function.
     * Setting::set()
     */
    public static function set($key, $value = null)
    {
        $setting = new self();
        $entry = $setting->where('key', $key)->firstOrFail();
        $entry->value = $value;
        $entry->saveOrFail();
        Config::set('key', $value);
        if (Config::get($key) == $value) {
            return true;
        }
        return false;
    }

}
