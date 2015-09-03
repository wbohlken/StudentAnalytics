<?php

namespace App\Library\CsvImporters;

use App\Library\CsvImporter;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class VloImporter extends CsvImporter
{
    const UPLOAD_DIR = "vlo";
    const MODEL = "App\\Model\\VloCsv";

    public function __construct(UploadedFile $file)
    {
        parent::__construct($file, self::UPLOAD_DIR, self::MODEL);
    }
}