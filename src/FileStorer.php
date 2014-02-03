<?php

namespace Twersona;

use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local as Adapter;

class FileStorer implements StorerInterface
{
    protected $filesystem;
    protected $file;

    public function __construct($file = null)
    {
        $this->filesystem = new Filesystem(new Adapter(__DIR__.'/..'));

        if (is_null($file)) {
            $this->file = 'storage/profile-cache';
        } else {
            $this->file = $file;
        }
    }

    public function hasCachedData()
    {
        return $this->filesystem->has($this->file) && $this->filesystem->getSize($this->file) > 0;
    }

    public function fetch()
    {
        return json_decode($this->filesystem->read($this->file));
    }

    public function store($data)
    {
        $this->filesystem->put($this->file, json_encode($data));
    }
}
