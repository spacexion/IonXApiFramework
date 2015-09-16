# IonXApiFramework

IonXApiFramework is a Php framework created to help you build secured and flexible api for your projects.
It's built on top of doctrine for database management and another project of mine: JacksonPhp, for Json>Object mapping.


It's a framework thought to be simple, very much like Express for JavaScript (still I try :)).

Be gentle it's still a Work In Progress, it has many bugs and optimization issues but i'm working on it :)

If you want to try it, you can download it with composer, just put this in a composer.json :

```
{
  "repositories": [
    {
      "type": "git",
      "url": "https://github.com/spacexion/IonXApiFramework.git"
    },
    {
      "type": "git",
      "url": "https://github.com/spacexion/JacksonPhp.git"
    }
  ],
  "require": {
    "ionxlab/jacksonphp": "dev-master",
    "ionxlab/ionxapi": "dev-master"
  }
}
```

