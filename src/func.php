<?php

function ValidateJsonKey($Array,$Key,$Throw = false) {
    if (array_key_exists($Key,$Array)) {
        return $Array[$Key];
    } else {
        if ($Throw) {
            die("Error: Validating Key {$Key} didn't work out! Check your Module formatting");
        }
        return "";
    }
}

function LoadModules() {
    $String = "<button type='submit'>Generate</button>";
    $Script = "";

    $Config = json_decode(file_get_contents("./src/modules.json"),true);
        
    $String = "";

    for ($i = 0; $i < count($Config["modules"]); $i++) {

        $Path = "./modules/".$Config["modules"][$i].".json";

        $ParseResult = ParseModule($Path);

        if ($ParseResult["Status"] != "Success") {
            $String .= $ParseResult["Status"];
        } else {
            if (!empty(ValidateJsonKey($ParseResult["Content"],"header"))) {
                $String .= "<tr><td colspan='2' style='text-align:center'><h4>".$ParseResult["Content"]["header"]."</h4></td></tr>";
                continue;
            } 
            $String .= "<tr>";
            $String .= "<td>".$ParseResult["Content"]["title"].":</td><td>";
            
            // Handle Fields
            for ($o = 0; $o < count($ParseResult["Content"]["fields"]); $o++) {
                // Scan attributes and set default if they don't exist
                $Type = ValidateJsonKey($ParseResult["Content"]["fields"][$o],"type",true);
                $Default = ValidateJsonKey($ParseResult["Content"]["fields"][$o],"default");
                $Placeholder = ValidateJsonKey($ParseResult["Content"]["fields"][$o],"placeholder");
                $Required = ValidateJsonKey($ParseResult["Content"]["fields"][$o],"required");
                $Readonly = ValidateJsonKey($ParseResult["Content"]["fields"][$o],"readonly");
                $InputID = ValidateJsonKey($ParseResult["Content"]["fields"][$o],"id",true);
                $Bind = ValidateJsonKey($ParseResult["Content"]["fields"][$o],"bind");
                $Activate = ValidateJsonKey($ParseResult["Content"]["fields"][$o],"activate");
                $Small = ValidateJsonKey($ParseResult["Content"]["fields"][$o],"small");

                if ($Type == "select") {
                    $String .= '<select name="'.$InputID.'" id="'.$InputID.'" class="fc'.($Small ? " fc_smol" : "").'"';
                    if ($Required) {
                        $String .= ' required';
                    }
                    $String .= '>';
                    for ($z = 0; $z < count($ParseResult["Content"]["fields"][$o]["options"]); $z++) {
                        $Selected = ValidateJsonKey($ParseResult["Content"]["fields"][$o]["options"][$z],"selected");
                        $String .= '<option value="'.$ParseResult["Content"]["fields"][$o]["options"][$z]["value"].'"';
                        if ($Selected)
                            $String .= " selected";
                        $String .= '>'.$ParseResult["Content"]["fields"][$o]["options"][$z]["text"].'</option>';
                    }
                    $String .= '</select>';

                } elseif ($Type == "textarea") {
                    $String .= "<textarea name='".$InputID."' id='".$InputID."' class='fc' rows='5' style='resize:none;'";
                    if ($Required) {
                        $String .= ' required';
                    }
                    if (!empty($Default) && $Type != "checkbox") {
                        $String .= ' value="'.$Default.'"';
                    }
                    if (!empty($Placeholder)) {
                        $String .= ' placeholder="'.$Placeholder.'"';
                    }                    
                    $String .= "></textarea>";
                } else {
                    $String .= $Type == "checkbox" ? "<br>" : "";
                    $String .= '<input type="'.$Type.'" name="'.$InputID.'" id="'.$InputID.'" '.($Type != "checkbox" ? 'class="fc'.($Small ? " fc_smol" : "").'' : '').'"';
                    if ($Required) {
                        $String .= ' required';
                    }
                    if (!empty($Default) && $Type != "checkbox") {
                        $String .= ' value="'.$Default.'"';
                    }
                    if (!empty($Placeholder)) {
                        $String .= ' placeholder="'.$Placeholder.'"';
                    }
                    if ($Type == "checkbox" && ValidateJsonKey($ParseResult["Content"]["fields"][$o],"checked") != "")
                    {
                        $String .= 'checked';
                    }
                    if ($Readonly) {
                        $String .= " readonly='readonly'";
                    }
                    $String .= "/>";
                
                    if (!empty($Bind)) {
                        $Script .= "<script>$('#".$InputID."').keyup(function(){
                            var data = $('#".$InputID."').val();
                            if ($('#".$Bind."').attr('readonly') != 'readonly')
                                $('#".$Bind."').val(data);
                        });</script>";
                    }

                    if ($Type == "checkbox" && !empty($Activate) && count($Activate) > 0){
                        $Script .= "<script>
$('#".$InputID."').on('click',function(){
    var checked = $(this).is(':checked');
    if (checked) {
    ";
    foreach($Activate as $Index => $Field) {
        $Script .= "$('#".$Field."').removeAttr('readonly');\n\t$('#".$Field."').val('');\n\t";
    }
    $Script .= "
} else {
    ";
     foreach($Activate as $Index => $Field) {
        $Script .= "$('#".$Field."').attr('readonly','readonly');\n\t$('#".$Field."').val('');\n\t";
    }
    $Script .= "
}
});
                        </script>";
                    }
                    $String .= $Type == "checkbox" ? '<label for="'.$InputID.'">'.$Default.'</label>' : "";
                }
            }

            $String .= "</td></tr>";
        }

    }

    return $String.$Script;
}

