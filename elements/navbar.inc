<?php
/**
 * navbar.inc
 * The navigation bar for the Versions Server web application
 * Author: Federico Mestrone
 * Created: 15/12/2012 12:42
 * Copyright: 2012, Moodsdesign Ltd
 */
$loggedin = !empty($PLUGIN_ID);
$signLabel = $loggedin ? 'Sign out' : 'Sign in';
$userLabel = $loggedin ? 'Profile' : 'Register';
?>
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="brand" href="<?php echo $loggedin ? 'manage.php' : 'index.php'; ?>">Versions Server</a>
            <div class="nav-collapse collapse">
                <ul class="nav">
                    <li<?php if ( $CUR_PAGE == 'signin' ) echo ' class="active"'; ?>><a href="index.php"><?php echo $signLabel ?></a></li>
                    <li><a href="#registerModal" role="button" data-toggle="modal"><?php echo $userLabel ?></a></li>
                    <li<?php if ( $CUR_PAGE == 'plugins' ) echo ' class="active"'; ?>><a href="plugins.php">Plugins</a></li>
                    <li><a href="#aboutModal" role="button" data-toggle="modal">About</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>
</div>
