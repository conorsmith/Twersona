<?php

namespace Twersona;

interface CacheInterface
{
    public function isStale($timestampToCheck = null);

    public function hasData();

    public function fetch();

    public function store($data);
}
