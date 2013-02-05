<?php
/**
 * register.php
 * The Ajax registration page
 * Author: Federico Mestrone
 * Created: 15/12/2012 18:05
 * Copyright: 2012, Moodsdesign Ltd
 */

unset($PLUGIN);
unset($PLUGIN_ID);
unset($error_message);

session_start();

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    $PLUGIN_ID = $_SESSION['PluginID'];
    if ( !empty($PLUGIN_ID) ) {
        $filename = 'data/' . $PLUGIN_ID;
        if ( !is_readable($filename) ) {
            echo json_encode(array('status'=>'unreadable'));
            exit;
        }
        $raw = file_get_contents($filename);
        $PLUGIN = unserialize($raw);
        if ( empty($PLUGIN) ) {
            echo json_encode(array('status'=>'invalid'));
            exit;
        }
    } else {
        $PLUGIN = array();
    }

    $pluginid = $_POST['pluginid'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $email = $_POST['email'];
    $url = $_POST['url'];
    if ( !empty($PLUGIN_ID) && ($PLUGIN_ID != $pluginid) ) {
        echo json_encode(array('status'=>'inconsistent'));
        exit;
    }
    if ( !$pluginid || (empty($PLUGIN_ID) && (!$password || !$password2)) || !$email || !$url ) {
        echo json_encode(array('status'=>'missing'));
        exit;
    }
    if ( $password != $password2 ) {
        echo json_encode(array('status'=>'password'));
        exit;
    }
    if ( empty($PLUGIN_ID) && file_exists("data/$pluginid") ) {
        echo json_encode(array('status'=>'exists'));
        exit;
    }
    if ( !empty($password) ) {
        $PLUGIN['password'] = md5($password);
    }
    $PLUGIN['plugin_email'] = $email;
    $PLUGIN['plugin_url'] = $url;
    $raw = serialize($PLUGIN);
    if ( !file_put_contents("data/.$pluginid", $raw) ) {
        echo json_encode(array('status'=>'unsaved'));
        exit;
    }
	mail('federico@moodsdesign.com','New plugin in Versions Server','From: "Versions Server" <info@moodsdesign.com>');
    echo json_encode(array('status'=>empty($PLUGIN_ID)?'created':'saved'));
}
