<?php
    $type = $_GET['type'];

    $ch = curl_init("http://symfony3.work/transaction/1234567890A?type=$type");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
    );

    $result = curl_exec($ch);

    echo $result;
    return;
?>
