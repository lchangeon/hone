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
 * DELETE builder for Postgres.
 *
 * @package Aura.SqlQuery
 *
 */
class DeleteBuilder extends Common\DeleteBuilder
{
    use BuildReturningTrait;
}
