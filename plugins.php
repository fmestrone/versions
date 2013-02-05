<?php
/**
 * index.php
 * Author: Federico Mestrone
 * Created: 14/12/2012 13:51
 * Copyright: 2012, Moodsdesign Ltd
 */
$CUR_PAGE = 'plugins';

unset($PLUGIN);
unset($PLUGIN_ID);

session_start();

$PLUGIN_ID = $_SESSION['PluginID'];

if ( !empty($PLUGIN_ID) ) {
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
}

/**
 * http://pkarl.com/articles/contextual-user-friendly-time-and-dates-php/
 * @param $small_ts
 * @param int|bool(false) $large_ts
 * @return bool(false)|string
 */
function contextualTime($small_ts, $large_ts = false) {
    if ( !$large_ts ) $large_ts = time();
    $n = $large_ts - $small_ts;
    if ( $n <= 1 ) return 'less than 1 second ago';
    if ( $n < (60) ) return $n . ' seconds ago';
    if ( $n < (60*60) ) { $minutes = round($n/60); return 'about ' . $minutes . ' minute' . ($minutes > 1 ? 's' : '') . ' ago'; }
    if ( $n < (60*60*16) ) { $hours = round($n/(60*60)); return 'about ' . $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ago'; }
    if ( $n < (time() - strtotime('yesterday')) ) return 'yesterday';
    if ( $n < (60*60*24) ) { $hours = round($n/(60*60)); return 'about ' . $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ago'; }
    if ( $n < (60*60*24*6.5) ) return 'about ' . round($n/(60*60*24)) . ' days ago';
    if ( $n < (time() - strtotime('last week')) ) return 'last week';
    if ( round($n/(60*60*24*7))  == 1 ) return 'about a week ago';
    if ( $n < (60*60*24*7*3.5) ) return 'about ' . round($n/(60*60*24*7)) . ' weeks ago';
    if ( $n < (time() - strtotime('last month')) ) return 'last month';
    if ( round($n/(60*60*24*7*4))  == 1 ) return 'about a month ago';
    if ( $n < (60*60*24*7*4*11.5) ) return 'about ' . round($n/(60*60*24*7*4)) . ' months ago';
    if ( $n < (time() - strtotime('last year')) ) return 'last year';
    if ( round($n/(60*60*24*7*52)) == 1 ) return 'about a year ago';
    if ( $n >= (60*60*24*7*4*12) ) return 'about ' . round($n/(60*60*24*7*52)) . ' years ago';
    return false;
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

        <div id="plugins-table">
            <h2 class="form-signin-heading">Registered plugins</h2>
            <?php
            $found = false;
            if ( $handle = opendir('data') ) {
                while ( false !== ($entry = readdir($handle)) ) {
                    if ( $entry[0] != '.' && is_file("data/$entry") && is_readable("data/$entry") ) {
                        $raw = file_get_contents("data/$entry");
                        if ( ($data = unserialize($raw)) ) {
                            if ( !$found ) {
                                $found = true;
                                echo '<table class="table table-hover">';
                                echo '<thead>';
                                echo '<tr><th>';
                                echo 'Plugin ID';
                                echo '</th><th>';
                                echo 'Version';
                                echo '</th><th>';
                                echo 'URL <small>(first 50 chars)</small>';
                                echo '</th><th>';
                                echo 'Release';
                                echo '</th></tr>';
                                echo '</thead>';
                            }
                            echo '<tr><td>';
                            echo $entry;
                            echo '</td><td>';
                            if ( empty($data['plugin_new_version']) ) {
                                echo '<span rel="tooltip" data-placement="bottom" title="The author of this plugin has not registered any released versions yet."><i class="icon-ban-circle"></i></span>';
                            } else {
                                echo $data['plugin_new_version'];
                            }
                            echo "</td><td><a href=\"$data[plugin_url]\" target=\"_blank\">";
                            echo substr($data['plugin_url'], 0, 50);
                            echo '</a></td><td>';
                            if ( empty($data['plugin_timestamp']) ) {
                                echo '<span rel="tooltip" data-placement="bottom" title="The author of this plugin has not registered any released versions yet."><i class="icon-ban-circle"></i></span>';
                            } else {
                                echo contextualTime($data['plugin_timestamp']);
	                            echo '<span rel="tooltip" data-placement="bottom" title="';
	                            echo date('D d M Y',$data['plugin_timestamp']);
	                            echo '"> <i class="icon-calendar"></i></span>';
                            }
                            echo '</td></tr>';
                        }
                    }
                }
                closedir($handle);
                if ( $found ) {
                    echo '</table>';
                }
            }
            ?>
            <?php if ( !$found ) { ?>
                <div class="alert alert-info">
                    <h4>No Registered Plugins</h4>
                    There are no plugins that use Version Check with this Versions Server at the moment
                </div>
            <?php } ?>
        </div>

        <!--/ Page Content -->
    </div>

    <div id="push"></div>

</div>

<!-- About Modal -->
<?php require('elements/about.inc'); ?>
<!--/ About Modal -->

<!-- Register Modal -->
<?php require('elements/register.inc'); ?>
<!--/ Register Modal -->

<!-- Page Footer -->
<?php require('elements/footer.inc'); ?>
<!--/ Page Footer -->

</body>
</html>
