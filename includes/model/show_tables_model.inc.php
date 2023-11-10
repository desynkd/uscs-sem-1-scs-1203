<?php

declare(strict_types=1);

function getRecords(object $pdo, string $table)
{
    //INPUT: php data object, table name
    //OUTPUT: Associative Array of records
    if ($table == 'Pharmacies')
    {
        $query = "SELECT * FROM pharmacies";
    }
    else if ($table == 'Departments')
    {
        $query = "SELECT * FROM departments";
    }
    else if ($table == 'Department Staff')
    {
        $query = "SELECT * FROM department_staff";
    }
    else if ($table == 'CEOs')
    {
        $query = "SELECT * FROM ceos";
    }
    else if ($table == 'Chief Pharmacists')
    {
        $query = "SELECT * FROM chief_pharmacists";
    }
    else if ($table == 'Vital Signs')
    {
        $query = "SELECT * FROM vital_signs";
    }
    else if ($table == 'Diagnoses')
    {
        $query = "SELECT * FROM diagnoses";
    }
    else if ($table == 'Diagnosis By')
    {
        $query = "SELECT * FROM diagnosis_by";
    }
    else if ($table == 'Products')
    {
        $query = "SELECT * FROM products";
    }
    else if ($table == 'Categories')
    {
        $query = "SELECT * FROM categories";
    }
    else if ($table == 'Shelves')
    {
        $query = "SELECT * FROM shelves";
    }
    else if ($table == 'Medications')
    {
        $query = "SELECT * FROM medications";
    }
    else if ($table == 'Dispensings')
    {
        $query = "SELECT * FROM dispensings";
    }
    else if ($table == 'Orders')
    {
        $query = "SELECT * FROM orders";
    }
    else if ($table == 'Delivery Orders')
    {
        $query = "SELECT * FROM delivery_orders";
    }
    else
    {
        $query = NULL;
    }
    
    
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}
