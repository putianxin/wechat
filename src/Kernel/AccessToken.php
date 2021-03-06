<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Ptx\Kernel;

use App\Libraries\Logger\Logger;
use Exception;
use Illuminate\Support\Facades\Redis;
use Ptx\Kernel\Contracts\AccessTokenInterface;
use Ptx\Kernel\Exceptions\HttpException;
use Ptx\Kernel\Exceptions\InvalidArgumentException;
use Ptx\Kernel\Exceptions\RuntimeException;
use Ptx\Kernel\Traits\HasHttpRequests;
use Ptx\Kernel\Traits\InteractsWithCache;
use Pimple\Container;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class AccessToken.
 *
 * @author overtrue <i@overtrue.me>
 */
abstract class AccessToken implements AccessTokenInterface
{
    use HasHttpRequests;
    use InteractsWithCache;

    /**
     * @var \Pimple\Container
     */
    protected $app;

    /**
     * @var string
     */
    protected $requestMethod = 'GET';

    /**
     * @var string
     */
    protected $endpointToGetToken;

    /**
     * @var string
     */
    protected $queryName;

    /**
     * @var array
     */
    protected $token;

    /**
     * @var int
     */
    protected $safeSeconds = 10;

    /**
     * @var string
     */
    protected $tokenKey = 'access_token';

    /**
     * @var string
     */
    protected $cachePrefix = 'easywechat.kernel.access_token.';

    /**
     * AccessToken constructor.
     *
     * @param \Pimple\Container $app
     */
    public function __construct(Container $app)
    {
        $this->app = $app;
    }

    /**
     * @return array
     *
     * @throws \Ptx\Kernel\Exceptions\HttpException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Ptx\Kernel\Exceptions\InvalidConfigException
     * @throws \Ptx\Kernel\Exceptions\InvalidArgumentException
     * @throws \Ptx\Kernel\Exceptions\RuntimeException
     */
    public function getRefreshedToken(): array
    {
        return $this->getToken(true);
    }

    /**
     * @param bool $refresh
     *
     * @return array
     *
     * @throws \Ptx\Kernel\Exceptions\HttpException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Ptx\Kernel\Exceptions\InvalidConfigException
     * @throws \Ptx\Kernel\Exceptions\InvalidArgumentException
     * @throws \Ptx\Kernel\Exceptions\RuntimeException
     */
    public function getToken(bool $refresh = false): array
    {
        $cacheKey = $this->getCacheKey();
        $cache = $this->getCache();

        if (!$refresh && $cache->has($cacheKey)) {
            return $cache->get($cacheKey);
        }

        $token = $this->requestToken($this->getCredentials(), true);

        $this->tokenLogger($token);

        $this->setToken($token[$this->tokenKey], $token['expires_in'] ?? 7200);
        $this->setOtherToken($token[$this->tokenKey], $token['expires_in'] ?? 7200);

        return $token;
    }

    private function tokenLogger($token)
    {
        try {
            $logger = Logger::init(Logger::CHANNEL_WECHAT);
            $logger->info('refreshToken', ['token' => $token]);
        }catch (Exception $exception){
            return $this;
        }
    }

    /**
     * @param string $token
     * @param int    $lifetime
     *
     * @return \Ptx\Kernel\Contracts\AccessTokenInterface
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Ptx\Kernel\Exceptions\RuntimeException
     */
    public function setToken(string $token, int $lifetime = 7200): AccessTokenInterface
    {
        $this->getCache()->set($this->getCacheKey(), [
            $this->tokenKey => $token,
            'expires_in' => $lifetime,
        ], $lifetime - $this->safeSeconds);

        if (!$this->getCache()->has($this->getCacheKey())) {
            throw new RuntimeException('Failed to cache access token.');
        }

        return $this;
    }

    public function setOtherToken(string $token,int $lifetime = 7200): AccessTokenInterface
    {
        try {
            $cache = Redis::connection('other');
            $cache->set($this->getCacheKey(), serialize([
                $this->tokenKey => $token,
                'expires_in' => $lifetime,
            ]), $lifetime - $this->safeSeconds);
        }catch (Exception $exception){
            return $this;
        }
        return $this;
    }

