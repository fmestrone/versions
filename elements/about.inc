<?php
/**
 * about.inc
 * Modal block with some information about the Versions Server and the Version Check plugin for Elgg
 * Author: Federico Mestrone
 * Created: 15/12/2012 12:40
 * Copyright: 2012, Moodsdesign Ltd
 */
?>
<div id="aboutModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="aboutModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="aboutModalLabel">About…</h3>
    </div>
    <div class="modal-body">
        <p>The Versions Server is used to keep track of the latest version of registered Elgg plugins.</p>
	    <p>It allows developers to update version information when a new release is published.</p>
	    <p>The information provided is then used in two ways:</p>
	    <ul>
		    <li>By the Version Check plugin for Elgg to notify administrators that a new version has been released with new features and updates</li>
		    <li>To offer a single link that always downloads the latest version of the application</li>
	    </ul>
	    <p>For more details about all of this, check out the <a href="https://moodsdesign.atlassian.net/wiki/display/ELGGVERCHK" target="_blank">Version Check homepage</a>.</p>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    </div>
</div>
