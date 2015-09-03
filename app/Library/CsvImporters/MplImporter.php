<?php
/**
 * Created by PhpStorm.
 * User: Wouter
 * Date: 4-6-2015
 * Time: 15:18
 */

namespace App\Library\CsvImporters;

use App\Library\CsvImporter;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MplImporter extends CsvImporter
{
    const UPLOAD_DIR = "mpl";
    const MODEL = "App\\Model\\MplCsv";

    public function __construct(UploadedFile $file)
    {
        parent::__construct($file, self::UPLOAD_DIR, self::MODEL);
    }
}