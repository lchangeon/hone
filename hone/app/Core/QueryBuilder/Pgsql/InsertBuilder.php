<?php
/**
 *
 * This file is part of Aura for PHP.
 *
 * @license http://opensource.org/licenses/mit-license.php MIT
 *
 */
namespace App\Core\QueryBuilder\Pgsql;

use App\Core\QueryBuilder\Common;

/**
 *
 * INSERT builder for Postgres.
 *
 * @package Aura.SqlQuery
 *
 */
class InsertBuilder extends Common\InsertBuilder
{
    use BuildReturningTrait;
}
