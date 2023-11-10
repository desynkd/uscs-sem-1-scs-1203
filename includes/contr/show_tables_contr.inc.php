<?php

declare(strict_types=1);

function createRecords(object $pdo, string $table) 
{
    //INPUT: php data object, table
    //OUTPUT: Return associative array of records in said table

    if (!empty($table))
    {
        return getRecords($pdo, $table);
    }
    return NULL;
}  
