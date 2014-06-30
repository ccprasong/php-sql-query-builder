<?php
/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 6/3/14
 * Time: 12:07 AM
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace NilPortugues\SqlQueryBuilder\Syntax;

use NilPortugues\SqlQueryBuilder\Manipulation\QueryException;

/**
 * Class Column
 * @package NilPortugues\SqlQueryBuilder\Syntax
 */
class Column implements QueryPart
{
    const ALL = '*';

    /**
     * @var Table
     */
    protected $table;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $alias;

    /**
     * @param      $name
     * @param      $table
     * @param null $alias
     */
    public function __construct($name, $table, $alias = null)
    {
        $this->setName($name);
        $this->setTable($table);
        $this->setAlias($alias);
    }

    /**
     * @return string
     */
    public function partName()
    {
        return 'COLUMN';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = (string) $name;

        return $this;
    }

    /**
     * @return Table
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param string|Table $table
     *
     * @return $this
     */
    public function setTable($table)
    {
        $newTable    = array($table);
        $this->table = SyntaxFactory::createTable($newTable);

        return $this;
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @param $alias
     *
     * @return $this
     * @throws QueryException
     */
    public function setAlias($alias)
    {
        if (is_null($alias)) {
            $this->alias = null;

            return $this;
        }

        if ($this->isAll()) {
            throw new QueryException("Can't use alias because column name is ALL (*)");
        }

        $this->alias = (string) $alias;

        return $this;
    }

    /**
     * Check whether column name is '*' or not
     * @return bool
     */
    public function isAll()
    {
        return $this->getName() == self::ALL;
    }
}