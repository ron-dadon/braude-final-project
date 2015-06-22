<?php
/***********************************************************************************************************************
 * IACS Management System
 * ORT BRAUDE COLLEGE OF ENGINEERING
 * Information System Engineering - Final Project
 * Students: Ron Dadon, Guy Franco
 * Project adviser: PhD Miri Weiss-Cohen
 **********************************************************************************************************************/

namespace Application\Libraries;

use Trident\Libraries\AbstractLibrary;

/**
 * Class CUrl
 *
 * Simple AJAX like interface for PHP.
 *
 * @package Application\Libraries
 */
class CUrl extends AbstractLibrary
{

    /**
     * Perform a GET request.
     *
     * @param string $url Request URL.
     *
     * @return string|bool Response string or false on failure.
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

    /**
     * Perform a POST request.
     *
     * @param string $url Request URL.
     * @param array $postData POST data.
     *
     * @return string|bool Response string or false on failure.
     */
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