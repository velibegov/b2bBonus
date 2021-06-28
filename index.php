<?php
 
function duplicateRemove(string $path, array &$filesHashes = [])
{
    $path = realpath($path);
    if ($dir = opendir($path)) { 
        while ($file = readdir($dir)) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            
            if (is_file($path . '/' . $file)) {
                $hash = md5_file($path . '/' . $file);
                if (!in_array($hash, $filesHashes)) {
                    $filesHashes[$file] = $hash;
                } else {
                    unlink($path . '/' . $file);
                }
            }    
            
            if (is_dir($path . '/' . $file)) {
                duplicateRemove($path . '/' . $file, $filesHashes);
            }
        }
        closedir($dir);
    } return $filesHashes;
}
 
var_export(duplicateRemove('./'));
