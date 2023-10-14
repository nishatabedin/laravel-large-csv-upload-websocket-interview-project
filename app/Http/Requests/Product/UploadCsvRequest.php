<?php

namespace App\Http\Requests\Product;

use App\Services\CsvProcessorService;
use Illuminate\Validation\Rules\File;
use Illuminate\Foundation\Http\FormRequest;

class UploadCsvRequest extends FormRequest
{

    public $fileHash;     // Store the file hash
    public $header;       // Store the header
    public $validRows;    // Store the valid rows without the header


    public function authorize()
    {
        return true;
    }



    public function rules()
    {
        return [
            'csv' => [
                'required',
                File::types(['csv']),
            ],
        ];
    }

   

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$this->fileHasCsvExtension()) {
                return false; 
            }
            if (!$this->isValidCsv()) {
                $validator->errors()->add('csv', 'Invalid CSV file. The number of columns in the CSV file does not match the header.');
            }
        });
    }


    public function isValidCsv()
    {
        $csvProcessor = app(CsvProcessorService::class); // Retrieve the service from the container

        $fileContents = $this->getFileContents(); // Retrieve the file contents
        $this->fileHash = md5($fileContents);      // Calculate and store the file hash
        $processedData = $csvProcessor->removeNonUTF8Characters($fileContents);
        $lines = explode("\n", $processedData);
        $header = str_getcsv($lines[0]);

        $validRows = [];

        foreach ($lines as $line) {
            $data = str_getcsv($line);
            if (count($data) === count($header)) {
                $validRows[] = $data;
            }
        }

         // Store the header and valid rows as public properties
         $this->header =$header;
         $this->validRows = array_slice($validRows, 1); // Remove the header row


        // If there are no valid rows (i.e., all rows had a mismatch), the CSV is considered invalid.
        return count($validRows) > 0;
    }


    private function getCsvFile()
    {
        return $this->file('csv');
    }


    private function getFileContents()
    {
        return file_get_contents($this->getCsvFile()->getRealPath()); // Retrieve and return file contents
    }


    public function getClientOriginalName()
    {
        return $this->getCsvFile()->getClientOriginalName();
    }

    public function fileHasCsvExtension()
    {
        $csvFile = $this->file('csv');
        return $csvFile->getClientOriginalExtension() === 'csv';
    }


   
}
