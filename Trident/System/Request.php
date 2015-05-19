<?php


namespace Trident\System;

use \Trident\Request\Post;
use \Trident\Request\Get;
use \Trident\Request\Files;
use \Trident\Request\Cookie;

class Request
{

    /**
     * Post instance.
     *
     * @var Post
     */
    private $_post;

    /**
     * Get instance.
     *
     * @var Get
     */
    private $_get;

    /**
     * Files instance.
     *
     * @var Files
     */
    private $_files;

    /**
     * Cookie instance.
     *
     * @var Cookie
     */
    private $_cookie;

    /**
     * Request client's ip address.
     *
     * @var string
     */
    private $_ip;

    /**
     * Request URI.
     *
     * @var string
     */
    private $_uri;

    /**
     * Request type (GET, POST etc.).
     *
     * @var string
     */
    private $_type;

    /**
     * Client browser name.
     *
     * @var string
     */
    private $_browser;

    /**
     * Client platform name.
     *
     * @var string
     */
    private $_platform;

    /**
     * Client browser version.
     *
     * @var string
     */
    private $_browser_version;

    /**
     * Is the request a secure (https) request.
     *
     * @var bool
     */
    private $_https;

    /**
     * Is the request an AJAX request.
     *
     * @var bool
     */
    private $_ajax;

    /**
     * Initialize request.
     */
    function __construct()
    {
        $this->_cookie = new Cookie();
        $this->_files = new Files();
        $this->_get = new Get();
        $this->_post = new Post();
        $this->_uri = $_SERVER['REQUEST_URI'];
        $this->_type = $_SERVER['REQUEST_METHOD'];
        $this->_https = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') || $_SERVER['SERVER_PORT'] === 443;
        $this->_ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
                       strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
        $this->_ip = $this->_parse_ip();
        $agent = $this->_parse_user_agent();
        $this->_browser = $agent['browser'];
        $this->_platform = $agent['platform'];
        $this->_browser_version = $agent['version'];
    }

