<?php

namespace App\Library\CsvImporters;

use App\Library\CsvImporter;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MoodleImporter extends CsvImporter
{
    const UPLOAD_DIR = "moodle";
    const MODEL = "App\\Model\\MoodleCsv";

    public function __construct(UploadedFile $file)
    {
        parent::__construct($file, self::UPLOAD_DIR, self::MODEL);
    }
}