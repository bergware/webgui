<?PHP
/* Copyright 2005-2016, Lime Technology
 * Copyright 2012-2016, Bergware International.
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
write_log("Saving file $file");
exec("mkdir -p ".escapeshellarg(dirname($file)));
file_put_contents($file, str_replace(["\r\n","\r"], "\n", $_POST['text']));
// syslinux.cfg hack
if ($file == "/boot/syslinux/syslinux.cfg")
  @copy("/boot/syslinux/syslinux.cfg", "/boot/EFI/boot/syslinux.cfg");
// discard settings
$save = false;
?>
