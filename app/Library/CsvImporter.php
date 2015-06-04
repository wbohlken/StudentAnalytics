<?php

namespace App\Library;

use Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Facades\Validator;

/**
 * Class CsvImporter
 * @package App\Library
 */
abstract class CsvImporter
{

	/**
	 * @var null|string
	 */
	private $fileName;

	/**
	 * @var UploadedFile
	 */
	private $file;

	/**
	 * Rules for the validator.
	 * @var array
	 */
	private $rules = ['file' => 'required'];

	/**
	 * Directory to upload the CSV file to, should be defined in child classes.
	 * @var string
	 */
	private $uploadDir;

	/**
	 * Model name to insert the data to.
	 * @var string
	 */
	private $modelName;

	/**
	 * Will be set when the validate() method is called.
	 * @var bool
	 */
	private $valid = FALSE;

	/**
	 * @param UploadedFile $file
	 * @param $uploadDir
	 * @param $modelName
	 * @throws Exception
	 */
	public function __construct(UploadedFile $file, $uploadDir, $modelName)
	{
		if (!class_exists($modelName)) {
			throw new Exception($modelName . " not found.");
		}
		$this->fileName = $file->getClientOriginalName();
		$this->file = $file;
		$this->modelName = $modelName;
		$this->uploadDir = storage_path('files/' . $uploadDir . '/');

		if ($file->isValid() && $this->validate()) {
			$file->move($this->uploadDir, $this->fileName);
		} else {
			throw new Exception("CSV file not valid.");
		}
	}

	/**
	 * @return bool
	 */
	private function validate()
	{
		$file = ['file' => $this->file];
		$validator = Validator::make($file, $this->rules);
		if ($validator->fails()) {
			$this->valid = TRUE;
			return FALSE;
		}
		return TRUE;
	}

	/**
	 * @return bool
	 */
	public function hasError()
	{
		return !$this->valid;
	}

	/**
	 * @param bool $truncate
	 */
	public function import($truncate = FALSE)
	{
		if ($truncate) {
			$model = new $this->modelName;
			$model->truncate();
		}
		$file = file($this->uploadDir . $this->fileName);
		$csvColumns = $file[0];
		$columns = str_getcsv($csvColumns, ';');

		foreach ($file as $key => $row) {
			if ($key > 0) {
				$instance = new $this->modelName();
				$csvRow = str_getcsv($row, ';');
				foreach ($csvRow as $columnKey => $value) {
					$instance->{$columns[$columnKey]} = str_replace(',', '.', $value);
				}
				$instance->save();
			}
		}
	}
}