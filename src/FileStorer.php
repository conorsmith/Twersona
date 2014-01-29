<?php

namespace Twersona;

class FileStorer implements StorerInterface
{
    protected $file;

    public function __construct($file = null)
    {
        if (is_null($file)) {
            $this->file = dirname(__FILE__) . '/../storage/profile-cache';
        } else {
            $this->file = $file;
        }
    }

    public function hasCachedData()
    {
        return file_exists($this->file) && filesize($this->file) > 0;
    }

    public function fetch()
    {
        return json_decode(file_get_contents($this->file));
    }

    public function store($data)
    {
        file_put_contents($this->file, json_encode($data));
    }
}
