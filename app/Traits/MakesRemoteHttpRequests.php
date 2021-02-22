<?php
/**
 * Created by PhpStorm.
 * User: Yoakim
 * Date: 10/27/2018
 * Time: 8:25 AM
 */

namespace App\Traits;



use Exception;
use Illuminate\Support\Facades\Http;

trait MakesRemoteHttpRequests
{
    /**
     * @var string
     */
    protected $urlEndpoint;

    /**
     * @param string $url
     * @param array $query
     * @return array
     * @throws Exception
     */
    protected function get(string $url, array $query = [])
    {
        $response = Http::get($url, $query);
        if (!$response->ok())
        {
            throw new Exception($response->body());
        }
        return $response->json();
    }

    /**
     * @param $url
     * @param $data
     * @return array
     * @throws Exception
     */
    protected function post($url, $data)
    {
        $response = Http::post($url, $data);
        if (!$response->ok())
        {
            throw new Exception($response->body());
        }
        return $response->json();
    }


    /**
     * @param $url
     * @param $data
     * @return array
     * @throws Exception
     */
    protected function put($url, $data)
    {
        $response = Http::put($url, $data);
        if (!$response->ok())
        {
            throw new Exception($response->body());
        }
        return $response->json();
    }

    /**
     * @param $url
     * @param $data
     * @return array
     * @throws Exception
     */
    protected function patch($url, $data)
    {
        $response = Http::patch($url, $data);
        if (!$response->ok())
        {
            throw new Exception($response->body());
        }
        return $response->json();
    }
}
