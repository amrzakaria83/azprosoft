<?php
// app/Exports/CollectionExport.php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CollectionExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $collection;
    protected $headings;

    public function __construct($collection, $headings = null)
    {
        $this->collection = $collection;
        $this->headings = $headings;

    }

    public function collection()
    {
        return $this->collection;
    }

    public function headings(): array
    {
        if ($this->headings) {
            return $this->headings;
        }

        // Fallback: get headings from first item if not provided
        if ($this->collection->isNotEmpty()) {
            return array_keys($this->collection->first());
        }

        return [];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]], // Bold headers
        ];
    }
}