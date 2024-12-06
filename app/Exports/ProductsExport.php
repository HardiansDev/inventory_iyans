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
                'pic' => $product->pic->name ?? 'No PIC Assigned',
                'price' => $product->price,
                'qty' => $product->qty,
                'stock' => $product->stock,
                'quality' => $product->quality,
                'purchase' => $product->purchase,
                'billnum' => $product->billnum,
            ];
        });
    }

    // This method defines the column headings for the Excel export
    public function headings(): array
    {
        return [
            'Product Name',
            'Product Code',
            'Category',
            'Supplier',
            'PIC',
            'Price',
            'Quantity',
            'Stock',
            'Quality',
            'Purchase',
            'Billing Number',
        ];
    }

    // Column formatting: apply formatting to specific columns
    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,  // Apply formatting to 'Price' column

        ];
    }
}
