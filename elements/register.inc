<?php
/**
 * register.inc
 * Modal block for the registration of new plugins
 * Author: Federico Mestrone
 * Created: 15/12/2012 12:39
 * Copyright: 2012, Moodsdesign Ltd
 */
?>
<div id="registerModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="registerModalLabel"><?php echo empty($PLUGIN_ID) ? 'Register' : "Profile for $PLUGIN_ID"; ?></h3>
    </div>
    <div class="modal-body">
        <div class="alert alert-success" id="serverRegisterSuccessAlert">
            <strong>All good!</strong> <?php echo empty($PLUGIN_ID) ? 'Your new Plugin ID was registered successfully' : 'Your Plugin profile was saved successfully'; ?>.
        </div>
        <div class="alert" id="serverRegisterErrorAlert">
            <strong>Warning!</strong> An error occurred on the server, please try again later.
        </div>
        <div class="alert alert-error" id="formRegisterErrorAlert">
            <strong>Error!</strong> <span id="formRegisterErrorMessage"></span>
        </div>
        <div class="progress progress-striped active" id="formRegisterProgress">
            <div class="bar" style="width: 100%;"></div>
        </div>
        <form id="profileForm" action="register.php" method="post" class="form-horizontal">
            <div class="control-group">
                <label class="control-label" for="pluginid">Plugin ID
                    <span rel="tooltip" data-placement="bottom" title="The Plugin ID is the name of the folder where your plugin is installed under Elgg. It is also used as the username to sign in to the Versions Server.">
                        <i class="icon-question-sign"></i>
                    </span>
                </label>
                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-folder-open"></i></span>
                        <input type="text" name="pluginid" value="<?php echo $PLUGIN_ID; ?>" id="pluginid" placeholder="Plugin ID" <?php if ( !empty($PLUGIN_ID) ) echo 'readonly="readonly"'; ?>>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="password">Password
                    <span rel="tooltip" data-placement="bottom" title="The password you want to use together with the Plugin ID to sign into the Versions Server.">
                        <i class="icon-question-sign"></i>
                    </span>
                </label>
                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-eye-close"></i></span>
                        <input type="password" name="password" value="" id="password" placeholder="Password">
                    </div>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="password2">Confirm Password</label>
                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-eye-close"></i></span>
                        <input type="password" name="password2" value="" id="password2" placeholder="Confirm Password">
                        <?php if ( !empty($PLUGIN_ID) ) { ?>
                        <span class="help-block">Leave both password fields blank to leave password unchanged</span>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="email">Email Address
                    <span rel="tooltip" data-placement="bottom" title="The email address we can use to confirm that you are the genuine author of the plugin.">
                        <i class="icon-question-sign"></i>
                    </span>
                </label>
                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-envelope"></i></span>
                        <input type="text" name="email" value="<?php echo $PLUGIN['plugin_email']; ?>" id="email" placeholder="Email Address">
                    </div>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="url">Plugin URL
                    <span rel="tooltip" data-placement="top" title="The URL of the homepage of your plugin. It is displayed in the list of registered plugins.">
                        <i class="icon-question-sign"></i>
                    </span>
                </label>
                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-globe"></i></span>
                        <input type="text" name="url" value="<?php echo $PLUGIN['plugin_url']; ?>" id="url" placeholder="Plugin URL">
                    </div>
                </div>
            </div>
            <?php // focus on first field ?>
        </form>
    </div>
    <div class="modal-footer">
        <button id="profileCanc" class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
        <button id="profileSave" class="btn btn-primary">Save</button>
    </div>
</div>
