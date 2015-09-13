<?php

namespace IonXLab\IonXApi\util;

/**
 * User: xion
 * Date: 7/23/15
 * Time: 3:52 PM
 */

class Util {
    /**
    * Single level, Case Insensitive File Exists.
    *
    * Only searches one level deep. Based on
    * https://gist.github.com/hubgit/456028
    *
    * @param string $file The file path to search for.
    * @return string The path if found, FALSE otherwise.
    */
    public static function file_exists_ci_single($file) {
        if (file_exists($file) === true) {
            return $file;
        }
        $lowerFile = strtolower($file);
        foreach (glob(dirname($file).'/*') as $file) {
            if (strtolower($file) === $lowerFile) {
                return $file;
            }
        }
        return false;
    }

    /**
     * Case Insensitive File Search.
     * @param string $filePath The full path of the file to search for.
     * @return string File path if valid, FALSE otherwise.
     */
    public static function file_exists_ci($filePath) {
        if (file_exists($filePath) === TRUE) {
            return $filePath;
        }
        // Split directory up into parts.
        $dirs = explode('/', $filePath);
        $len  = count($dirs);
        $dir  = '/';
        foreach ($dirs as $i => $part) {
            $dirPath = self::file_exists_ci_single($dir.$part);
            if ($dirPath === FALSE) {
                return FALSE;
            }
            $dir  = $dirPath;
            $dir .= (($i > 0) && ($i < $len - 1)) ? '/' : '';
        }
        return $dir;
    }


    /**
     * Check if given parameter is a string and if it's not empty
     * @param $string
     * @return bool
     */
    public static function isGoodString($string) {
        return (!is_null($string) && is_string($string) && strlen($string)!=0);
    }

    /**
     * Take unlimited string arguments and return a path built from them.<br><br>
     * Strip spaces,tabulations, slashes, anti-slashes from arguments<br>
     * excepting the left slash for first arg and right slash for the last one
     * @return string
     */
    public static function buildPath() {
        $path = "";
        for($i=0;$i<func_num_args();$i++) {
            $arg = func_get_arg($i);
            if(is_string($arg)) {
                $arg = str_replace("\\","/",$arg);
                $arg = ltrim($arg, "\t\n\r\0\x0B");
                $arg = rtrim($arg, "\t\n\r\0\x0B");
                if($i!=0) {
                    $arg = ltrim($arg, "/");
                }
                if($i!=func_num_args()-1) {
                    $arg = rtrim($arg, "/");
                }
                $path .= ($i!=0 ? "/" : "").$arg;
            }
        }
        return $path;
    }
}