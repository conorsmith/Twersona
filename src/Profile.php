<?php

namespace Twersona;

use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local as Adapter;

class Profile
{
    public $id;
    public $id_str;
    public $name;
    public $screen_name;
    public $location;
    public $description;
    public $url;
    public $followers_count;
    public $friends_count;
    public $listed_count;
    public $created_at;
    public $favourites_count;
    public $utc_offset;
    public $time_zone;
    public $geo_enabled;
    public $verified;
    public $statuses_count;
    public $lang;
    public $contributors_enabled;
    public $is_translator;
    public $is_translation_enabled;
    public $profile_background_color;
    public $profile_background_image_url;
    public $profile_background_image_url_https;
    public $profile_background_tile;
    public $profile_image_url;
    public $profile_image_url_https;
    public $profile_link_color;
    public $profile_sidebar_border_color;
    public $profile_sidebar_fill_color;
    public $profile_text_color;
    public $profile_use_background_image;
    public $default_profile;
    public $default_profile_image;
    public $following;
    public $follow_request_sent;
    public $notifications;

    protected $mapper;

    public function __construct($twitterAPISettings)
    {
        $filesystem = new Filesystem(new Adapter(__DIR__.'/..'));
        $cache = new ProfileCache($filesystem, 'storage/profile-cache');

        $this->mapper = new ProfileMapper($twitterAPISettings, $cache);
        $this->parseData($this->mapper->read());
    }

    public function getBiggerProfileImageURL()
    {
        return $this->getProfileImageURL('bigger', $this->profile_image_url);
    }

    public function getBiggerProfileImageHTTPSURL()
    {
        return $this->getProfileImageURL('bigger', $this->profile_image_url_https);
    }

    public function getMiniProfileImageURL()
    {
        return $this->getProfileImageURL('mini', $this->profile_image_url);
    }

    public function getMiniProfileImageHTTPSURL()
    {
        return $this->getProfileImageURL('mini', $this->profile_image_url_https);
    }

    protected function getProfileImageURL($size, $profile_image_url)
    {
        if (in_array($size, array('bigger', 'normal', 'mini'))) {
            return str_replace('normal', $size, $profile_image_url);
        }

        return str_replace('_normal', '', $profile_image_url);
    }

    protected function parseData($profileData)
    {
        $this->id = $profileData->id;
        $this->id_str = $profileData->id_str;
        $this->name = $profileData->name;
        $this->screen_name = $profileData->screen_name;
        $this->location = $profileData->location;
        $this->description = $profileData->description;
        $this->url = $profileData->url;
        $this->followers_count = $profileData->followers_count;
        $this->friends_count = $profileData->friends_count;
        $this->listed_count = $profileData->listed_count;
        $this->created_at = $profileData->created_at;
        $this->favourites_count = $profileData->favourites_count;
        $this->utc_offset = $profileData->utc_offset;
        $this->time_zone = $profileData->time_zone;
        $this->geo_enabled = $profileData->geo_enabled;
        $this->verified = $profileData->verified;
        $this->statuses_count = $profileData->statuses_count;
        $this->lang = $profileData->lang;
        $this->contributors_enabled = $profileData->contributors_enabled;
        $this->is_translator = $profileData->is_translator;
        $this->is_translation_enabled = $profileData->is_translation_enabled;
        $this->profile_background_color = $profileData->profile_background_color;
        $this->profile_background_image_url = $profileData->profile_background_image_url;
        $this->profile_background_image_url_https = $profileData->profile_background_image_url_https;
        $this->profile_background_tile = $profileData->profile_background_tile;
        $this->profile_image_url = $profileData->profile_image_url;
        $this->profile_image_url_https = $profileData->profile_image_url_https;
        $this->profile_link_color = $profileData->profile_link_color;
        $this->profile_sidebar_border_color = $profileData->profile_sidebar_border_color;
        $this->profile_sidebar_fill_color = $profileData->profile_sidebar_fill_color;
        $this->profile_text_color = $profileData->profile_text_color;
        $this->profile_use_background_image = $profileData->profile_use_background_image;
        $this->default_profile = $profileData->default_profile;
        $this->default_profile_image = $profileData->default_profile_image;
        $this->following = $profileData->following;
        $this->follow_request_sent = $profileData->follow_request_sent;
        $this->notifications = $profileData->notifications;
    }
}
