<h3 id="top">Documentation</h3>
<p>This is the documentation for this quest writer.</p>

<p><strong>Table of Contents</strong><br>
<ul>
    <li><a href='#general'>General Usage</a></li>
    <li><a href="#fields">Input Fields</a>
        <ul class="disc">
            <li><a href="#input">Text Fields</a></li>
            <li><a href="#checkbox">Checkboxes</a></li>
            <li><a href="#select">Dropdown Selection</a></li>
            <li><a href="#textarea">Textareas</a></li>
        </ul>
    </li>
    <li><a href="#modules">Modules</a></li>
    <li><a href="#templates">Templates</a></li>
    <li><a href="#addmodules">Add new Modules</a></li>
</ul>
</p>

<h3 id="general">General Usage</h3>

<p><strong>Overview</strong><br>
Every module that is loaded will output a control of the specified type and will be handled once you press "Generate".
<br>
The Quest Writer will generate everything you need: the quest-settings, the quest-texts including text-ids (if specified in the module settings) and the define.
<br>
You can then copy everything into your resource files.
</p>

<p><strong>Modules</strong><br>
You can decide which modules to load by clicking "Modules" in the footer.
<br>
You can also specify in which order the modules should be loaded.
<br>
Modules that are not loaded will not appear as controls in the generator.
</p>

<p><strong>Configuration</strong>
<br>
When clicking "Config" in the footer, you can open the configuration panel.
<br>
You can find the following settings here:
<ul calss="disc">
    <li><strong>Enable Templates</strong> - Decides whether template files are loaded and are applicable</li>
    <li><strong>Output Quest to Files</strong> - Decides if the quest generated will be shown on the screen or written to a file</li>
    <li><strong>Output File Location</strong> - If you choose to output generated quests to a file, the Quest Writer will do it in this directory.
    <br><i>Note:</i> The generated quest will be <strong>appended</strong> to the bottom of the file, nothing will be overwritten.</li>
</ul>
</p>

<h3 id="fields">Input Fields</h3>

<p><strong>Types of Input Fields</strong>
<br>
There are currently 4 types of input fields supported:
<ul class="disc">
    <li><a href="#input">input</a> - A normal textfield</li>
    <li><a href="#checkbox">checkbox</a> - A checkbox that supports "on" and "off" values</li>
    <li><a href="#select">select</a> - A dropdown box that holds multiple values</li>
    <li><a href="#textarea">textarea</a> - An input field with multiple rows, mostly used for bigger texts</li>
</ul>
</p>

<p id="input"><strong>Input Fields</strong>
<br>
Syntax of an input field
<pre>
{
    "id" : "quest_title",
    "type" : "input",
    "required" : true,
    "default" : "",
    "placeholder" : "Quest Title",
    "convert_text" : true,
    "bind" : "field_id",
    "readonly" : true,
    "small" : true
}    
</pre>
<ul class="disc">
    <li><strong>id</strong> - The identifier used in the <strong>handle</strong> section of a module. Make sure this is never duplicated amongst all modules</li>
    <li><strong>type</strong> - Obviously this is input here</li>
    <li><strong>required</strong> - This is an <i>optional</i> attribute, if you don't use it, an input in this text-field will not be required for quest generation</li>
    <li><strong>default</strong> - This is an <i>optional</i> attribute. If this is set, the text-field will always appear with an already entered value</li>
    <li><strong>placeholder</strong> - This is an <i>optional</i> attribute. If this is set, the text-field will appear with a gray text telling you what to enter in the field.</li>
    <li><strong>convert_text</strong> - This is an <i>optional</i> attribute. If this is set to true, the Quest Writer will use a Text-ID instead of the text itself for the module. (Text-ID meaning IDS_PROPQUEST_TXT_NUMBER Text)</li>
    <li><strong>bind</strong> - This is an <i>optional</i> attribute. If you specify another field's id here, the value will always be the updated to the same as in this field.</li>
    <li><strong>readonly</strong> - This is an <i>optional</i> attribute. If this is set to true, you can't change the value of this field. Useful for default values in templates or when binding the value.</li>
    <li><strong>small</strong> - This is an <i>optional</i> attribute. If this is set to true, the input field will take up a smaller amount of space and 2 small fields fit into one row.</li>
</ul>
</p>

