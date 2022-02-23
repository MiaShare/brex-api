<?php

namespace MiaShare\BrexApi;


use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;

class BrexApi 
{
    use MakesHttpRequests;

	/**
	 * @var string
	 */
	private $api_token;
	private $api_base_url;

    /**
     * The Guzzle HTTP Client instance.
     *
     * @var \GuzzleHttp\Client
     */
    public $guzzle;

    /**
     * Number of seconds a request is retried.
     *
     * @var int
     */
    public $timeout = 30;

	/**
     * Create a new BrexApi instance.
     *
     * @param  string|null  $api_token
     * @param  \GuzzleHttp\Client|null  $guzzle
     * @return void
     */
	public function __construct($api_token = null, HttpClient $guzzle = null) 
    {
        $this->api_token = $api_token;
		$this->api_base_url = config('brex.url');

        if (! is_null($api_token)) {
            $this->setApiKey($api_token, $guzzle);
        }

        if (! is_null($guzzle)) {
            $this->guzzle = $guzzle;
        }
	}

    /**
     * Set the api key and setup the guzzle request object.
     *
     * @param  string  $api_token
     * @param  \GuzzleHttp\Client|null  $guzzle
     * @return $this
     */
    public function setApiKey($api_token, $guzzle = null)
    {
        $this->api_token = $api_token;

        $this->guzzle = $guzzle ?: new HttpClient([
            'base_uri' => config('brex.url'),
            'http_errors' => false,
            'headers' => [
                'Authorization' => 'Bearer '. $this->api_token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        return $this;
    }

    /**
     * Set a new timeout.
     *
     * @param  int  $timeout
     * @return $this
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;

        return $this;
    }
    
    /**
     * Get the timeout.
     *
     * @return int
     */
    public function getTimeout()
    {
        return $this->timeout;
    }
	
}