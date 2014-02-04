# Twersona
A library to watch a Twitter profile for any updates to profile information

This is very much a work in progress.

## Setup

If you are using local file storage for caching (the default), ensure that the `storage` directory is writable.

```
chmod a+w vendor/conorsmith/twersona/storage/
```

## Basic Usage

```
$factory = new Twersona\ProfileFactory(array(
    'oauth_access_token' => "...",
    'oauth_access_token_secret' => "...",
    'consumer_key' => "...",
    'consumer_secret' => "...",
));

$twitterProfile = $factory->buildProfile();

echo $twitterProfile->name;       // 'Conor Smith'
echo $twitterProfile->screenName; // 'conorsmith'
echo $twitterProfile->verified;    // false
```

You can also return a profile object with the exact keys used by the Twitter API, which are camelCase.

```
$twitterProfile = $factory->buildFlatProfileWithExactKeys();

echo $twitterProfile->name;        // 'Conor Smith'
echo $twitterProfile->screen_name; // 'conorsmith'
echo $twitterProfile->verified;    // false
```

## Profile Caching

Once the profile is retrieved it is cached. By default this caching is done using local file storage. This is done using the PHP League's [Flysystem package](http://flysystem.thephpleague.com/), which means you can inject your own filesystem object using a different adapter to store the profile somewhere else.

```
use Dropbox\Client;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local as Adapter;

$client = new Client($token, $appName);
$filesystem = new Filesystem(new Adapter($client, 'path/to/cache/dir'));

$factory = new Twersona\ProfileFactory($connConf, $filesystem);
```

You can change the default filename used for the profile cache, which is `twitter-profile-cache`, by passing in a third parameter to the constructor.

```
$factory = new Twersona\ProfileFactory($connConf, $filesystem, 'conorsmith-profile');
```