<p id="checkbox"><strong>Checkboxes</strong>
<br>
Syntax of a checkbox
<pre>
{
    "id" : "quest_title_tag",
    "type" : "checkbox",
    "default" : "LUL",
    "checked" : true,
    "on" : 2,
    "off" : 0,
    "activate" : ["field_id","field_id2"]
}
</pre>
<ul class="disc">
    <li><strong>id</strong> - The identifier used in the <strong>handle</strong> section of a module. Make sure this is never duplicated amongst all modules</li>
    <li><strong>type</strong> - Obviously this is checkbox here</li>
    <li><strong>default</strong> - The text that will be shown next to the checkbox, explaining what it's for</li>
    <li><strong>checked</strong> - This is an <i>optional</i> attribute. If this is set to true, the checkbox will be checked by default</li>
    <li><strong>on</strong> - This is the value that is used during generation if the checkbox was <i>checked</i></li>
    <li><strong>off</strong> - This is the value that is used during generation if the checkbox was <i>unchecked</i></li>
    <li><strong>activate</strong>- This is an <i>optional</i> attribute. If you specify other field-ids here, those fields will toggle their readonly mode when interacting with this checkbox.</li>
</ul>
</p>

<p id="select">
<strong>Select Menus</strong>
<br>
Syntax of a select
<pre>
{
    "id" : "test_select",
    "type" : "select",
    "options" : [
        {
            "value" : 0,
            "text" : "Zero"
        },
        {
            "value" : 1,
            "text" : "One",
            "selected" : true
        }
    ]
}
</pre>
<ul class="disc">
    <li><strong>id</strong> - The identifier used in the <strong>handle</strong> section of a module. Make sure this is never duplicated amongst all modules</li>
    <li><strong>type</strong> - Obviously this is select here</li>
    <li><strong>options</strong> - This is an array object of all possible options that are available. Each option holds 2 attributes
        <ul class="disc">
            <li><strong>value</strong> - The value that will be used for generation</li>
            <li><strong>text</strong> - The text that will appear in the dropdown for this value</li>
            <li><strong>selected</strong> - This is an <i>optional</i> attribute. If this is set to true, this option will be selected by default. Make sure to not use this on more than one option</li>
        </ul>
    </li>
</ul>
</p>

<p id="textarea">
<strong>Textareas</strong>
<br>
Sytnax of a textarea
<pre>
{
    "id" : "quest_begin_text",
    "type" : "textarea",
    "required" : true,
    "default" : "",
    "placeholder" : "Test when Accepting",
    "convert_text" : true
}
</pre>
The textarea uses the same attributes as a <a href="#input">regular Input field</a>, only the type is different.
</p>

<h3 id="sprintf">sprintf() Basics</h3>

<p><strong>The Basics</strong>
<br>You will most likely be using <i>%s</i> for text and <i>%d</i> for numbers.
<br>Putting a %s anywhere will copy any text supplied, a %d will copy a number (no leading zeros). If you want a certain amount of leading zeros, e.g. 000420, you have to speficy the total length of the number like so: <i>%06d</i>. This will put 3 leading zeros before a 3-digit number, 4 on a 2-digit number, etc.
<br>If you want to use floating point numbers, you can use <i>%.1f</i>, where the <i>.1</i> specifies that 1 floating point number will be used.
<br>Example: 234.678 with %.1f would result in 234.6 (or 234.7 depending on the PHP Version)
</p>

<h3 id="modules">Modules</h3>

<p><strong>Explanation</strong>
<br>
Every module is stored in the <i>/modules/</i> directory as a .json File. 
<br>
I chose to use this format as this is the easiest humanly readable format and everything is almost self-explanatory.
</p>
<p><strong>Syntax</strong>
<br>
As an example, here's the syntax of the Quest-Title Module.
<pre>
{
    "title" : "Quest Name",
    "format" : "SetTitle(%d,%s);",
    "category" : "title",
    "handle" : ["quest_title_tag","quest_title"],
    "fields" : [
        {
            "id" : "quest_title",
            "type" : "input",
            "required" : true,
            "default" : "",
            "placeholder" : "Quest Title",
            "convert_text" : true
        },
        {
            "id" : "quest_title_tag",
            "type" : "checkbox",
            "default" : "LUL",
            "on" : 2,
            "off" : 0
        }
    ]
}
</pre>
Let's go over the attributes, shall we?
<br>
<ul class="disc">
    <li><strong>title</strong> - Specifies the text left of the input field</li>
    <li><strong>format</strong> - This is what is appearing in the corresponding section of the propQuest.inc output. If you are unsure how to use this, consider checking the <a href="https://www.php.net/manual/en/function.sprintf.php" target="_blank">PHP Manual</a> or the <a href="#sprintf">Documentation Section</a></li>
    <li><strong>category</strong> - This specifies where the module places its output. There are currently 6 cateogies:
        <ul class="disc">
            <li><strong>id</strong> - Will be used as the Quest-ID</li>
            <li><strong>title</strong> - Will be used as the Quest-Title (The name of the quest)</li>        
            <li><strong>setting</strong> - A general setting like SetBeginCond</li>
            <li><strong>dialogue</strong> - One of the dialogues for the quest</li>
            <li><strong>state0</strong> - This is used for state 0 texts of a quest (Quest is incomplete), that will show up in the quest log</li>
            <li><strong>state14</strong> - This is used for state 14 texts of a quest (Quest is complete), that will show up in the quest log</li>
        </ul>
    </li>
    <li><strong>handle</strong> - The order in which the fields will be processed in the format-String</li>
    <li><strong>fields</strong> - This is an array object of all fields that will be shown. Currently there are 4 types of fields supported, all of which have their own syntax. You can read more about this in the <a href="#fields">Input Field</a> section.</li>
