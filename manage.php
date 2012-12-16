<?php
/**
 * index.php
 * Author: Federico Mestrone
 * Created: 14/12/2012 13:51
 * Copyright: 2012, Moodsdesign Ltd
 */
$CUR_PAGE = 'manage';

unset($PLUGIN);
unset($PLUGIN_ID);
unset($error_message);
unset($success);

session_start();

if ( empty($_SESSION['PluginID']) ) {
    header('Location: index.php');
    exit;
}

$PLUGIN_ID = $_SESSION['PluginID'];

$filename = "data/$PLUGIN_ID";
if ( is_readable($filename) ) {
    $raw = file_get_contents($filename);
    $PLUGIN = unserialize($raw);
    if ( empty($PLUGIN) ) {
        $_SESSION['PluginErr'] = 'invalid';
        header('Location: index.php');
        exit;
    }
}

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    /*
     * Handle edit attempts
     */
    $pluginid = $_POST['pluginid'];
    $version = $_POST['version'];
    $guid = $_POST['guid'];
    $notes = $_POST['notes'];
    if ( $PLUGIN_ID != $pluginid ) {
        $error_message = '<li>Your request is inconsistent with the current session</li>';
    } else if ( !$pluginid || !$version || !$guid ) {
        $error_message = '<li>You must provide both your Plugin Version and its Download GUID on the Elgg community site</li>';
    } else {
        $PLUGIN['plugin_new_version'] = $version;
        $PLUGIN['plugin_guid'] = $guid;
        $PLUGIN['plugin_timestamp'] = time();
        if ( !empty($notes) ) $PLUGIN['release_notes'] = $notes;
        $raw = serialize($PLUGIN);
        if ( file_put_contents("data/$PLUGIN_ID", $raw) ) {
            $success = true;
        } else {
            $error_message = '<li>Could not save your version information</li>';
        }
    }
}

/*
 * Handle end user requests from a web browser
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
<!-- Html Head -->
<?php require('elements/head.inc'); ?>
<!--/ Html Head -->
</head>
<body>

<!-- Navigation Bar -->
<?php require('elements/navbar.inc'); ?>
<!--/ Navigation Bar -->

<div id="wrap">

    <div class="container">
        <!-- Page Content -->

        <div id="manage-form">
            <form method="post" class="form-manage form-horizontal">
                <h2 class="form-manage-heading">Version info</h2>
                <div class="control-group">
                    <label class="control-label" for="pluginid">Plugin ID</label>
                    <div class="controls">
                        <div class="input-prepend">
                            <span class="add-on"><i class="icon-folder-open"></i></span>
                            <input type="text" name="pluginid" value="<?php echo $PLUGIN_ID; ?>" id="pluginid" placeholder="Plugin ID" readonly="readonly">
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="version">Plugin Version</label>
                    <div class="controls">
                        <div class="input-prepend">
                            <span class="add-on"><i class="icon-tags"></i></span>
                            <input type="text" name="version" value="<?php echo $PLUGIN['plugin_new_version']; ?>" id="version" placeholder="Plugin Version">
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="guid">Elgg Download GUID</label>
                    <div class="controls">
                        <div class="input-prepend">
                            <span class="add-on"><i class="icon-download-alt"></i></span>
                            <input type="text" name="guid" value="<?php echo $PLUGIN['plugin_guid']; ?>" id="guid" placeholder="Elgg Download GUID">
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="notes">Release Notes</label>
                    <div class="controls">
                        <div class="input-prepend">
                            <span class="add-on"><i class="icon-edit"></i></span>
                            <textarea name="notes" id="notes" placeholder="Release Notes"><?php echo $PLUGIN['release_notes']; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <button class="btn btn-large btn-primary" type="submit">&nbsp;Save&nbsp;</button>
                        <a class="btn btn-large btn-info" href="index.php" role="button">Sign Out</a>
                        <a class="btn btn-large btn-info" href="#helpModal" role="button" data-toggle="modal">&nbsp;Help&nbsp;</a>
                    </div>
                </div>
                <?php // focus on first field ?>
            </form>
        </div>

        <?php if ( $success ) { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <h4>All good</h4>
                Your version information has been saved successfully!
            </div>
        <?php } ?>

        <?php if ( $error_message ) { ?>
        <div class="alert alert-error">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <h4>An error has occurred</h4>
            <ul>
            <?php echo $error_message; ?>
            </ul>
        </div>
        <?php } ?>

        <!--/ Page Content -->
    </div>

    <div id="push"></div>

</div>

<!-- About Modal -->
<?php require('elements/about.inc'); ?>
<!--/ About Modal -->

<!-- Help Modal -->
<?php require('elements/help.inc'); ?>
<!--/ Help Modal -->

<!-- Register Modal -->
<?php require('elements/register.inc'); ?>
<!--/ Register Modal -->

<!-- Page Footer -->
<?php require('elements/footer.inc'); ?>
<!--/ Page Footer -->

</body>
</html>
