<?php

namespace Support\Database\Schema;

use Illuminate\Database\Schema\MySqlBuilder;

class Builder extends MySqlBuilder
{
    /*
     * Determine if the given table has a given index in given column(s).
     * @param string $table
     * @param string|array $column
     * @param string|null $indexName
     * @return bool
     * */
    public function hasIndex($table, $column, $indexName = null): bool
    {
        if (is_null($indexName)) {
            $indexName = $table . '_' . $column . '_index';
        }
        if (!is_array($column)) {
            $column = [$column];
        }
        $table = $this->connection->getTablePrefix() . $table;

        $tableIndexes = $this->connection->getDoctrineSchemaManager()->listTableIndexes($table);

        foreach ($tableIndexes as $tableIndex) {
            if ($tableIndex->getName() === $indexName && !count(array_diff($column, $tableIndex->getColumns()))) {
                return true;
            }
        }

        return false;
    }
}
