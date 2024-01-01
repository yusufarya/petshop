<?php

namespace App\Exports;

use App\Invoice;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PembelianExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    use Exportable;

    public function __construct($request) {
        $this->session = $request->session();
    }

    public function headings(): array
    {
        return [
            'Nomor Transaksi',
            'Vendor',
            'Tanggal',
            'Rincian Produk',
            'Qty',
            'Harga',
            'Total Harga',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => [
                'font' => [
                    'bold' => true, 
                    'size' => 12,
                ],
            ],
            'L' => [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    // 'wrapText' => true,
                ],
            ],
            'K' => [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                ],
            ]

            // // Styling a specific cell by coordinate.
            // 'B2' => ['font' => ['italic' => true]],
        ];
    }

    public function collection()
    {
        
        $where = '';
        $vendor = $this->session->get('vendor') ? $this->session->get('vendor')[0] : false;
        $date = $this->session->get('date') ? $this->session->get('date')[0] : false;
        $date1 = $this->session->get('date1') ? $this->session->get('date1')[0] : false;
        if($vendor) {
            $where = ['purchase_orders.vendor_code' => $vendor ];
        }
        if ($where) {
            $data = DB::table('purchase_order_details')
                ->select('purchase_orders.code','vendors.name as vendor_name', 'purchase_orders.date', 'products.name as product_name', 'purchase_order_details.qty', 'purchase_order_details.price',
                DB::raw('purchase_order_details.qty*purchase_order_details.price as total_price')
                )
                ->leftJoin('purchase_orders', 'purchase_orders.code', '=', 'purchase_order_details.purchase_order_code')
                ->leftJoin('vendors', 'purchase_orders.vendor_code', '=', 'vendors.code')
                ->leftJoin('products', 'purchase_order_details.product_id', '=', 'products.id') 
                ->where($where) 
                ->WhereBetween('purchase_orders.date', [$date, $date1])
                ->get();
                
        } else {

            $data = DB::table('purchase_order_details')
                ->select('purchase_orders.code','vendors.name as vendor_name', 'purchase_orders.date', 'products.name as product_name', 'purchase_order_details.qty', 'purchase_order_details.price',
                DB::raw('purchase_order_details.qty*purchase_order_details.price as total_price')
                )
                ->leftJoin('purchase_orders', 'purchase_orders.code', '=', 'purchase_order_details.purchase_order_code')
                ->leftJoin('vendors', 'purchase_orders.vendor_code', '=', 'vendors.code')
                ->leftJoin('products', 'purchase_order_details.product_id', '=', 'products.id')
                ->whereBetween('purchase_orders.date', [$date, $date1])
                ->get();
        }
        
        return $data;
    }
}