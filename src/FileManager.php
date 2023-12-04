<?php


namespace FileManager;


class FileManager
{
    public static function open($file)
    {
        return file_get_contents($file);
    }

    public static function list($dir)
    {
        if(is_dir($dir)){
            return scandir($dir);
        }

        return false;
    }

    public static function exists($file): bool
    {
        return file_exists($file);
    }


    public static function save($file, $newLocationOrName): bool
    {
        try {
            if(is_uploaded_file($file)){
                return move_uploaded_file($file,  $newLocationOrName);
            }else{
                return rename($file,  $newLocationOrName);
            }

        }catch (\ErrorException $errorException){
            return false;
        }

    }

    public static function rename($file, $newLocationOrName): bool
    {
        return self::save($file, $newLocationOrName);
    }


    public static function delete($file): bool
    {
        try {
            return unlink($file);
        }catch (\ErrorException $errorException){
            return true;
        }
    }

}