<?php namespace Clumsy\Utils\Library;

use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Config;

class HTTP {

	public function async($url)
	{
		$cmd = "curl -X GET '" . $url . "'";
		$cmd .= " > /dev/null 2>&1 &";	
		exec($cmd, $output, $exit);
		return $exit == 0;
	}
	
	public function get($url, $charset = 'UTF-8')
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_ENCODING , $charset);
		$html = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

        $response = array(
		    'html'      => $html,
		    'status'    => $http_status,
        );

        \Illuminate\Support\Facades\Log::info("(GET) URL: $url -- Response: " . print_r($response, true));

        return $response;
	}
	
    public function getJSON($url, $charset = 'UTF-8')
    {
        $response = $this->get($url, $charset);

        $response['json'] = json_decode($response['html']);

        $response['raw'] = $response['html'];
        unset($response['html']);

        return $response;
    }

	public function getXML($url, $charset = 'UTF-8')
	{
    	$response = $this->get($url, $charset);

        $xml = simplexml_load_string($response['html']);
        $xml = json_decode(json_encode($xml), true);
        $response['xml'] = $xml;

        $response['raw'] = $response['html'];
        unset($response['html']);
        
        return $response;
	}
	
	public function queueGet($url)
	{
    	Queue::push('\Clumsy\Utils\Library\HTTP', array('url' => $url, 'method' => 'get'));
	}

	public function post($url, $data, $charset = 'UTF-8')
	{
		foreach ($data as $key => $value)
		{
			$data[$key] = rawurlencode($key) . '=' . rawurlencode($value);
		}
		
		$data = implode('&', preg_replace('/%20/', '+', $data));
		$headers = array(
			'Content-Type: application/x-www-form-urlencoded',
		);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_ENCODING , $charset);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$html = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

        $response = array(
		    'html'      => $html,
		    'status'    => $http_status,
        );

        \Illuminate\Support\Facades\Log::info("(POST) URL: $url -- Response: " . print_r($response, true));

        return $response;
	}
	
	public function fire($job, $data)
	{
        $method = $data['method'];

        $this->$method($data['url']);
        
    	$job->delete();
	}
	
	public function buildQuery($query, $allow = array())
	{
        $map = array(
            '@' => '%40',
            '/' => '%2F',
            ':' => '%3A',
        );
        
        $replace = array_intersect_key($map, array_fill_keys($allow, ''));
        
        return str_replace(array_values($replace), array_keys($replace), http_build_query($query));
	}

	public function queryStringAdd($url, $key, $value = '')
	{
	    $url = preg_replace('/(.*)(\?|&)' . $key . '=[^&]+?(&)(.*)/i', '$1$2$4', $url . '&');
	    $url = substr($url, 0, -1);
	    
	    $value = $value ? "=".urlencode($value) : '';
	    
	    if (strpos($url, '?') === false)
	        return ($url . '?' . $key . $value);
	    else
	        return ($url . '&' . $key . $value);
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
    		
    		if ($newQs)
    			$url = $base.'?'.$newQs;
    		else
    			$url = $base;
        }
        return $url;
	}
}