<?php

namespace Geeky\Database;

use Cache;
use Illuminate\Database\Query\Builder;

class CacheBuilder extends Builder
{


    /**
     * Run the query as a "select" statement against the connection.
     * This method is overiding the metheod in parent class.
     *
     * @return array
     */
    protected function runSelect()
    {
        if(config('cachebuilder.enable')) 
            return config('cachebuilder.minutes') ? $this->cacheQuery() : $this->cacheQueryForEver();

        return parent::runSelect();
    }


    /**
     * If the query excuted once before in the whole request life cycle it will preserve the values in a key(consists 
     * of the query and it's bindings) and just return the value without excuting the query again. 
     */
    function cacheQuery()
    {
        return Cache::store('cache-builder')->remember($this->queryCacheKey(), $this->getMinutes() , function() {
            return parent::runSelect();
        });
    }

    /**
     * Cache query for ever
     */ 
    function cacheQueryForEver()
    {

        return Cache::store('cache-builder')->rememberForever($this->queryCacheKey() , function() {
            return parent::runSelect();
        });   
    }

    /**
     * Returns a unique json key depends on query and it's bindings.
     *
     * @return string
     */
    protected function queryCacheKey()
    {
        return json_encode([$this->toSql() => $this->getBindings()]);
    }

    /**
     *  return sppecified number of minutes for which the value should be cached from config file.
     * 
     */

    public static function getMinutes()
    {
        return config('cachebuilder.minutes');
    }

}