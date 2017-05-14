<?PHP
/* Copyright 2005-2017, Lime Technology
 * Copyright 2012-2017, Bergware International.
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License version 2,
 * as published by the Free Software Foundation.
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 */
?>
<?
$task = $_POST['task'];
switch ($task) {
case 'delete':
  $gateway =str_replace(' ','-', trim($_POST['gateway']));
  $route = trim($_POST['route']);
  if ($gateway && $route) exec("/etc/rc.d/rc.inet1 ".escapeshellarg("{$gateway}_{$route}_del"));
  break;
case 'Add Route':
  $gateway =str_replace(' ','-', trim($_POST['gateway']));
  $route = trim($_POST['route']);
  $metric = strlen($_POST['metric']) ? trim($_POST['metric']) : 1;
  if ($gateway && $route) exec("/etc/rc.d/rc.inet1 ".escapeshellarg("{$gateway}_{$route}_{$metric}_add"));
  break;
default:
  exec("ip -4 route show|grep -v '^127.0.0.0'",$ipv4);
  exec("ip -6 route show|grep -Pv '^(fe80|ff0[0-9])::/'",$ipv6);
  foreach ($ipv4 as $info) {
    $cell = explode(' ',$info);
    $route = $cell[0];
    $gateway = $cell[2];
    $button = preg_replace('/[\.:\/]/','',$gateway.$route);
    $metric = '1';
    for ($i=3; $i<count($cell); $i++) if ($cell[$i] == 'metric') {$metric = $cell[$i+1]; break;}
    echo "<tr><td>IPv4</td><td>$route</td><td>$gateway</td><td>$metric</td><td style='text-align:center'><a id='$button' href='#' onclick='deleteRoute(\"#$button\",\"$gateway\",\"$route\");return false'><i class='fa fa-trash-o'></i></a></td></tr>";
  }
  if ($ipv6) echo "<tr class='tr_last'><td colspan='5'>&nbsp;</td></tr>";
  foreach ($ipv6 as $info) {
    $cell = explode(' ',$info);
    $route = $cell[0];
    $gateway = $cell[2];
    $button = preg_replace('/[\.:\/]/','',$gateway.$route);
    $metric = '1';
    for ($i=3; $i<count($cell); $i++) if ($cell[$i] == 'metric') {$metric = $cell[$i+1]; break;}
    echo "<tr><td>IPv6</td><td>$route</td><td>$gateway</td><td>$metric</td><td style='text-align:center'><a id='$button' href='#' onclick='deleteRoute(\"#$button\",\"$gateway\",\"$route\");return false'><i class='fa fa-trash-o'></i></a></td></tr>";
  }
  echo "<tr class='tr_last'><td colspan='5'>&nbsp;</td></tr>";
}
?>
