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

class PenjualanExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    use Exportable;

    public function __construct($request) {
        $this->session = $request->session();
    }

    public function headings(): array
    {
        return [
            'Nomor Transaksi',
            'Pelanggan',
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
        $where = ['sales_orders.status'=>'Y'];
        $customer = $this->session->get('customer') ? $this->session->get('customer')[0] : false;
        $date = $this->session->get('date') ? $this->session->get('date')[0] : false;
        $date1 = $this->session->get('date1') ? $this->session->get('date1')[0] : false;
        if($customer) {
            $where = ['sales_orders.customer_code' => $customer ];
        }
        if ($where) {
            $data = DB::table('sales_order_details')
                ->select('sales_orders.code','customers.fullname as customer_name', 'sales_orders.date', 'products.name as product_name', 'sales_order_details.qty as total_qty', 'sales_order_details.price as price', 'sales_orders.total_price as total_price')
                ->leftJoin('sales_orders', 'sales_orders.code', '=', 'sales_order_details.sales_order_code')
                ->leftJoin('customers', 'sales_orders.customer_code', '=', 'customers.code')
                ->leftJoin('products', 'sales_order_details.product_id', '=', 'products.id') 
                ->where($where) 
                ->WhereBetween('sales_orders.date', [$date, $date1])
                ->get();
                
        } else {

            $data = DB::table('sales_order_details')
                ->select('sales_orders.code','customers.fullname as customer_name', 'sales_orders.date', 'products.name as product_name', 'sales_order_details.qty as total_qty', 'sales_order_details.price as price', 'sales_orders.total_price as total_price')
                ->leftJoin('sales_orders', 'sales_orders.code', '=', 'sales_order_details.sales_order_code')
                ->leftJoin('customers', 'sales_orders.customer_code', '=', 'customers.code')
                ->leftJoin('products', 'sales_order_details.product_id', '=', 'products.id')
                ->whereBetween('sales_orders.date', [$date, $date1])
                ->get();
        }
        
        return $data;
    }
}