function LoadConfig() {
    $ModuleList = scandir("./modules/");
    $LoadedModules = json_decode(file_get_contents("./src/modules.json"),true);

    $String = "<div id='config'><form id='config_form'><pre><strong>Load?\tIndex\tStatus\t   Module Name</strong>\n\n";

    $LoadedList = array();
    $UnloadedList = array();

    for ($i = 0; $i < count($ModuleList); $i++) {
        if ($ModuleList[$i] == "." || $ModuleList[$i] == "..") continue;

        $Loaded = false;
        $Index = -1;

        for ($o = 0; $o < count($LoadedModules["modules"]); $o++) {
            if ($LoadedModules["modules"][$o] == str_replace(".json","",$ModuleList[$i])) {
                $Loaded = true;
                $Index = $o;
                break;
            }
        }

        if ($Loaded) {
            $LoadedList[$Index] = $ModuleList[$i];
        } else {
            $UnloadedList[] = $ModuleList[$i];
        }
    }

    ksort($LoadedList);

    foreach ($LoadedList as $Index => $Value) {

        $String .= "<p class='listitem'>";

        $String .= "<input type='checkbox' name='".str_replace(".json","",$Value)."' checked/>\t\t  ";

        $String .= "<input type='text' name='".str_replace(".json","",$Value)."_index' value='".$Index."' class='indexing'/>\t     ";

        $String .= "<span style='color:green'>Loaded\t\t     </span>";

        $String .= str_replace(".json","",$Value);

        $String .= "</p>";
    }

    foreach ($UnloadedList as $Index => $Value) {

        $String .= "<p class='listitem'>";

        $String .= "<input type='checkbox' name='".str_replace(".json","",$Value)."'/>\t\t  ";

        $String .= "<input type='text' name='".str_replace(".json","",$Value)."_index' value='-1' class='indexing'/>\t     ";

        $String .= "<span style='color:red'>Not Loaded\t     </span>";

        $String .= str_replace(".json","",$Value);

        $String .= "</p>";
    }

    $String .= "</pre></form>";

    $String .= "</div><div style='text-align:center'><a href='./?modules&astext'>View in Editor</a></div><button type='submit' id='saveConfig'>Save</button>";

    return $String;
}

function ParseModule($File) {
    if (!file_exists($File)) {
        return array("Status" => "Error 404: {$File} not found!\n", "Content" => "");
    } 
    if (!is_readable($File)) {
        return array("Status" => "Error 402: {$File} not readable!\n", "Content" => "");
    }

    $FC = json_decode(file_get_contents($File),true);

    return array("Status" => "Success", "Content" => $FC);

}

function LoadTemplates() {
    global $Config;
    if (!$Config["templates"]) return "";
    $Templates = scandir("./templates/");
    if (count($Templates) <= 2) return "";

    $String = "<div style='text-align:center'><h4>Templates</h4><select id='templateLoader' class='fc'>
        <option value='' selected>Select a Template</option>";

    for ($i = 0; $i < count($Templates); $i++) {
        if ($Templates[$i] == "." || $Templates[$i] == "..") continue;

        $TemplateName = preg_replace("/template_(.*).json/Usi","$1",$Templates[$i]);
        $String .= "<option value='".$TemplateName."'>".ucfirst($TemplateName)."</option>";
    }

    $String .= "</select></div>";

    return $String;
}

function LoadTemplateScript() {
    global $Config;
    if (!$Config["templates"]) return "";
    $Templates = scandir("./templates/");
    if (count($Templates) <= 2) return "";

    $String = "<script>";
    $String .= "$('#templateLoader').change(function(){";
    foreach ($Templates as $Index => $File) {
        if ($File == "." || $File == "..") continue;

        $TemplateName = preg_replace("/template_(.*).json/Usi","$1",$File);
        $String .= "
if ($('#templateLoader').val() == '".$TemplateName."') {
    ";

        if (!is_readable("./templates/".$File)) {
            $String .= "<div class='alert'>Could not read template {$File}!</div>";
            continue;
        }

        $Handle = json_decode(file_get_contents("./templates/".$File),true);

        foreach ($Handle as $Field => $Value) {
            if ($Value != "checked" && $Value != "unchecked") {
                $String .= "$('#".$Field."').val('".$Value."');\n\t";
            } else {
                if ($Value == "checked") {
                    $String .= "$('#".$Field."').prop('checked',true);";
                } else {
                    $String .= "$('#".$Field."').prop('checked',false);";
                }
            }
        }

    }
    $String .= "
    }
});</script>";

    return $String;    
}

function LoadGlobalConfig($File) {
    if (!file_exists($File) || !is_readable($File)) {
        die("<div class='alert'>Config-File <i>{$File}</i> was not found or is not readable! Can not start Quest Writer!</div>");
    } 

    $CFG = array();

    $Handle = @json_decode(file_get_contents($File),true);

    if (count($Handle) == 0 || json_last_error() !== JSON_ERROR_NONE)
    return $CFG;

    foreach($Handle as $Setting => $Property) {
        $CFG[$Setting] = $Property;
    }

    return $CFG;
}