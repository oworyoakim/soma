<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Setting
 * @package App\Models
 * @property int id
 * @property string key
 * @property string val
 */
class Setting extends Model
{
    protected $table = 'settings';

    protected $guarded = [];

    public static function get($key)
    {
        $setting = Setting::query()->firstWhere('key', $key);
        if ($setting)
        {
            return $setting->val;
        }
        return null;
    }

    public static function set($key, $val)
    {
        $setting = Setting::query()->firstOrNew(['key' => $key]);
        $setting->val = $val;
        return $setting->save();
    }
}
