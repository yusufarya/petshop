<?php

use App\Models\Admin;
use App\Models\Training;
use App\Models\SalesOrder;
use App\Models\DeliveryType;
use App\Models\OrderPayment;
use App\Models\ServiceOrder;
use App\Models\PurchaseOrder;
use Illuminate\Support\Facades\DB;

function testHelper() {
    die('Helper is ready');
}

function last_query() {
    DB::enableQueryLog();

    // and then you can get query log

    dd(DB::getQueryLog());
}

function getCharge(int $type) {
    $type = $type ? $type : 1;
    return DeliveryType::find($type);
}

function getLastPayCode() {
    $lastNumber = OrderPayment::max('code');

    if($lastNumber) {
        $lastNumber = substr($lastNumber, -3);
        $code_ = sprintf('%03d', $lastNumber+1);
        $numberFix = "TR".date('ymd').$code_;
    } else {
        $numberFix = "TR".date('ymd')."001";
    }

    return $numberFix;
}

function getLasCodeTransaction($type) {
    
    if($type == 'P') {
        $lastNumber = PurchaseOrder::max('code');
    
        if($lastNumber) {
            $lastNumber = substr($lastNumber, -3);
            $code_ = sprintf('%03d', $lastNumber+1);
            $numberFix = "PTPS".date('ymd').$code_;
        } else {
            $numberFix = "PTPS".date('ymd')."001";
        }
    } else if($type == 'S') {
        $lastNumber = SalesOrder::max('code');
        if($lastNumber) {
            $lastNumber = substr($lastNumber, -3);
            $code_ = sprintf('%03d', $lastNumber+1);
            $numberFix = "STPS".date('ymd').$code_;
        } else {
            $numberFix = "STPS".date('ymd')."001";
        }
    } else if($type == 'R') {
        $lastNumber = ServiceOrder::max('code');
    
        if($lastNumber) {
            $lastNumber = substr($lastNumber, -3);
            $code_ = sprintf('%03d', $lastNumber+1);
            $numberFix = "SERV".date('ymd').$code_;
        } else {
            $numberFix = "SERV".date('ymd')."001";
        }
    } 

    return $numberFix;
}

function cleanSpecialChar($string) {
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
    $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
 
    return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
 }

function rupiah($angka) {
    $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
    echo $hasil_rupiah;
}

if (!function_exists('getMonthName')) {
    function getMonthName($bln) {
        switch ($bln) {
            case '1':
                $bulan = 'Januari';
                break;
            case '2':
                $bulan = 'Februari';
                break;
            case '3':
                $bulan = 'Maret';
                break;
            case '4':
                $bulan = 'April';
                break;
            case '5':
                $bulan = 'Mei';
                break;
            case '6':
                $bulan = 'Juni';
                break;
            case '7':
                $bulan = 'Juli';
                break;
            case '8':
                $bulan = 'Agustus';
                break;
            case '9':
                $bulan = 'September';
                break;
            case '10':
                $bulan = 'Oktober';
                break;
            case '11':
                $bulan = 'November';
                break;
            case '12':
                $bulan = 'Desember';
                break;
            default:
                break;
        }
        return $bulan;
    }
}

// Mendapatkan file script
function getContentScript($isAdmin, $filename) {
    if($isAdmin === true) {
        $filename_script = base_path() . '/public/js/admin-page/' . $filename . '.js';
        if (file_exists($filename_script)) {
            $filename_script = 'js/admin-page/'. $filename;
        } else {
            $filename_script = 'js/admin-page/default_script';
        }
    } else {
        $filename_script = base_path() . '/public/js/user-page/' . $filename . '.js';
        if (file_exists($filename_script)) {
            $filename_script = 'js/user-page/'. $filename;
        } else {
            $filename_script = 'js/admin-page/default_script';
        }
    }
    
    return $filename_script;
}

function getLasCodeAdmin() {
        
    $lastCode = Admin::max('code');

    if($lastCode) {
        $lastCode = substr($lastCode, -2);
        $code_ = sprintf('%02d', $lastCode+1);
        $codeFix = "ADM".date('Ymd').$code_;
    } else {
        $codeFix = "ADM".date('Ymd')."01";
    }

    return $codeFix;
}

?>