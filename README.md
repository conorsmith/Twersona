# Twersona
A library to watch a Twitter profile for any updates to profile information

This is very much a work in progress.

## Setup

If you are using local file storage for caching (the default), ensure that the `storage` directory is writable.

```
chmod a+w vendor/conorsmith/twersona/storage/
```

## Usage

```
$twitterProfile = new Twersona\Profile(array(
    'oauth_access_token' => "...",
    'oauth_access_token_secret' => "...",
    'consumer_key' => "...",
    'consumer_secret' => "...",
));

echo $twitterProfile->name; // 'Conor Smith'
echo $twitterProfile->verified // false
```
