<?php

use PHPUnit\Framework\TestCase;
use App\Repositories\FileReader;
use App\Repositories\JsonParser;
use App\Exceptions\FileReaderException;
use App\Exceptions\DirectoryReadException;
use App\Exceptions\JsonParseException;

class FileReaderTest extends TestCase
{
    protected $dataPath;
    protected $jsonParser;
    protected $fileReader;

    protected function setUp(): void
    {
        $this->dataPath ="storage/app/data/";
        $this->jsonParser = new JsonParser();
        $this->fileReader = new FileReader($this->dataPath, $this->jsonParser);
    }

    protected function tearDown(): void
    {
        $invalidFile = $this->dataPath . '/invalidFile.json';

        if (file_exists($invalidFile)) {
            unlink($invalidFile);
        }

    }

    public function  test_read_data_throws_json_parse_exception()
    {
        $dataPath = $this->dataPath;

        $fileReader = $this->fileReader;
        $jsonData = '"survey": {
            "name": "Paris",
            "name": "XX1",
        },';
        file_put_contents($dataPath . '/' . 'invalidFile.json', $jsonData);
        $this->expectException(JsonParseException::class);

        $fileReader->readData();
    }

    public function test_get_files_throws_exception_for_non_existing_directory()
    {
        $nonExistingDirectory = 'storage/app/nonExistingDirectory';
        $fileReader = new FileReader($nonExistingDirectory,new JsonParser());


        $this->expectException(DirectoryReadException::class);
        $this->expectExceptionMessage('Failed to get files from directory: ' . $nonExistingDirectory);

        @$fileReader->getFiles($nonExistingDirectory);
    }
}