</ul>
</p>

<h3 id="templates">Templates</h3>
<p><strong>What are templates?</strong>
<br>
Templates are powerful tools to fill the Quest Writer with some default values.
<br>To use a template, just select a template from the dropdown menu at the top of the form.
</p>
<p><strong>Modifying Templates</strong>
<br>
All templates are located in the <i>/templates/</i> directory. The Basic template is just an example. Here's the content:
<pre>
{
    "quest_id":"QUEST_",
    "quest_title":"Daily: ",
    "endreward_item_01_isbound":"checked"
}
</pre>
<strong>What does that stand for?</strong>
<br>
In a template file, the common syntax is "field_id":"Value". If you specify a field in a module, you can use its id to give it a default value when loading the template.
<br>
There is something special for checkboxes: If you put "checked" as the value, those checkboxes will be checked.
</p>

<p><strong>Adding Templates</strong>
<br>
To create a template file, just create a new .json file in the <i>/templates/</i> directory.
<br>
Make sure the filename starts with <i>template_</i>. So for example let's say you want to make a Christmas Quest Template. You could name the file something along the lines of <i>template_Christmas_Quest.json</i> and put the following in:
<pre>
{
    "quest_id":"QUEST_CHRISTMAS_",
    "quest_name":"Christmas: ",
    "quest_repeatsetting":"checked"
}
</pre>
That would automatically setup quest id, quest title and the make the quest repeatable. Less to worry about!</p>

<h3 id="addmodules">Add new Modules</h3>

<p><strong>Step by Step Guide for Modules</strong>
<br>
<i>Step 1: Create the File</i>
<br>Create a file in the /modules/ directory and name it accordingly to what you want it to do. In this example, I will use the <u>EndRewardItem</u> attribute of a quest.
<br>I'm gonna name the file <u>endreward_item_01.json</u>
</p>
<p><i>Step 2: Select a title & id</i>
<br>In the file <u>endreward_item_01.json</u> you now have to setup the basic syntax.
<pre>
{
    "title" : "Reward Item 1",
    "category" : "settings",
    "format" : "SetEndRewardItem(%d, 0, %d, %s, %d%s);",
    "fields" : [],
    "handle" : []
}
</pre>
<strong>Explanation</strong>
<br>
Right now, this module does nothing, but we have specified some stuff.
<ul class="disc">
    <li><strong>title</strong> - In the form, "Reward Item 1" will now show up. </li>
    <li><img src="./assets/img/docs/module_step1.png" alt="Step 1"/></li>
    <li><strong>category</strong> - I made this as a setting, because it has nothing to do with the other categories like id, title or dialogue</li>
    <li><strong>format</strong> - Now this is interesting. I specified that the generator should output <i>SetEndRewardItem(... Parameters ...)</i>, the parameters being:
        <ul class="disc">
            <li>%d - a number</li>
            <li>0 - default value</li>
            <li>%d - a number</li>
            <li>%s - some text</li>
            <li>%d - a number</li>
            <li>%s - some text</li>
        </ul>
        What these numbers stand for depend on your version of the flyff source code.
    </li>
</ul>
Fields & Handle are empty right now and will be taken care of in the next step.
</p>

<p><i>Step 3: Adding the inputs</i>
<br>The first question should be: How many fields do we need?
<br>Since we specified 4 parameters for the format, we have to use 4 input fields.
<br>To give you some insight, what parameters we need: What sex the reward is for, what job the reward is for, which item is the reward and how many items should be rewarded. Also there is a weird %s which does not have a comma or space before it. This will be used to decide if the item will be an event reward or not.
<br><br>
Time to add the input fields. For the sex of the item, we want a dropdown selection. If you need a refreshment on how the syntax is, check out <a href="#select">here</a>
<pre>
    "fields" : [
        {
            "id" : "endreward_item_01_sex",
            "type" : "select",
            "options" : [
                {
                    "value" : -1,
                    "text" : "Both Sexes",
                    "selected" : true
                },
                {
                    "value" : 0,
                    "text" : "Male"
                },
                {
                    "value" : 1,
                    "text" : "Female"
                }
            ]
        }
    ]
