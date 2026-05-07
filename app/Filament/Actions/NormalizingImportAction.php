<?php

namespace App\Filament\Actions;

use Filament\Actions\ImportAction;
use League\Csv\Reader as CsvReader;
use League\Csv\Writer;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use SplTempFileObject;

class NormalizingImportAction extends ImportAction
{
    public function getUploadedFileStream(TemporaryUploadedFile $file)
    {
        $stream = parent::getUploadedFileStream($file);

        if (! $stream) {
            return $stream;
        }

        rewind($stream);
        $firstLine = fgets($stream);
        rewind($stream);

        if (preg_match('/^Account Statement - \(@\w+\)/', (string) $firstLine)) {
            $content = stream_get_contents($stream);

            return $this->normalizeVenmoStream($content);
        }

        return $stream;
    }

    /** @return resource */
    private function normalizeVenmoStream(string $content)
    {

        $reader = CsvReader::createFromString($content);
        $records = iterator_to_array($reader->getRecords());

        $headerRowIndex = null;
        foreach ($records as $i => $row) {
            if (in_array('Datetime', $row, strict: true)) {
                $headerRowIndex = $i;
                break;
            }
        }

        if ($headerRowIndex === null) {
            $tmpStream = fopen('php://temp', 'r+');
            fwrite($tmpStream, $content);
            rewind($tmpStream);

            return $tmpStream;
        }

        $headers = $records[$headerRowIndex];
        $idIdx = array_search('ID', $headers, strict: true);
        $datetimeIdx = array_search('Datetime', $headers, strict: true);
        $fromIdx = array_search('From', $headers, strict: true);
        $toIdx = array_search('To', $headers, strict: true);
        $amountIdx = array_search('Amount (total)', $headers, strict: true);

        $writer = Writer::createFromFileObject(new SplTempFileObject);
        $writer->insertOne(['Posted Date', 'Description', 'Debit', 'Credit']);

        foreach (array_slice($records, $headerRowIndex + 1) as $row) {
            $id = trim($row[$idIdx] ?? '');
            if (! ctype_digit($id)) {
                continue;
            }

            $rawAmount = trim($row[$amountIdx] ?? '');
            $isCredit = str_starts_with($rawAmount, '+');
            $amount = preg_replace('/[^0-9.]/', '', $rawAmount);

            $otherParty = $isCredit ? ($row[$fromIdx] ?? '') : ($row[$toIdx] ?? '');

            $writer->insertOne([
                substr($row[$datetimeIdx] ?? '', 0, 10),
                'Venmo - ' . $otherParty,
                $isCredit ? '' : $amount,
                $isCredit ? $amount : '',
            ]);
        }

        $tmpStream = fopen('php://temp', 'r+');
        fwrite($tmpStream, $writer->toString());
        rewind($tmpStream);

        return $tmpStream;
    }
}
