<?php

foreach($_POST as $Index => $Value) {
    if ($Value == "true") {
        $_POST[$Index] = true;
    }
    if ($Value == "false") {
        $_POST[$Index] = false;
    }
}

file_put_contents("../config.json",json_encode($_POST));

echo "<div class='success'>Config was saved!</div>";

?>