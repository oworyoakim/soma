<?php
/**
 * Created by PhpStorm.
 * User: Yoakim
 * Date: 10/27/2018
 * Time: 8:25 AM
 */

namespace App\Traits;



use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

trait ValidatesHttpRequests
{
    /**
     * @param array $data
     * @param array $rules
     * @return bool
     * @throws Exception
     */
    protected function validateData($data, $rules)
    {
        $validator = Validator::make($data, $rules);
        if ($validator->fails())
        {
            $errors = Collection::make();
            foreach ($validator->errors()->messages() as $key => $messages)
            {
                $field = ucfirst($key);
                $message = implode(', ', $messages);
                $error = "{$field}: {$message}";
                $errors->push($error);
            }
            throw new Exception($errors->implode('<br>'));
        }
        return true;
    }
}
