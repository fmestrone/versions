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
	    <p>It records the version number, used by the Version Check plugin to notify admins of any updates and new releases.</p>
	    <p>It also requires the Elgg Download GUID from the Elgg community site. This is the last part of the download URL for the version in question. It is a number, and it is needed to redirect downloads of your plugins handled from this site to the very latest version.</p>
	    <p>Finally, a very short description of the features of the new version is required and is provided to the admins that use the Version Check plugin.</p>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    </div>
</div>
