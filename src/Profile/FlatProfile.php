<?php

namespace Twersona\Profile;

class FlatProfile implements ProfileInterface
{
    use ProfileTrait;

    public $id;
    public $idStr;
    public $name;
    public $screenName;
    public $location;
    public $description;
    public $url;
    public $followersCount;
    public $friendsCount;
    public $listedCount;
    public $createdAt;
    public $favouritesCount;
    public $utcOffset;
    public $timeZone;
    public $geoEnabled;
    public $verified;
    public $statusesCount;
    public $lang;
    public $contributorsEnabled;
    public $isTranslator;
    public $isTranslationEnabled;
    public $profileBackgroundColor;
    public $profileBackgroundImageURL;
    public $profileBackgroundImageURLHTTPS;
    public $profileBackgroundTile;
    public $profileImageURL;
    public $profileImageURLHTTPS;
    public $profileLinkColor;
    public $profileSidebarBorderColor;
    public $profileSidebarFillColor;
    public $profileTextColor;
    public $profileUseBackgroundImage;
    public $defaultProfile;
    public $defaultProfileImage;
    public $following;
    public $followRequestSent;
    public $notifications;

    public function __construct($profileData)
    {
        $this->id = $profileData->id;
        $this->idStr = $profileData->id_str;
        $this->name = $profileData->name;
        $this->screenName = $profileData->screen_name;
        $this->location = $profileData->location;
        $this->description = $profileData->description;
        $this->url = $profileData->url;
        $this->followersCount = $profileData->followers_count;
        $this->friendsCount = $profileData->friends_count;
        $this->listedCount = $profileData->listed_count;
        $this->createdAt = $profileData->created_at;
        $this->favouritesCount = $profileData->favourites_count;
        $this->utcOffset = $profileData->utc_offset;
        $this->timeZone = $profileData->time_zone;
        $this->geoEnabled = $profileData->geo_enabled;
        $this->verified = $profileData->verified;
        $this->statusesCount = $profileData->statuses_count;
        $this->lang = $profileData->lang;
        $this->contributorsEnabled = $profileData->contributors_enabled;
        $this->isTranslator = $profileData->is_translator;
        $this->isTranslationEnabled = $profileData->is_translation_enabled;
        $this->profileBackgroundColor = $profileData->profile_background_color;
        $this->profileBackgroundImageURL = $profileData->profile_background_image_url;
        $this->profileBackgroundImageURLHTTPS = $profileData->profile_background_image_url_https;
        $this->profileBackgroundTile = $profileData->profile_background_tile;
        $this->profileImageURL = $profileData->profile_image_url;
        $this->profileImageURLHTTPS = $profileData->profile_image_url_https;
        $this->profileLinkColor = $profileData->profile_link_color;
        $this->profileSidebarBorderColor = $profileData->profile_sidebar_border_color;
        $this->profileSidebarFillColor = $profileData->profile_sidebar_fill_color;
        $this->profileTextColor = $profileData->profile_text_color;
        $this->profileUseBackgroundImage = $profileData->profile_use_background_image;
        $this->defaultProfile = $profileData->default_profile;
        $this->defaultProfileImage = $profileData->default_profile_image;
        $this->following = $profileData->following;
        $this->followRequestSent = $profileData->follow_request_sent;
        $this->notifications = $profileData->notifications;
    }

    public function getProfileImageURL()
    {
        return $this->profileImageURL;
    }

    public function getProfileImageHTTPSURL()
    {
        return $this->profileImageURLHTTPS;
    }
}
