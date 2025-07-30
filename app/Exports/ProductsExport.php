<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use App\Models\Product;

class ProductsExport implements FromCollection, WithHeadings, WithColumnFormatting
{
    protected $products;

    // Constructor to accept products data
    public function __construct($products)
    {
        $this->products = $products;
    }

    // This method returns the collection of products to be exported
    public function collection()
    {
        return $this->products->map(function ($product) {
            return [
                'name' => $product->name,
                'code' => $product->code,
                'category' => $product->category->name ?? 'No Category',
                'supplier' => $product->supplier->name ?? 'No Supplier',
                'price' => number_format($product->price, 2), // Format price as decimal with two decimal places
                'stock' => (string) $product->stock, // Ensure stock is treated as a string
            ];
        });
    }

    // This method defines the column headings for the Excel export
    public function headings(): array
    {
        return [
            'Nama Produk',
            'Kode Produk',
            'Kategori',
            'Supplier',
            'Harga',
            'Stok',
        ];
    }

    // Column formatting: apply formatting to specific columns
    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_NUMBER_00,  // Apply decimal format (2 decimal places) to 'Harga' column
            'F' => '@',  // Treat 'Stok' as string (no numeric formatting)
        ];
    }
}
