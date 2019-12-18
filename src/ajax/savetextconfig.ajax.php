<?php

function validateInput($data) {
    @json_decode($data);
    return (json_last_error() === JSON_ERROR_NONE);
}

function jsonError($code) {
    switch ($code) {
        case 0: return "No Error - Valid Syntax";
        case 1: return "Maximum Stack Depth Exceeded";
        case 2: return "Invalid or Malformed JSON Syntax";
        case 3: return "Incorrect JSON Encoding";
        case 4: return "General Syntax Error";
        case 5: return "Invalid UTF-8 Characters";
        case 6: return "Recursive References";
        case 7: return "Too many NAN/INF values";
        case 8: return "Unsupported Value Type";
        case 9: return "Invalid Property Name";
        case 10: return "Invalid UTF-16 Characters";
    }
}

if (validateInput($_POST['config_input'])) {

    file_put_contents("../modules.json",$_POST['config_input']);

    echo "<div class='success'>Config was saved!</div>";
    echo "<hr><a href='./'>Back to Start</a>";
} else {
    echo "<div class='alert'>There was an error in your input: ".jsonError(json_last_error())."<br>Your changes have not been saved</div>";
    echo "<hr><a href='./?modules&astext'>Try again</a>";
}