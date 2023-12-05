<?php

declare(strict_types=1);

namespace Tests;

use FileManager\FileManager;
use PHPUnit\Framework\TestCase;


class FileManagerTest extends TestCase
{
    private string $folder;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->folder = __DIR__."/files";
        if(!is_dir($this->folder)){
            mkdir($this->folder);
        }

        file_put_contents($this->folder."/1.pdf", NULL);
        file_put_contents($this->folder."/2.pdf", NULL);
        file_put_contents($this->folder."/3.pdf", NULL);
        file_put_contents($this->folder."/4.pdf", NULL);

        if(!is_dir($this->folder."/pasta1")){
            mkdir($this->folder."/pasta1");
        }
        if(!is_dir($this->folder."/pasta2")){
            mkdir($this->folder."/pasta2");
        }
        if(!is_dir($this->folder."/pasta3")){
            mkdir($this->folder."/pasta3");
        }

        if(!is_dir($this->folder."/new-folder")){
            mkdir($this->folder."/new-folder");
        }

    }

    public function testOpen()
    {
        $file = FileManager::open($this->folder."/1.pdf");
        self::assertIsString($file);
    }

    public function testOpenNotExists()
    {
        $file = FileManager::open($this->folder."/12.pdf");
        self::assertFalse($file);
    }

    public function testExistsFile()
    {
        $file = FileManager::exists($this->folder."/1.pdf");
        self::assertTrue($file);
    }

    public function testNotExistsFile()
    {
        $file = FileManager::exists($this->folder."/12.pdf");
        self::assertFalse($file);
    }

    public function testSaveFile()
    {
        if(!is_dir($this->folder."/new-folder")){
            mkdir($this->folder."/new-folder");
        }
        $file = FileManager::save($this->folder."/1.pdf", $this->folder."/new-folder/1.pdf");
        self::assertTrue($file);
    }

    public function testNotSaveFile()
    {
        if(!is_dir($this->folder."/new-folder")){
            mkdir($this->folder."/new-folder");
        }
        $file = FileManager::save($this->folder."/12.pdf", $this->folder."/new-folder/12.pdf");
        self::assertFalse($file);
    }

    public function testRenameFile()
    {

        $file = FileManager::rename($this->folder."/2.pdf", $this->folder."/10.pdf");
        self::assertTrue($file);
    }

    public function testNoRenameFile()
    {

        $file = FileManager::rename($this->folder."/12.pdf", $this->folder."/13.pdf");
        self::assertFalse($file);
    }

    public function testDeleteFile()
    {

        $file = FileManager::delete($this->folder."/3.pdf");
        self::assertTrue($file);
    }

    public function testNoDeleteFile()
    {

        $file = FileManager::delete($this->folder."/12.pdf");
        self::assertFalse($file);
    }

    public function testListFiles()
    {
        $result = FileManager::listFiles($this->folder);
        self::assertIsArray($result);
    }

    public function testListFilesNotExists()
    {
        $result = FileManager::listFiles($this->folder."/naoexiste");
        self::assertFalse($result);
    }

    public function testListDir()
    {
        $result = FileManager::listDir($this->folder);
        self::assertIsArray($result);
    }

    public function testListDirNotExists()
    {
        $result = FileManager::listDir($this->folder."/naoexiste");
        self::assertFalse($result);
    }

    public function __destruct()
    {
        self::deletarDiretorio($this->folder);
    }

    static function deletarDiretorio($caminho)
    {
        if (is_dir($caminho)) {
            $diretorio = opendir($caminho);

            while (($arquivo = readdir($diretorio)) !== false) {
                if ($arquivo != "." && $arquivo != "..") {
                    $caminhoCompleto = $caminho . '/' . $arquivo;

                    if (is_dir($caminhoCompleto)) {
                        self::deletarDiretorio($caminhoCompleto);
                    } else {
                        unlink($caminhoCompleto);
                    }
                }
            }

            closedir($diretorio);
            rmdir($caminho);
        }
    }
}