</pre>
Doing only this will result in this:
<br>
<img src="./assets/img/docs/module_step3_1.png" alt="Step 3.1" height="106" width="403"/>
<br>
Next, we are going to add the field for the jobs. To keep it short, I will only put up "All Jobs" in the selection, you can of course add more.
<pre>
    "fields" : [
        {
            "id" : "endreward_item_01_sex",
            "type" : "select",
            "options" : [
                {
                    "value" : -1,
                    "text" : "Both Sexes",
                    "selected" : true
                },
                {
                    "value" : 0,
                    "text" : "Male"
                },
                {
                    "value" : 1,
                    "text" : "Female"
                }
            ]
        },
        {
            "id" : "endreward_item_01_job",
            "type" : "select",
            "options" : [
                {
                    "value" : -1,
                    "text" : "All Jobs",
                    "selected" : true
                }
            ]
        }
    ]
</pre>
The result will look like this:
<br>
<img src="./assets/img/docs/module_step3_2.png" alt="Step 3.2" width="397"/>
<br>
After that, we will add the input fields for item-id and amount.
<pre>
    "fields" : [
        {
            "id" : "endreward_item_01_sex",
            "type" : "select",
            "options" : [
                {
                    "value" : -1,
                    "text" : "Both Sexes",
                    "selected" : true
                },
                {
                    "value" : 0,
                    "text" : "Male"
                },
                {
                    "value" : 1,
                    "text" : "Female"
                }
            ]
        },
        {
            "id" : "endreward_item_01_job",
            "type" : "select",
            "options" : [
                {
                    "value" : -1,
                    "text" : "All Jobs",
                    "selected" : true
                }
            ]
        },
        {
            "id" : "endreward_item_01_itemid",
            "type" : "input",
            "placeholder" : "Item-ID"
        },
        {
            "id" : "endreward_item_01_amount",
            "type" : "input",
            "placeholder" : "Amount"
        }
    ]
</pre>
Result:<br>
<img src="./assets/img/docs/module_step3_3.png" alt="Step 3.2" width="392"/>
<br>
Last but not least, let's add the checkbox for the Event Reward.

<pre>
    "fields" : [
        {
            "id" : "endreward_item_01_sex",
            "type" : "select",
            "options" : [
                {
                    "value" : -1,
                    "text" : "Both Sexes",
                    "selected" : true
                },
                {
                    "value" : 0,
                    "text" : "Male"
                },
                {
                    "value" : 1,
                    "text" : "Female"
                }
            ]
        },
        {
            "id" : "endreward_item_01_job",
            "type" : "select",
            "options" : [
                {
                    "value" : -1,
                    "text" : "All Jobs",
                    "selected" : true
                }
            ]
        },
        {
            "id" : "endreward_item_01_itemid",
            "type" : "input",
            "placeholder" : "Item-ID"
        },
        {
            "id" : "endreward_item_01_amount",
            "type" : "input",
            "placeholder" : "Amount"
        },
        {
            "id" : "endreward_item_01_isbound",
            "type" : "checkbox",
            "default" : "Is Bound?",
            "on" : " ,2",
            "off" : ""
        }
    ]
</pre>
Result:<br>
<img src="./assets/img/docs/module_step3_4.png" alt="Step 3.2" width="398"/>

<strong>Notice something?</strong>
<br>
For the on-value, I used the missing whitespace and comma, since we only want to generate that value if the item actually is bound. 
<br>
If we don't want it to be bound, we simply do nothing.
</p>

<p><i>Step 4: Adding the Handles</i>
<br>
Now we have to setup the handle in the correct order. Every element has an id we now have to put there.
<pre>
    "handle" : [
        "endreward_item_01_sex",
        "endreward_item_01_job",
        "endreward_item_01_itemid",
        "endreward_item_01_amount",
        "endreward_item_01_isbound"
    ]
</pre>
Now we have added the handles and can test the module. I want to give an Event Reward Wooden Sword as a reward.
<img src="./assets/img/docs/module_step4_1.png" alt="Step 4.1" width="401"/>
<br>
If I now press "Generate", the following will be generated:
<br>
<img src="./assets/img/docs/module_step4_2.png" alt="Step 4.2" width="537"/>
</p>

<p><i>Congrats!</i><br>
You now know how to add new modules!
</p>
<hr>
<a href="#top">Back to top</a>