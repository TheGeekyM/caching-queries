# Laravel Query Cache Builder
If you are using [Barryvdh's Debug Bar](https://github.com/barryvdh/laravel-debugbar) and you're seeing tons of duplicate queries, and you simply have no time to track them all down.

![Screenshot](https://image.ibb.co/due1hy/before.png)


The package is caching all duplicates queries and it makes sure that you will never be executed the same query again, by overriding the method `runSelect` exsists in `Illuminate\Database\Query\Builder` that runs in every select query in Laravel, and we're going to cache every query by it's SQL and it's Bindings.

So instead of excuting a query, we will cache it as a key and it's results as a value.

If a query excutes, we will check if the query executed once before so we will retrieve the cached value or we will excute the query then cache it.

![Screenshot](https://image.ibb.co/dT4ted/after.png)


## Installation
1- Install using composer:
    
     composer require geeky/query-cache-builder


2- Add a custom Cache Driver. We're doing this so that we don't mess with any existing Cache logic you might already be using. In `~/config/cache.php` add below cache stores array :

```
Note: you can use what you want of cache drivers.

'stores' => [
'cache-builder' => [
'driver' => 'file',
'path'   => storage_path('framework/cache')
  ]
]

```

3- If you don't use auto-discovery, add the ServiceProvider to the providers array in config/app.php

    Geeky\Database\CacheBuilderServiceProvider::class
 
4- Copy the package config to your local config with the publish command:
     
    php artisan vendor:publish --provider="Geeky\Database\CacheBuilderServiceProvider"
This will publish the `cachebuilder` config file that gives you the ability to enable cahcing queries and the time you want to cache them.

**Note:** In case you used an `array cache driver` the quires will be cached in-memory Cache store that just stores everything inside an array. This is typically wiped at the end of each request,as once the application gives a response, this is naturally freed from memory. so it doesn't matter if you edit the minutes to 0 or any integer number.

```
<?php

return [

  'enable'  => true,

  'minutes' => 1, // 0 or null will cache all quieris forever

];

```


## Usage

Use the `CacheQueryBuilder trait` in any model you want to use this feature.

```
<?php

namespace App;

use Geeky\Database\CacheQueryBuilder;
use Illuminate\Database\Eloquent\Model;

class SomeModel extends Model
{
    use CacheQueryBuilder;
}
```

Use the below command if you want to flush the cache of our custom store 

    php artisan cache-builder:clear
