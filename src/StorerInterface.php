<?php

namespace Twersona;

interface StorerInterface
{
    public function hasCachedData();

    public function fetch();

    public function store($data);
}
