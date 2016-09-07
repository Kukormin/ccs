<?php
/*
 * Copyright 2015 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Auth;

use GuzzleHttp\Collection;
use GuzzleHttp\Event\RequestEvents;
use GuzzleHttp\Event\SubscriberInterface;
use GuzzleHttp\Event\BeforeEvent;

/**
 * ScopedAccessToken is a Guzzle Subscriber that adds an Authorization header
 * provided by a closure.
 *
 * The closure returns an access token, taking the scope, either a single
 * string or an array of strings, as its value.  If provided, a cache will be
 * used to preserve the access token for a given lifetime.
 *
 * Requests will be accessed with the authorization header:
 *
 * 'Authorization' 'Bearer <access token obtained from the closure>'
 */
class ScopedAccessToken implements SubscriberInterface
{
  const DEFAULT_CACHE_LIFETIME = 1500;

  /** @var An implementation of CacheInterface */
  private $cache;

  /** @var The access token generator function  */
  private $tokenFunc;

  /** @var The scopes used to generate the token */
  private $scopes;

  /** @var cache configuration */
  private $cacheConfig;

  /**
   * Creates a new ScopedAccessToken plugin.
   *
   * @param object $tokenFunc a token generator function
   * @param array|string scopes the token authentication scopes
   * @param cacheConfig configuration for the cache when it's present
   * @param object $cache an implementation of CacheInterface
   */
  public function __construct(callable $tokenFunc, $scopes, array $cacheConfig,
                              CacheInterface $cache=NULL)
  {
    $this->tokenFunc = $tokenFunc;
    if (!(is_string($scopes) || is_array($scopes))) {
      throw new \InvalidArgumentException(
          'wants scope should be string or array');
    }
    $this->scopes = $scopes;

    if (!is_null($cache)) {
      $this->cache = $cache;
      $this->cacheConfig = Collection::fromConfig($cacheConfig, [
          'lifetime' => self::DEFAULT_CACHE_LIFETIME,
          'prefix'   => ''
      ], []);
    }
  }

  /* Implements SubscriberInterface */
  public function getEvents()
  {
    return ['before' => ['onBefore', RequestEvents::SIGN_REQUEST]];
  }

  /**
   * Updates the request with an Authorization header when auth is 'scoped'.
   *
   *   E.g this could be used to authenticate using the AppEngine
   *   AppIdentityService.
   *
   *   use google\appengine\api\app_identity\AppIdentityService;
   *   use GuzzleHttp\Client;
   *   use Google\Auth\ScopedAccessToken;
   *
   *   $scope = 'https://www.googleapis.com/auth/taskqueue'
   *   $scoped = new ScopedAccessToken('AppIdentityService::getAccessToken',
   *                                   $scope,
   *                                   [ 'prefix' => 'Google\Auth\ScopedAccessToken::' ],
   *                                   $cache = new Memcache());
   *   $client = new Client([
   *      'base_url' => 'https://www.googleapis.com/taskqueue/v1beta2/projects/',
   *      'defaults' => ['auth' => 'scoped']
   *   ]);
   *
   *   $res = $client->get('myproject/taskqueues/myqueue');
   */
  public function onBefore(BeforeEvent $event)
  {
    // Requests using "auth"="scoped" will be authorized.
    $request = $event->getRequest();
    if ($request->getConfig()['auth'] != 'scoped') {
      return;
    }
    $auth_header = 'Bearer ' . $this->fetchToken();
    $request->setHeader('Authorization', $auth_header);
  }

  private function fetchToken()
  {
    // Determine if token is available in the cache, if not call tokenFunc to
    // fetch it.
    $token = false;
    $hasCache = !is_null($this->cache);
    if ($hasCache) {
      $token = $this->cache->get($this->buildCacheKey(), $this->cacheConfig['lifetime']);
    }
    if (!$token) {
      $token = call_user_func($this->tokenFunc, $this->scopes);
      if ($hasCache) {
        $this->cache->set($this->buildCacheKey(), $token);
      }
    }
    return $token;
  }

  private function buildCacheKey() {
    $cacheKey = $this->cacheConfig['prefix'];
    if (is_string($this->scopes)) {
      $cacheKey .= $this->scopes;
    } else if (is_array($this->scopes)) {
      $cacheKey .= implode(":", $this->scopes);
    }
    return $cacheKey;
  }

}
