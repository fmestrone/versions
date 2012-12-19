<?php
/**
 * help.inc
 * Modal block with some help information about signing in
 * Author: Federico Mestrone
 * Created: 15/12/2012 12:40
 * Copyright: 2012, Moodsdesign Ltd
 */
?>
<div id="helpModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="helpModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="helpModalLabel">Sign-in Help</h3>
    </div>
    <div class="modal-body">
        <p>The Versions Server allows you to manage the latest version for your Elgg plugins.</p>
	    <p>In order to access the functionality of the server, you need to sign in. For this, you provide the Plugin ID and a password.</p>
	    <p>The Plugin ID is the name of the folder that your plugin is installed in under the <i>mod</i> folder of your Elgg installation.</p>
	    <p>The password was specified by yourself when you registered the plugin with the server.</p>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    </div>
</div>
