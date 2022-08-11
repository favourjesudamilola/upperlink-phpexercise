<?php

declare(strict_types = 1);

// Your Code
function getFile() {
    $fileOpen = fopen("../transaction_files/sample_1.csv", "r");

    while (($data = fgetcsv($fileOpen, 1000, ",")) !== FALSE) {
        $array[] = $data;
    };

    fclose($fileOpen);

    return $array;
}

function getTotals() {
    $data = getFile();
    $dataLen = count($data);
    $incomeSum = 0;
    $expenseSum = 0;
    
    for ($i=1; $i<$dataLen; $i++) {
        $lastInd = count($data[$i]) - 1;
        $arrVal = $data[$i][$lastInd];
        if (!str_starts_with($arrVal, "-")) {       // check if positive value
            $incomeVal = trim_data($arrVal);
            $incomeSum += $incomeVal;
        } else {
            $expenseVal = trim_data($arrVal);
            $expenseSum += $expenseVal;
        }
    }
    $netTotal = $incomeSum + $expenseSum;
    
    $incomeSum = number_format($incomeSum, 2);      // round up to 2 d.p

    $expenseSum = number_format($expenseSum, 2);
    $expenseSum = str_replace('-', '', $expenseSum);        // remove the '-' from expenses
    
    $netTotal = number_format($netTotal, 2);

    $totalsArr = array($incomeSum, $expenseSum, $netTotal);

    return $totalsArr;
}

function trim_data($data) {
    $data = str_replace('$', '', $data);    // remove the dollar sign
    $data = str_replace(',', '', $data);    // remove ','
    $data = (float)$data;       // convert to a number

    return $data;
}
?>