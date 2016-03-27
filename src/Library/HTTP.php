<?php

namespace Clumsy\Utils\Library;

use Illuminate\Support\Facades\Request;

class HTTP
{
    public function buildQuery($query, $allow = [])
    {
        $map = [
            '@' => '%40',
            '/' => '%2F',
            ':' => '%3A',
        ];

        $replace = array_intersect_key($map, array_fill_keys($allow, ''));

        return str_replace(array_values($replace), array_keys($replace), http_build_query($query));
    }

    public function queryStringAdd($url, $keys, $value = null)
    {
        if (is_array($keys)) {
            foreach ($keys as $key => $value) {
                $url = $this->queryStringAdd($url, $key, $value);
            }

            return $url;
        }

        $url = preg_replace('/(.*)(\?|&)'.$keys.'=[^&]+?(&)(.*)/i', '$1$2$4', $url . '&');
        $url = substr($url, 0, -1);

        $value = (is_null($value) || $value === false) ? '' : "=".urlencode($value);

        return $url.(strpos($url, '?') === false ? '?' : '&').$keys.$value;
    }

    public function queryStringRemove($url, $keys)
    {
        foreach ((array)$keys as $key) {
            $parts = parse_url($url);
            $qs = isset($parts['query']) ? $parts['query'] : '';
            $base = $qs ? mb_substr($url, 0, mb_strpos($url, '?')) : $url; // all of URL except QS

            parse_str($qs, $qsParts);
            unset($qsParts[$key]);
            $newQs = rtrim(http_build_query($qsParts), '=');

            $url = $base.($newQs ? '?'.$newQs : '');
        }
        return $url;
    }

    public function isCrawler()
    {
        $crawlers = file(__DIR__.'/../support/crawlers.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        return in_array(request()->header('user-agent'), $crawlers);
    }
}
