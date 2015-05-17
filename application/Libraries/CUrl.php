<?php


namespace Application\Libraries;


use Trident\Libraries\AbstractLibrary;

class CUrl extends AbstractLibrary
{

    /**
     * Get URL.
     *
     * @param string $url URL.
     *
     * @return string
     */
    public function getUrl($url)
    {
        $cUrl = curl_init();
        curl_setopt_array($cUrl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url
        ]);
        $response = curl_exec($cUrl);
        curl_close($cUrl);
        return $response;
    }

    public function postUrl($url, $postData = [])
    {
        $cUrl = curl_init();
        $postString = "";
        foreach ($postData as $key => $value)
        {
            $postString .= $key . "=" . urlencode($value) . "&";
        }
        $postString = rtrim($postData, "&");
        curl_setopt_array($cUrl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
            CURLOPT_POST => count($postData),
            CURLOPT_POSTFIELDS => $postString
        ]);
        $response = curl_exec($cUrl);
        curl_close($cUrl);
        return $response;
    }
}