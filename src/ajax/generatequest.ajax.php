<?php

require_once('../func.php');

$Config = LoadGlobalConfig("../config.json");

/* Load IDs */
$Defines = json_decode(file_get_contents("../ids.json"),true);

/*
Format:
    Quest-ID
    Quest-Title
    Quest-Settings
    Quest-Dialogues
    State 0
    State 14
*/
$ID = "";
$Title ="";
$Settings = "";
$Dialogues = "";
$StateZero = "";
$StateEnd = "";
$Output = "%s 
{
    %s

    setting
    {%s
    }
    %s

    state 0 
    {%s
    }
    state 14
    {%s
    }
}
";

$Output_propQuestTxt = "";
$Output_defineQuest = "";


// Get all loaded modules
$Modules = json_decode(file_get_contents("../modules.json"),true)["modules"];

// Then find proper handle (Same ID)
for ($i = 0; $i < count($Modules); $i++) {
    $Args = array();
    $Path = "../../modules/".$Modules[$i].".json";
    if (!file_exists($Path) || !is_readable($Path)) {
        die("<div class='alert'>Module {$Module[$i]} could not be read!</div>");
    }
    $Module = json_decode(file_get_contents($Path),true);
    if (isset($Module["header"])) continue;
    $Format = $Module["format"];
    $Category = $Module["category"];
    $IDs = $Module["handle"];

    // If none is found, throw error
    if (count($IDs) == 0)
        die("No handles found for module: ".$Module[$i]);

    $Skip = false;

    //die(print_r($_POST));

    for ($o = 0; $o < count($IDs); $o++) {
        if (!array_key_exists($IDs[$o],$_POST) && count($IDs) > 1) {
            $Args[] = "";
            continue;
        }
        if (empty($_POST[$IDs[$o]])) {
            $Skip = true;
            break;
        }
        //else
        if ($_POST[$IDs[$o]] == "on") {
            for ($t = 0; $t < count($Module["fields"]); $t++) {
                if ($Module["fields"][$t]["id"] == $IDs[$o]) {
                    $Args[] = $Module["fields"][$t]["on"];
                    break;
                }
            }
        } elseif ($_POST[$IDs[$o]] == "off") {
            for ($t = 0; $t < count($Module["fields"]); $t++) {
                if ($Module["fields"][$t]["id"] == $IDs[$o]) {
                    $Args[] = $Module["fields"][$t]["off"];
                    break;
                }
            }
        } else {
            for ($t = 0; $t < count($Module["fields"]); $t++) {
                if ($Module["fields"][$t]["id"] == $IDs[$o]) {
                    if (array_key_exists("convert_text",$Module["fields"][$t]) && $Module["fields"][$t]["convert_text"] == true)
                    {
                        $Defines["propquest_txt"] += 1;
                        $Output_propQuestTxt .= sprintf("IDS_PROPQUEST_TXT_%06d\t%s\n",$Defines["propquest_txt"],$_POST[$IDs[$o]]);
                        $Args[] = sprintf("IDS_PROPQUEST_TXT_%06d",$Defines["propquest_txt"]);
                    } else {
                        $Args[] = $_POST[$IDs[$o]];
                    }
                    break;
                } 
            }
        }
    }

    if ($Skip) continue;

    // Generate output depending on category (title, settings, dialog, stage)
    switch($Category) {
        case "id":
            {
                $ID = vsprintf($Format,$Args);
            }
        break;
        case "title":
            {
                $Title = vsprintf($Format,$Args);
            }
        break;
        case "setting":
        case "settings":
            {
                $Settings .= "\n\t".vsprintf($Format,$Args);
            }
        break;
        case "dialogue":
            {
                $Dialogues .= "\n    ".vsprintf($Format,$Args);
            }
        break;
        case "state0":
            {
                $StateZero .= "\n\t".vsprintf($Format,$Args);
            }
        break;
        case "state14":
            {
                $StateEnd .= "\n\t".vsprintf($Format,$Args);
            }
        break;
    } 

}
// Add defineQuest Output
$Defines["definequest"] += 1;
$Output_defineQuest .= "#define ".$ID."\t".$Defines["definequest"]."\n";

$Final = sprintf($Output,$ID,$Title,$Settings,$Dialogues,$StateZero,$StateEnd);

if ($Config["file_output"]) {
    file_put_contents($Config["file_path"]."propQuest.inc",$Final,FILE_APPEND);
    file_put_contents($Config["file_path"]."propQuest.txt.txt",$Output_propQuestTxt,FILE_APPEND);
    file_put_contents($Config["file_path"]."defineQuest.h",$Output_defineQuest,FILE_APPEND);

    echo "<div class='success'>The quest was saved to the output files.</div>";
} else {
    echo "<pre><strong>propQuest.inc</strong>\n".$Final."<hr><strong>propQuest.txt.txt</strong>\n".$Output_propQuestTxt."<hr><strong>defineQuest.h</strong>\n".$Output_defineQuest."</pre>";
}
// Save new IDs
file_put_contents("../ids.json",json_encode($Defines));

?>