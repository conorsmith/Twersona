<?php

namespace Twersona\Profile;

trait ProfileTrait
{
    public function getBiggerProfileImageURL()
    {
        return $this->getProfileImageURL('bigger', $this->getProfileImageURL());
    }

    public function getBiggerProfileImageHTTPSURL()
    {
        return $this->getProfileImageURL('bigger', $this->getProfileImageHTTPSURL());
    }

    public function getMiniProfileImageURL()
    {
        return $this->getProfileImageURL('mini', $this->getProfileImageURL());
    }

    public function getMiniProfileImageHTTPSURL()
    {
        return $this->getProfileImageURL('mini', $this->getProfileImageHTTPSURL());
    }

    protected function getProfileImageURL($size, $profile_image_url)
    {
        if (in_array($size, array('bigger', 'normal', 'mini'))) {
            return str_replace('normal', $size, $profile_image_url);
        }

        return str_replace('_normal', '', $profile_image_url);
    }
}
