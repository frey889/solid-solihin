## Cara user install:
```{
  "repositories": [
    {
      "type": "vcs",
      "url": "git@github.com:frey889/solid-solihin.git"
    }
  ]
}```


### Lalu:

```composer require monarch/solid-solihin```

atau 
```use Monarch\SolidSolihin\SolidSolihin;
use Monarch\SolidSolihin\Logger\Logger;

SolidSolihin::registerGlobalHandlers();

Logger::error(new Exception('Something broke'));
```

### .env 
SOLID_SOLIHIN_ENDPOINT
SOLID_SOLIHIN_PROJECT_CODE
SOLID_SOLIHIN_PROJECT_KEY