    /**
     * Parses the client ip from the global server array.
     *
     * @return string The client's ip address.
     */
    private function _parse_ip()
    {
        if (isset($_SERVER['HTTP_CLIENT_IP']))
        {
            $ip_address = $_SERVER['HTTP_CLIENT_IP'];
        }
        else
        {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            {
                $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
            else
            {
                if (isset($_SERVER['HTTP_X_FORWARDED']))
                {
                    $ip_address = $_SERVER['HTTP_X_FORWARDED'];
                }
                else
                {
                    if (isset($_SERVER['HTTP_FORWARDED_FOR']))
                    {
                        $ip_address = $_SERVER['HTTP_FORWARDED_FOR'];
                    }
                    else
                    {
                        if (isset($_SERVER['HTTP_FORWARDED']))
                        {
                            $ip_address = $_SERVER['HTTP_FORWARDED'];
                        }
                        else
                        {
                            if (isset($_SERVER['REMOTE_ADDR']))
                            {
                                $ip_address = $_SERVER['REMOTE_ADDR'];
                            }
                            else
                            {
                                $ip_address = '0.0.0.0';
                            }
                        }
                    }
                }
            }
        }
        return $ip_address;
    }

    /**
     * Parses a user agent string into its important parts.
     *
     * @author Jesse G. Donat <donatj@gmail.com>
     * @link   https://github.com/donatj/PhpUserAgent
     * @link   http://donatstudios.com/PHP-Parser-HTTP_USER_AGENT
     *
     * @param string|null $user_agent User agent string to parse or null. Uses $_SERVER['HTTP_USER_AGENT'] on null.
     *
     * @return string[] An array with browser, version and platform keys.
     */
    private function _parse_user_agent($user_agent = null)
    {
        if (is_null($user_agent))
        {
            if (isset($_SERVER['HTTP_USER_AGENT']))
            {
                $user_agent = $_SERVER['HTTP_USER_AGENT'];
            }
            else
            {
                $user_agent = '';
            }
        }
        $platform = null;
        $browser = null;
        $version = null;
        $empty = ['platform' => $platform, 'browser' => $browser, 'version' => $version];
        if (!$user_agent)
        {
            return $empty;
        }
        if (preg_match('/\((.*?)\)/im', $user_agent, $parent_matches))
        {
            preg_match_all('/(?P<platform>BB\d+;|Android|CrOS|Tizen|iPhone|iPad|Linux|Macintosh|Windows(\ Phone)?|Silk|linux-gnu|BlackBerry|PlayBook|(New\ )?Nintendo\ (WiiU?|3DS)|Xbox(\ One)?)
				(?:\ [^;]*)?
				(?:;|$)/imx', $parent_matches[1], $result, PREG_PATTERN_ORDER);
            $priority = ['Android', 'Xbox One', 'Xbox', 'Tizen'];
            $result['platform'] = array_unique($result['platform']);
            if (count($result['platform']) > 1)
            {
                if ($keys = array_intersect($priority, $result['platform']))
                {
                    $platform = reset($keys);
                }
                else
                {
                    $platform = $result['platform'][0];
                }
            }
            elseif (isset($result['platform'][0]))
            {
                $platform = $result['platform'][0];
            }
        }
        if ($platform == 'linux-gnu')
        {
            $platform = 'Linux';
        }
        elseif ($platform == 'CrOS')
        {
            $platform = 'Chrome OS';
        }
        preg_match_all('%(?P<browser>Camino|Kindle(\ Fire\ Build)?|Firefox|Iceweasel|Safari|MSIE|Trident|AppleWebKit|TizenBrowser|Chrome|
			Vivaldi|IEMobile|Opera|OPR|Silk|Midori|Edge|CriOS|
			Baiduspider|Googlebot|YandexBot|bingbot|Lynx|Version|Wget|curl|
			NintendoBrowser|PLAYSTATION\ (\d|Vita)+)
			(?:\)?;?)
			(?:(?:[:/ ])(?P<version>[0-9A-Z.]+)|/(?:[A-Z]*))%ix',
                       $user_agent, $result, PREG_PATTERN_ORDER);
        // If nothing matched, return null (to avoid undefined index errors)
        if (!isset($result['browser'][0]) || !isset($result['version'][0]))
        {
            if (!$platform && preg_match('%^(?!Mozilla)(?P<browser>[A-Z0-9\-]+)(/(?P<version>[0-9A-Z.]+))?([;| ]\ ?.*)?$%ix', $user_agent, $result)
            )
            {
                return ['platform' => null, 'browser' => $result['browser'], 'version' => isset($result['version']) ? $result['version'] ?: null : null];
            }
            return $empty;
        }
        if (preg_match('/rv:(?P<version>[0-9A-Z.]+)/si', $user_agent, $rv_result))
        {
            $rv_result = $rv_result['version'];
        }
        $browser = $result['browser'][0];
        $version = $result['version'][0];
        $find = function ($search, &$key) use ($result)
        {
            $x_key = array_search(strtolower($search), array_map('strtolower', $result['browser']));
            if ($x_key !== false)
            {
                $key = $x_key;
                return true;
            }
            return false;
        };
        $key = 0;
        $e_key = 0;
        if ($browser == 'Iceweasel')
        {
            $browser = 'Firefox';
        }
        elseif ($find('Playstation Vita', $key))
        {
            $platform = 'PlayStation Vita';
            $browser = 'Browser';
        }
        elseif ($find('Kindle Fire Build', $key) || $find('Silk', $key))
        {
            $browser = $result['browser'][$key] == 'Silk' ? 'Silk' : 'Kindle';
            $platform = 'Kindle Fire';
            if (!($version = $result['version'][$key]) || !is_numeric($version[0]))
            {
                $version = $result['version'][array_search('Version', $result['browser'])];
            }
        }
        elseif ($find('NintendoBrowser', $key) || $platform == 'Nintendo 3DS')
        {
            $browser = 'NintendoBrowser';
            $version = $result['version'][$key];
        }
        elseif ($find('Kindle', $key))
        {
            $browser = $result['browser'][$key];
            $platform = 'Kindle';
            $version = $result['version'][$key];
        }
        elseif ($find('OPR', $key))
        {
            $browser = 'Opera Next';
            $version = $result['version'][$key];
        }
        elseif ($find('Opera', $key))
        {
            $browser = 'Opera';
            $find('Version', $key);
            $version = $result['version'][$key];
        }
        elseif ($find('Midori', $key))
        {
            $browser = 'Midori';
            $version = $result['version'][$key];
        }
        elseif ($browser == 'MSIE' || ($rv_result && $find('Trident', $key)) || $find('Edge', $e_key))
        {
            $browser = 'MSIE';
            if ($find('IEMobile', $key))
            {
                $browser = 'IEMobile';
                $version = $result['version'][$key];
            }
            elseif ($e_key)
            {
                $version = $result['version'][$e_key];
            }
            else
            {
                $version = $rv_result ?: $result['version'][$key];
            }
        }
        elseif ($find('Vivaldi', $key))
        {
            $browser = 'Vivaldi';
            $version = $result['version'][$key];
        }
        elseif ($find('Chrome', $key) || $find('CriOS', $key))
        {
            $browser = 'Chrome';
            $version = $result['version'][$key];
        }
        elseif ($browser == 'AppleWebKit')
        {
            if (($platform == 'Android' && !($key = 0)))
            {
                $browser = 'Android Browser';
            }
            elseif (strpos($platform, 'BB') === 0)
            {
                $browser = 'BlackBerry Browser';
                $platform = 'BlackBerry';
            }
            elseif ($platform == 'BlackBerry' || $platform == 'PlayBook')
            {
                $browser = 'BlackBerry Browser';
            }
            elseif ($find('Safari', $key))
            {
                $browser = 'Safari';
            }
            elseif ($find('TizenBrowser', $key))
            {
                $browser = 'TizenBrowser';
            }
            $find('Version', $key);
            $version = $result['version'][$key];
        }
        elseif ($key = preg_grep('/playstation \d/i', array_map('strtolower', $result['browser'])))
        {
            $key = reset($key);
            $platform = 'PlayStation ' . preg_replace('/[^\d]/i', '', $key);
            $browser = 'NetFront';
        }
        return ['platform' => $platform ?: null, 'browser' => $browser ?: null, 'version' => $version ?: null];
    }

    /**
     * @return boolean
     */
    public function isAjax()
    {
        return $this->_ajax;
    }

    /**
     * @return boolean
     */
    public function isPost()
    {
        return $this->_type === 'POST';
    }

    /**
     * @return string
     */
    public function getBrowser()
    {
        return $this->_browser;
    }

    /**
     * @return string
     */
    public function getBrowserVersion()
    {
        return $this->_browser_version;
    }

    /**
     * @return Cookie
     */
    public function getCookie()
    {
        return $this->_cookie;
    }

    /**
     * @return Files
     */
    public function getFiles()
    {
        return $this->_files;
    }

    /**
     * @return Get
     */
    public function getGet()
    {
        return $this->_get;
    }

    /**
     * @return boolean
     */
    public function isHttps()
    {
        return $this->_https;
    }

    /**
     * @return string
     */
    public function getIp()
    {
        return $this->_ip;
    }

    /**
     * @return string
     */
    public function getPlatform()
    {
        return $this->_platform;
    }

    /**
     * @return Post
     */
    public function getPost()
    {
        return $this->_post;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * @return string
     */
    public function getURI()
    {
        return $this->_uri;
    }

}