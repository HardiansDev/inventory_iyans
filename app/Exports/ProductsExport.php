<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ProductsExport implements FromCollection, WithHeadings, WithColumnFormatting, WithEvents
{
    protected $products;

    public function __construct($products)
    {
        $this->products = $products;
    }

    public function collection()
    {
        return $this->products->map(function ($product) {
            return [
                'name' => $product->name,
                'code' => $product->code,
                'category' => $product->category->name ?? '-',
                'satuan' => $product->satuan->nama_satuan ?? '-',
                'price' => $product->price, // biar Excel yg formatin, jangan di number_format
                'stock' => $product->stock,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama Produk',
            'Kode Produk',
            'Kategori',
            'Satuan',
            'Harga',
            'Stok',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_NUMBER_00, // Harga: 2 decimal
            'F' => NumberFormat::FORMAT_NUMBER,    // Stok: angka biasa
        ];
    }

    // 👉 AutoFit kolom setelah sheet dibuat
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                foreach (range('A', 'F') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            },
        ];
    }
}
