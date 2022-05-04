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
    private $idempotent_key;

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
	public function __construct($api_token = null, HttpClient $guzzle = null, string $idempotent_key = null)
    {
        $this->api_token = $api_token;
		$this->api_base_url = config('brex.url');
        $this->idempotent_key = $idempotent_key;

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

        $headers = [
            'Authorization' => 'Bearer '. $this->api_token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        if($this->idempotent_key) {
            $headers['Idempotency-Key'] = $this->idempotent_key;
        }

        $this->guzzle = $guzzle ?: new HttpClient([
            'base_uri' => config('brex.url'),
            'http_errors' => false,
            'headers' => $headers,
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


    /**
     * Team
     */

    /**
     * This endpoint returns the company associated with the OAuth2 access token.
     */
    public function getCompany()
    {
        return $this->get($this->api_base_url . '/v2/company');
    }


    /**
     * Payments
     */

    /**
     * This endpoint lists all existing vendors for an account. Takes an optional parameter to match by vendor name.
     */
    public function listVendors(string $cursor = null, int $limit = null, string $name = null)
    {
        return $this->get($this->api_base_url . '/v1/vendors');
    }

    /**
     * This endpoint gets a vendor by ID.
     */
    public function getVendor(string $vendor = null)
    {
        return $this->get($this->api_base_url . '/v1/vendors/' . $vendor);
    }

    /**
     * This endpoint lists existing transfers for an account.
     */
    public function listTransfers(string $cursor = null, int $limit = null)
    {
        return $this->get($this->api_base_url . '/v1/transfers');
    }

    /**
     * This endpoint creates a new transfer.
     */
    public function createTransfer(array $payload = [])
    {
        return $this->post($this->api_base_url . '/v1/transfers', ['json' => $payload]);
    }


    /**
     * Transactions
     */

    /**
     * This endpoint lists all the existing cash accounts with their status.
     */
    public function listCashAccounts()
    {
        return $this->get($this->api_base_url . '/v2/accounts/cash');
    }

}
