<?php

namespace Twersona\Profile;

interface ProfileInterface
{
    public function getProfileImageURL();

    public function getProfileImageHTTPSURL();

    public function getBiggerProfileImageURL();

    public function getBiggerProfileImageHTTPSURL();

    public function getMiniProfileImageURL();

    public function getMiniProfileImageHTTPSURL();
}
