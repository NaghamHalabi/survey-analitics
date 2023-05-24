<?php

namespace App\Repositories;
use App\Repositories\JsonParser;
use App\Exceptions\{
    FileReaderException,
    DirectoryReadException,
    JsonParseException
};

class FileReader
{
    protected $dataPath;
    protected $jsonParser;

    public function __construct($dataPath, JsonParser $jsonParser)
    {
        $this->dataPath = $dataPath;
        $this->jsonParser = $jsonParser;
    }

    public function read($filePath)
    {
        try {
            $fileData = file_get_contents($filePath);
            if ($fileData == false) {
                throw new FileReaderException('Failed to read file: ' . $filePath);
            }
            return $fileData;
        } catch (FileReaderException $e) {

            error_log($e->getMessage(), 3, 'logger');
            throw $e;
        }
    }

    public function getFiles($directory)
    {
        try {
            $files = scandir($directory);

            if ($files === false) {
                throw new DirectoryReadException('Failed to get files from directory: ' . $directory);
            }
            $filteredFiles = [];

            foreach ($files as $file) {
                    if ($file !== '.' && $file !== '..') {
                    $filteredFiles[] = $file;
                }
            }
            return $filteredFiles;
        } catch (DirectoryReadException $e) {

            error_log($e->getMessage(), 3, 'logger');
            throw $e;
        }
    }

    public function isJsonFile($file)
    {
        return pathinfo($file, PATHINFO_EXTENSION) === 'json';
    }

    public function readData()
    {
        $dataFiles = $this->getDataFiles();
        $data = [];

        foreach ($dataFiles as $filename) {
            $filePath = $this->dataPath . '/' . $filename;
            $fileData = $this->read($filePath);
            $decodedData = $this->jsonParser->parse($fileData);

            if ($decodedData === null && json_last_error() !== JSON_ERROR_NONE) {
                throw new JsonParseException("Error parsing JSON file: $filePath");
            }
            $data[] = $decodedData;

        }

        return $data;
    }

    public function getDataFiles()
    {
        $files = $this->getFiles($this->dataPath);
        $dataFiles = [];
        foreach ($files as $file) {
            if ($this->isJsonFile($file)) {
                $dataFiles[] = $file;
            }
        }
        return $dataFiles;
    }

}
