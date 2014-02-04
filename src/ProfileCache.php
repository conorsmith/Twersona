<?php

namespace Twersona;

use League\Flysystem\Filesystem;

class ProfileCache implements CacheInterface
{
    protected $filesystem;
    protected $key;
    protected $maxAge;

    public function __construct(Filesystem $filesystem, $key, $maxAge)
    {
        $this->filesystem = $filesystem;
        $this->key = $key;
        $this->maxAge = $maxAge;
    }

    public function isStale($timestampToCheck = null)
    {
        if (!$this->hasData()) {
            return true;
        }

        if (is_null($timestampToCheck)) {
            $timestampToCheck = time();
        }

        $timestamp = $this->filesystem->getTimestamp($this->key);

        return $timestamp + $this->maxAge < $timestampToCheck;
    }

    public function hasData()
    {
        return $this->filesystem->has($this->key) && $this->filesystem->getSize($this->key) > 0;
    }

    public function fetch()
    {
        return json_decode($this->filesystem->read($this->key));
    }

    public function store($data)
    {
        $this->filesystem->put($this->key, json_encode($data));
    }
}
