<?php

namespace Geeky\Database;

use Cache;

trait CacheQueryBuilder
{
    /**
     * Get a new query builder instance for the connection.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function newBaseQueryBuilder()
    {
        $connection = $this->getConnection();

        return new CacheBuilder(
            $connection, $connection->getQueryGrammar(), $connection->getPostProcessor()
        );

    }

}