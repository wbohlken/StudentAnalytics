<?php
/**
 * Created by PhpStorm.
 * User: Wouter
 * Date: 4-6-2015
 * Time: 15:19
 */

namespace App\Library\CsvImporters;

use App\Library\CsvImporter;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class SisImporter extends CsvImporter{

	const UPLOAD_DIR = "sis";
	const MODEL = "App\\Model\\SisCsv";

	public function __construct(UploadedFile $file)
	{
		parent::__construct($file, self::UPLOAD_DIR, self::MODEL);
	}
}