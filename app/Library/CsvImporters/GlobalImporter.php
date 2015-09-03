<?php

namespace App\Library\CsvImporters;

use App\Library\CsvImporter;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class GlobalImporter extends CsvImporter
{
    const UPLOAD_DIR = "global";
    const MODEL = "App\\Model\\CsvData";

    public function __construct(UploadedFile $file)
    {
        parent::__construct($file, self::UPLOAD_DIR, self::MODEL);
    }
}