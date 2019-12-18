<?php

$File = "../modules.json";

$Array = array("modules" => array());

if (!isset($_POST) || @count($_POST) == 0) {
    echo "<div class='alert'>No data has been sent. Config was not saved.</div>";
    die();
}

//die(var_dump($_POST));

$NewFields = array();
$UnIndexed = array();
foreach($_POST as $Field => $Status) {
    if (preg_match("/(.*)_index$/Usi",$Field)) continue;
    if ($_POST[$Field."_index"] == "-1") {
        $UnIndexed[] = array($Field,$Status);
    } else { 
        if ($Status == "off") {
            $UnIndexed[] = array($Field,$Status);
        } else {
            $NewFields[$_POST[$Field."_index"]] = array($Field,$Status);
        }
    }
}

foreach ($UnIndexed as $Field => $Status)
    $NewFields[count($NewFields)] = $Status;

//die(var_dump($NewFields));

for ($i = 0; $i < count($NewFields); $i++) {
    if ($NewFields[$i][1] == "on") {
        $Array["modules"][] = $NewFields[$i][0];
    }
}

if (!file_exists($File) || !is_writable($File)) {
    echo "<div class='alert'>The Config file could not be written by PHP. Please check your file access permissions.</div>";
} else {
    file_put_contents("../modules.json",json_encode($Array));
    echo "<div class='success'>Config was saved!</div>";
}

echo "<hr><a href='./'>Back to Start</a>";

?>