<?php
/**
 * German Language Installer
 * by OSworX
 */

$parts = pathinfo( __FILE__ );
include( str_replace( 'english', 'en-gb', $parts['dirname'] ) . '/' . $parts['basename'] );