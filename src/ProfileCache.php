<?php

namespace Twersona;

use League\Flysystem\Filesystem;

class ProfileCache implements CacheInterface
{
    protected $filesystem;
    protected $key;

    public function __construct(Filesystem $filesystem, $key)
    {
        $this->filesystem = $filesystem;
        $this->key = $key;
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