    /**
     * @return \Ptx\Kernel\Contracts\AccessTokenInterface
     *
     * @throws \Ptx\Kernel\Exceptions\HttpException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Ptx\Kernel\Exceptions\InvalidConfigException
     * @throws \Ptx\Kernel\Exceptions\InvalidArgumentException
     * @throws \Ptx\Kernel\Exceptions\RuntimeException
     */
    public function refresh(): AccessTokenInterface
    {
        $this->getToken(true);

        return $this;
    }

    /**
     * @param array $credentials
     * @param bool  $toArray
     *
     * @return \Psr\Http\Message\ResponseInterface|\Ptx\Kernel\Support\Collection|array|object|string
     *
     * @throws \Ptx\Kernel\Exceptions\HttpException
     * @throws \Ptx\Kernel\Exceptions\InvalidConfigException
     * @throws \Ptx\Kernel\Exceptions\InvalidArgumentException
     */
    public function requestToken(array $credentials, $toArray = false)
    {
        $response = $this->sendRequest($credentials);
        $result = json_decode($response->getBody()->getContents(), true);
        $formatted = $this->castResponseToType($response, $this->app['config']->get('response_type'));

        if (empty($result[$this->tokenKey])) {
            throw new HttpException('Request access_token fail: '.json_encode($result, JSON_UNESCAPED_UNICODE), $response, $formatted);
        }

        return $toArray ? $result : $formatted;
    }

    /**
     * @param \Psr\Http\Message\RequestInterface $request
     * @param array                              $requestOptions
     *
     * @return \Psr\Http\Message\RequestInterface
     *
     * @throws \Ptx\Kernel\Exceptions\HttpException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Ptx\Kernel\Exceptions\InvalidConfigException
     * @throws \Ptx\Kernel\Exceptions\InvalidArgumentException
     * @throws \Ptx\Kernel\Exceptions\RuntimeException
     */
    public function applyToRequest(RequestInterface $request, array $requestOptions = []): RequestInterface
    {
        parse_str($request->getUri()->getQuery(), $query);

        $query = http_build_query(array_merge($this->getQuery(), $query));

        return $request->withUri($request->getUri()->withQuery($query));
    }

    /**
     * Send http request.
     *
     * @param array $credentials
     *
     * @return ResponseInterface
     *
     * @throws \Ptx\Kernel\Exceptions\InvalidArgumentException
     */
    protected function sendRequest(array $credentials): ResponseInterface
    {
        $options = [
            ('GET' === $this->requestMethod) ? 'query' : 'json' => $credentials,
        ];

        return $this->setHttpClient($this->app['http_client'])->request($this->getEndpoint(), $this->requestMethod, $options);
    }

    /**
     * @return string
     */
    protected function getCacheKey()
    {
        return $this->cachePrefix.md5(json_encode($this->getCredentials()));
    }

    /**
     * The request query will be used to add to the request.
     *
     * @return array
     *
     * @throws \Ptx\Kernel\Exceptions\HttpException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Ptx\Kernel\Exceptions\InvalidConfigException
     * @throws \Ptx\Kernel\Exceptions\InvalidArgumentException
     * @throws \Ptx\Kernel\Exceptions\RuntimeException
     */
    protected function getQuery(): array
    {
        return [$this->queryName ?? $this->tokenKey => $this->getToken()[$this->tokenKey]];
    }

    /**
     * @return string
     *
     * @throws \Ptx\Kernel\Exceptions\InvalidArgumentException
     */
    public function getEndpoint(): string
    {
        if (empty($this->endpointToGetToken)) {
            throw new InvalidArgumentException('No endpoint for access token request.');
        }

        return $this->endpointToGetToken;
    }

    /**
     * @return string
     */
    public function getTokenKey()
    {
        return $this->tokenKey;
    }

    /**
     * Credential for get token.
     *
     * @return array
     */
    abstract protected function getCredentials(): array;
}
