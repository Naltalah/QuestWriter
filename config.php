<div id="config">
<div style='text-align:center'><h4>Quest Writer Config</h4></div>
<form id="globalConfig">
<table>
    <tr>
        <td>Enable Templates:</td>
        <td>
            <select name="templates" class="fc">
                <option value="true"<?=($Config["templates"] == true ? " selected" : "")?>>Yes</option>
                <option value="false"<?=($Config["templates"] == false ? " selected" : "")?>>No</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>Output Quest to Files:</td>
        <td>
            <select name="file_output" class="fc">
                <option value="true"<?=($Config["file_output"] == true ? " selected" : "")?>>Yes</option>
                <option value="false"<?=($Config["file_output"] == false ? " selected" : "")?>>No</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>Output File Location:</td>
        <td><input name="file_path" value="<?=$Config["file_path"]?>" class="fc" /></td>
    </tr>
</table>
</form>
</div>
<button id="saveGlobalConfig">Save</button>