<?php


namespace App\Traits;


use Exception;
use Illuminate\Support\Facades\Http;

trait MakesZoomHttpRequests
{
    use ZoomJWT;

    protected function getZoom($url, array $query = [])
    {
        $zoomUrl = $this->getZoomUrl();
        if (empty($zoomUrl))
        {
            throw new Exception("Zoom API Base URL not set in .env file!");
        }
        $token = $this->generateZoomToken();
        $zoomRequestUrl = $zoomUrl . $url;
        $response = Http::withToken($token)
                        ->acceptJson()
                        ->get($zoomRequestUrl, $query);
        if (!$response->successful())
        {
            throw new Exception($response->body());
        }
        return $response->json();
    }

    protected function postZoom($url, array $data)
    {
        $zoomUrl = $this->getZoomUrl();
        if (empty($zoomUrl))
        {
            throw new Exception("Zoom API Base URL not set in .env file!");
        }
        $token = $this->generateZoomToken();
        $zoomRequestUrl = $zoomUrl . $url;
        $response = Http::withToken($token)
                        ->acceptJson()
                        ->contentType('application/json')
                        ->post($zoomRequestUrl, $data);
        if (!$response->successful())
        {
            throw new Exception($response->body());
        }
        return $response->json();
    }

    protected function putZoom($url, array $data)
    {
        $zoomUrl = $this->getZoomUrl();
        if (empty($zoomUrl))
        {
            throw new Exception("Zoom API Base URL not set in .env file!");
        }
        $token = $this->generateZoomToken();
        $zoomRequestUrl = $zoomUrl . $url;
        $response = Http::withToken($token)
                        ->acceptJson()
                        ->contentType('application/json')
                        ->put($zoomRequestUrl, $data);
        if (!$response->successful())
        {
            throw new Exception($response->body());
        }
        return $response->json();
    }

    protected function patchZoom($url, array $data)
    {
        $zoomUrl = $this->getZoomUrl();
        if (empty($zoomUrl))
        {
            throw new Exception("Zoom API Base URL not set in .env file!");
        }
        $token = $this->generateZoomToken();
        $zoomRequestUrl = $zoomUrl . $url;
        $response = Http::withToken($token)
                        ->acceptJson()
                        ->contentType('application/json')
                        ->patch($zoomRequestUrl, $data);
        if (!$response->successful())
        {
            throw new Exception($response->body());
        }
        return $response->json();
    }

    protected function deleteZoom($url, array $data)
    {
        $zoomUrl = $this->getZoomUrl();
        if (empty($zoomUrl))
        {
            throw new Exception("Zoom API Base URL not set in .env file!");
        }
        $token = $this->generateZoomToken();
        $zoomRequestUrl = $zoomUrl . $url;
        $response = Http::withToken($token)
                        ->acceptJson()
                        ->delete($zoomRequestUrl, $data);
        if (!$response->successful())
        {
            throw new Exception($response->body());
        }
        return $response->json();
    }
}
