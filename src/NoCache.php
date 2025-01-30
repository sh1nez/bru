<?php

namespace bru\api;

use bru\api\Exceptions\SimpleFileCacheException;
use Psr\SimpleCache\CacheInterface;

final class NoCache implements CacheInterface
{
	/**
	 * @var string
	 * Домашняя директория библиотеки
	 */
	/**
	 * SimpleFileCache constructor.
	 *
	 * @throws SimpleFileCacheException
	 */
	public function __construct() {}

	/**
	 * @param string $key
	 * @param null $default
	 *
	 * @return mixed
	 * @throws SimpleFileCacheException
	 */
	public function get(string $key, $default = null): mixed
	{
		return false;
	}

	/**
	 * @param string $key
	 * @param mixed $value
	 * @param null $ttl
	 *
	 * @return bool
	 * @throws SimpleFileCacheException
	 */
	public function set(string $key, mixed $value, $ttl = null): bool
	{
		return true;
	}

	/**
	 * @param string $key
	 *
	 * @return bool
	 */
	public function delete(string $key): bool
	{
		return false;
	}

	public function clear(): bool
	{
		return false;
	}

	public function getMultiple($keys, $default = null): iterable
	{
		return [];
	}

	public function setMultiple($values, $ttl = null): bool
	{
		return false;
	}

	public function deleteMultiple($keys): bool
	{
		return false;
	}

	/**
	 * @param string $key
	 *
	 * @return bool
	 */
	public function has(string $key): bool
	{
		return false;
	}
}
