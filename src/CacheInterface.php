<?php

namespace Twersona;

interface CacheInterface
{
    public function hasData();

    public function fetch();

    public function store($data);
}
