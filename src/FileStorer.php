<?php

namespace Twersona;

use League\Flysystem\Filesystem;

class FileStorer implements StorerInterface
{
    protected $filesystem;
    protected $file;

    public function __construct(Filesystem $filesystem, $file)
    {
        $this->filesystem = $filesystem;
        $this->file = $file;
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
