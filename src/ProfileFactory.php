<?php

namespace Twersona;

use Twersona\Profile\FlatProfile;
use Twersona\Profile\FlatExactKeysProfile;

use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local as Adapter;

class ProfileFactory
{
    protected $mapper;

    public function __construct(array $twitterAPISettings, Filesystem $filesystem = null, $filesystemKey = null)
    {
        if (is_null($filesystem)) {
            $filesystem = new Filesystem(new Adapter(__DIR__.'/../storage'));
        }

        if (is_null($filesystemKey)) {
            $filesystemKey = 'twitter-profile-cache';
        }

        $this->mapper = new ProfileMapper($twitterAPISettings, new ProfileCache($filesystem, $filesystemKey));
    }

    public function buildProfile()
    {
        return $this->buildFlatProfile();
    }

    public function buildFlatProfile()
    {
        $profileData = $this->getProfileData();
        return new FlatProfile($profileData);
    }

    public function buildFlatProfileWithExactKeys()
    {
        $profileData = $this->getProfileData();
        return new FlatExactKeysProfile($profileData);
    }

    protected function getProfileData()
    {
        return $this->mapper->read();
    }
}
