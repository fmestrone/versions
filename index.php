<?php
/**
 * index.php
 * Author: Federico Mestrone
 * Created: 14/12/2012 13:51
 * Copyright: 2012, Moodsdesign Ltd
 */
$CUR_PAGE = 'signin';

unset($PLUGIN);
unset($PLUGIN_ID);
unset($error_message);
unset($warn_message);

session_start();

if ( $_SESSION['PluginErr'] == 'invalid' ) {
    $warn_message = 'Invalid Plugin ID for this session';
} else if ( !empty($_SESSION['PluginID']) ) {
    $warn_message = 'You have been logged out';
}

session_unset();
session_destroy();

if ( ($pluginid = $_SERVER['QUERY_STRING']) ) {
    /*
     * Handle application requests from the Version Checker plugin
     */
    $results = array('status' => 0);
    $filename = "data/$pluginid";
    if ( is_readable($filename) ) {
        $raw = file_get_contents($filename);
        if ( ($data = unserialize($raw)) ) {
            $results['status'] = 1;
            unset($data['password']);
            $data['plugin_id'] = $pluginid;
            $results['versions'] = array(
                $pluginid => $data
            );
        }
    }
    header('Content-type: application/json');
    echo json_encode($results);
    die;
} else if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    /*
     * Handle sign-in attempts
     */
    $pluginid = $_POST['pluginid'];
    $password = $_POST['password'];
    if ( !$pluginid || !$password ) {
        $error_message = '<li>You must provide both your Plugin ID and a password for it</li>';
    } else if ( $pluginid[0] == '.' ) {
	    $warn_message = 'Plugin IDs cannot start with a dot.';
    } else if ( is_readable("data/.$pluginid") ) {
	    $warn_message = 'This Plugin ID exists but has not been activated yet.';
    } else {
        $filename = "data/$pluginid";
        if ( is_readable($filename) ) {
            $raw = file_get_contents($filename);
            if ( ($data = unserialize($raw)) ) {
                if ( $data['password'] == md5($password) ) {
                    session_start();
                    $_SESSION['PluginID'] = $pluginid;
                    header('Location: manage.php');
                } else {
                    $error_message = '<li>Your Plugin ID and password are not valid</li>';
                }
            } else {
                $error_message = '<li>The Plugin ID and password you provided are not valid</li>';
            }
        } else {
            $error_message = '<li>Invalid Plugin ID or password</li>';
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

        <div id="signin-form">
            <form class="form-signin" method="post">
                <h2 class="form-signin-heading">Please sign in</h2>
                <input type="text" class="input-block-level" placeholder="Plugin ID" name="pluginid">
                <input type="password" class="input-block-level" placeholder="Password" name="password">
                <button class="btn btn-large btn-primary" type="submit">Sign in</button>
                <a class="btn btn-large btn-info" href="#registerModal" role="button" data-toggle="modal">Register</a>
                <a class="btn btn-large btn-info" href="#helpModal" role="button" data-toggle="modal">&nbsp;Help&nbsp;</a>
            </form>
        </div>

        <?php if ( $error_message ) { ?>
        <div class="alert alert-error">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <h4>An error has occurred</h4>
            <ul>
            <?php echo $error_message; ?>
            </ul>
        </div>
        <?php } ?>

        <?php if ( $warn_message ) { ?>
            <div class="alert alert-info">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <h4>Info</h4>
                <?php echo $warn_message; ?>
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
<?php require('elements/help-signin.inc'); ?>
<!--/ Help Modal -->

<!-- Register Modal -->
<?php require('elements/register.inc'); ?>
<!--/ Register Modal -->

<!-- Page Footer -->
<?php require('elements/footer.inc'); ?>
<!--/ Page Footer -->

</body>
</html>
