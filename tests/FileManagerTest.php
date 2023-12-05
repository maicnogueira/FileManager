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