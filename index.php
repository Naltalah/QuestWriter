<?php
require_once('./src/global.php');
?>
<html lang="en">

    <head>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Ubuntu&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Share+Tech+Mono&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="./assets/css/style.css"/>

        <title>Naltalah's Quest Writer v2</title>

    </head>

    <body>

        <div id="wrapper">
            <h1>Quest Writer</h1>
            <?php
            if (!isset($_GET['modules']) && !isset($_GET['howto']) && !isset($_GET['config']))
            {
            ?>
            <?=LoadTemplates()?>
            <form id='gen_form' autocomplete="off" aria-autocomplete="off">
            <table>
                
                <?=LoadModules();?>
                <tr>
                    <td colspan="2" style="text-align:center"><button id='generateQuest' class='fc'>Generate</button></td>
                </tr>
            
            </table>
            </form>
            <div id="output"></div>
            <?=LoadTemplateScript();?>
            <?php
            }
            elseif (!isset($_GET['howto']) && !isset($_GET['config'])) {
                if (!isset($_GET['astext'])) {
                    echo LoadConfig();
                } else {
                ?>
                <div id="config">
                <form id="config_form" autocomplete="off" aria-autocomplete="off">

                    <textarea class="big_area" name="config_input">
<?=trim(file_get_contents("./src/modules.json"));?>
                    </textarea>

                </form>
                </div>
                <button id="saveTextConfig" type="submit">Save</button>
                <?php
                }
            }
            elseif (!isset($_GET['modules']) && !isset($_GET['config'])) {
                require_once("./howto.php");
            } else {
                require_once("./config.php");
            }
            ?>
            <div id="credits">Created by Naltalah | <a href="./">Home</a> | <a href="./?modules">Modules</a> | <a href="./?howto">Documentation</a> | <a href="./?config">Config</a></div>

        </div>


        <script type="text/javascript" src="./assets/js/jquery.js"></script>
    </body>

</html>