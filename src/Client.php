<?php

namespace Retrofico\Retrofico;

use Exceptions\MissingTeamIdOrApiKeyException;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use League\Uri\Http;
use League\Uri\Modifiers\AppendSegment;

/**
 * Minimalist retrofi.co API wrapper
 * This wrapper: https://github.com/retrofico/retrofico-php
 *
 * @author  Remy Vanherweghem <remy@retrofi.co>
 */
class Client
{
    protected $config;

    const METHOD_GET = 'GET';
    const METHOD_PUT = 'PUT';
    const METHOD_POST = 'POST';
    const METHOD_DELETE = 'DELETE';

    /**
     * Sample constructor.
     *
     * @param \Nextpack\Nextpack\Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;

        $this->http_client = new GuzzleClient([
            'timeout' => 30,
            'connect_timeout' => 5,
        ]);

    }

    /**
     * Generate an api endpoint base path.
     *
     * @param boolean $withTeam include the team (for team specific endpoints)
     * @return \League\Uri\Http
     */
    protected function getBaseEndpoint(bool $withTeam = true): Http
    {
        // https://retrofi.co/api/
        $url = Http::createFromString(Config::API_BASE_PATH);

        // Append version `/1/`
        $versionedBasePathModifier = new AppendSegment($this->config->get("version"));
        $url = $versionedBasePathModifier->process($url);

        // Append team_id if applicable `/teams/1234/`
        if ($withTeam) {
            $teamedBasePathModifier = new AppendSegment("teams/" . $this->config->get("team_id"));
            $url = $teamedBasePathModifier->process($url);
        }

        return $url;
    }

    /**
     * Transform a raw string path to a PSR7 url object
     *
     * @param string $path
     * @return Http
     */
    protected function generateRawUrl(string $path): Http
    {
        $baseEndpoint = $this->getBaseEndpoint();
        $baseEndpointModifier = new AppendSegment($path);
        return $baseEndpointModifier->process($baseEndpoint);
    }

    /**
     * This is the main method of this wrapper. It will
     * sign a given query and return its result.
     *
     * @param string               $method           HTTP method of request (GET,POST,PUT,DELETE)
     * @param string               $path             relative url of API request
     * @param \stdClass|array|null $body          body of the request
     *
     * @return array
     */
    protected function rawCall(string $method, string $path, $body = null)
    {
        if (!$this->config->get("team_id") || !$this->config->get("api_key")) {
            throw new MissingTeamIdOrApiKeyException("Missing `team_id` and/or an `api_key`.");
        }

        $url = $this->generateRawUrl($path);
        var_dump($url);

        $request = new Request($method, $url);

        exit();

    }
    /**
     * Decode a Response object body to an Array
     *
     * @param  Response $response
     *
     * @return array
     */
    private function decodeResponse(Response $response)
    {
        return json_decode($response->getBody(), true);
    }
    /**
     * Wrap call to APIs for GET requests
     *
     * @param string $path    path ask inside api
     * @param array  $params a key-value list of parameters to append to the url.
     *
     * @return array
     * @throws \GuzzleHttp\Exception\ClientException if http request is an error
     */
    public function get(string $path, ?array $params = null)
    {
        return $this->decodeResponse(
            $this->rawCall(self::METHOD_GET, $path, $params)
        );

    }

}
