<?php

namespace Hanafalah\ModuleProcurement\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleProcurement\Contracts\Data\TaxData as DataTaxData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class TaxData extends Data implements DataTaxData{
    #[MapName('total')] 
    #[MapInputName('total')] 
    public ?float $total = null;

    #[MapName('ppn')] 
    #[MapInputName('ppn')] 
    public ?float $ppn = null;

    #[MapName('pph')] 
    #[MapInputName('pph')] 
    public ?float $pph = null;

    // PPh Final Pasal 4 ayat (2) – biasanya untuk jasa konstruksi, sewa, atau penghasilan tertentu
    #[MapName('pph4')] 
    #[MapInputName('pph4')] 
    public ?float $pph4 = null;

    // PPh Pasal 15 – untuk wajib pajak tertentu seperti pelayaran, penerbangan, dsb
    #[MapName('pph15')] 
    #[MapInputName('pph15')] 
    public ?float $pph15 = null;

    // PPh Pasal 19 – jarang digunakan; terkait koreksi fiskal, lebih teknikal (opsional jika diperlukan)
    #[MapName('pph19')] 
    #[MapInputName('pph19')] 
    public ?float $pph19 = null;

    // PPh Pasal 21 – pajak atas penghasilan karyawan/tenaga kerja (gaji, honor, upah)
    #[MapName('pph21')] 
    #[MapInputName('pph21')] 
    public ?float $pph21 = null;

    // PPh Pasal 22 – pajak atas kegiatan impor dan pembelian oleh instansi pemerintah/BUMN
    #[MapName('pph22')] 
    #[MapInputName('pph22')] 
    public ?float $pph22 = null;

    // PPh Pasal 23 – atas jasa, sewa, royalti, hadiah, dll. Umumnya 2% untuk jasa
    #[MapName('pph23')] 
    #[MapInputName('pph23')] 
    public ?float $pph23 = null;

    // PPh Pasal 29 – kekurangan bayar pajak penghasilan di akhir tahun pajak (pelunasan)
    #[MapName('pph29')] 
    #[MapInputName('pph29')] 
    public ?float $pph29 = null;


    public static function after(TaxData $data): TaxData{
        $data->total ??= 0;
        $data->total += $data->ppn ?? 0;

        $data->pph ??= 0;
        $data->pph += $data->pph4 ?? 0 + $data->pph15 ?? 0  + 
                      $data->pph19 ?? 0  + $data->pph21 ?? 0  + 
                      $data->pph22 ?? 0  + $data->pph23 ?? 0  + $data->pph29 ?? 0;

        $data->total += $data->pph ?? 0;
        return $data;
    }
}