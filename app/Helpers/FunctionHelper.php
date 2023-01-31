<?php

namespace App\Helpers;

use DateInterval;
use DateTime;

class FunctionHelper
{

    public static function hari($day)
    {
        $hari = [
            'Sun' => 'Minggu',
            'Mon' => 'Senin',
            'Tue' => 'Selasa',
            'Wed' => 'Rabu',
            'Thu' => 'Kamis',
            'Fri' => 'Jumat',
            'Sat' => 'Sabtu',
        ];
        return $hari[$day];
    }

    public static function jumlahHari($bulan, $tahun)
    {
        $kal = CAL_GREGORIAN;
        $jlhHari = cal_days_in_month($kal, $bulan, $tahun);
        return $jlhHari;
    }
    public static function bulan($bln)
    {

        $bulan = [
            1 => 'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember',
        ];
        return $bulan[$bln];
    }
    public static function bulanSingkat($bln)
    {

        $bulan = [
            1 => 'Jan',
            'Feb',
            'Mar',
            'Apr',
            'Mei',
            'Jun',
            'Jul',
            'Ags',
            'Sep',
            'Okt',
            'Nov',
            'Des',
        ];
        return $bulan[$bln];
    }
    public static function bulanSingkatToIndex($bln)
    {

        $bulan = [
            'Jan' => 1,
            'Feb' => 2,
            'Mar' => 3,
            'Apr' => 4,
            'Mei' => 5,
            'Jun' => 6,
            'Jul' => 7,
            'Ags' => 8,
            'Sep' => 9,
            'Okt' => 10,
            'Nov' => 11,
            'Des' => 12,
        ];
        if (isset($bulan[$bln]))
            return $bulan[$bln];
        else
            return 0;
    }

    public static function weekDay()
    {

        $workdays = array();
        $type = CAL_GREGORIAN;
        $year = date('Y'); // Year in 4 digit 2009 format.

        for ($bulan = 1; $bulan <= 12; $bulan++) {

            $month = $bulan;
            $day_count = cal_days_in_month($type, $month, $year); // Get the amount of days


            for ($i = 1; $i <= $day_count; $i++) {

                $date = $year . '/' . $month . '/' . $i; //format date
                $get_name = date('l', strtotime($date)); //get week day
                $day_name = substr($get_name, 0, 3); // Trim day name to 3 chars

                //if not a weekend add day to array
                if ($day_name != 'Sun' && $day_name != 'Sat') {
                    $workdays[] = date('Y-m-d', strtotime($year . '-' . $month . '-' . $i));
                }
            }
        }
        return $workdays;
    }


    public static function goldar()
    {
        $goldar = ['A', 'B', 'AB', 'O'];
        return $goldar;
    }

    public static function agama()
    {
        $agama = [
            'Islam',
            'Katolik',
            'Protestan',
            'Budha',
            'Hindu',
            'Konghucu',
            'Lain-lain'
        ];
        return $agama;
    }

    public static function rangeBulan($bln, $thn, $range)
    {
        $bulan = [];
        $bln = $bln;
        $totalHari = 0;
        for ($i = 1; $i <= $range; $i++) {

            if ($bln > 12) {
                $bln = 1;
                $thn += 1;
            }
            $row = [];
            $row['bulan'] = self::bulanSingkat($bln) . '-' . $thn;
            $row['jlh_hari'] = self::jumlahHari($bln, $thn);
            $row['bln'] = $bln;
            $row['thn'] = $thn;


            // $bulan[$i] = ($bln).'-'.$thn;
            $totalHari += self::jumlahHari($bln, $thn);
            $bln++;
            $bulan[$i] = $row;
        }

        return [$bulan, 'totalHari' => $totalHari];
    }

    public static function jumlahBungaSSB($bln, $thn, $saldo, $bunga, $totalHari)
    {
        $jlh_hari = self::jumlahHari($bln, $thn);
        // $jlhBunga = $saldo * (($bunga/100) / $totalHari) * $jlh_hari;
        $jlhBunga = $saldo * (($bunga / 100) / self::cal_days_in_year($thn)) * $jlh_hari;
        return $jlhBunga;
    }

    public static function hitungSimpas($jumlahBln, $bungaEfektif, $bungaPA, $nominal)
    {
        $bunga = (1 + ($bungaEfektif / 100));
        // $total = ($nominal / $bunga) / $jumlahBln;
        $total = ($nominal / $bunga) / 12;
        return $total;
    }

    public static function roundUpToAny($n, $x = 5000)
    {
        return round($n / $x) * $x;
    }

    public static function hitungBungaEfektif($bungaPA, $bulan)
    {
        $get      = ceil($bulan / 12);
        $jlhBulan = ($get * 12);
        $bunga    = 1 + (($bungaPA / 100) / $jlhBulan);

        $hitung  = pow($bunga, $jlhBulan) - 1;
        return $hitung * 100;
    }

    public static function hitungAngsuran($fv, $pv, $rate, $nper, $type)
    {
        $PMT = (-$fv - $pv * pow(1 + $rate, $nper)) / (1 + $rate * $type) / ((pow(1 + $rate, $nper) - 1) / $rate);
        return $PMT;
    }

    static function PMT($interest, $num_of_payments, $PV, $FV = 0.00, $Type = 0)
    {
        $xp = pow((1 + $interest), $num_of_payments);
        return ($PV * $interest * $xp / ($xp - 1) + $interest / ($xp - 1) * $FV) *
            ($Type == 0 ? 1 : 1 / ($interest + 1));
    }
    static function PMT2($i, $n, $p)
    {
        return $i * $p * pow((1 + $i), $n) / (1 - pow((1 + $i), $n));
    }

    static function PMTnew($rate, $nper, $pv, $fv, $type)
    {
        return (-$fv - $pv * pow(1 + $rate, $nper)) /
        (1 + $rate * $type) /
        ((pow(1 + $rate, $nper) - 1) / $rate);
    }

    static function ceiling($number, $significance) {
    if ($significance != null) {
        return (is_numeric($number) && is_numeric($significance) ) ? (ceil($number / $significance) * $significance) : $number;
    } else {
        return $number;
    }}

    static function bungaEfektif($bungaPA, $jumlahBulan, $jumlahPinjaman)
    {
        $bungaPA    = $bungaPA / 12;
        // $angs       = abs(self::PMT2($bungaPA, $jumlahBulan, $jumlahPinjaman));
        $angs       = self::ceiling(abs(self::PMTnew($bungaPA, $jumlahBulan, 0, $jumlahPinjaman, 1)),100);
        $efektif    = ((($angs * $jumlahBulan) - $jumlahPinjaman) * 12) / ($jumlahBulan * $jumlahPinjaman);
        return $efektif * 100;
        // return $bungaPA;
    }

    static function bungaEfektifRate($bungaPA, $jumlahBulan, $jumlahPinjaman)
    {
        $bungaPA    = $bungaPA / 12;
        // $angs       = abs(self::PMT2($bungaPA, $jumlahBulan, $jumlahPinjaman));
        $angs       = self::ceiling(abs(self::PMTnew($bungaPA, $jumlahBulan, 0, $jumlahPinjaman, 1)),100);
        $efektif    = ((($angs * $jumlahBulan) - $jumlahPinjaman) * 12) / ($jumlahBulan * $jumlahPinjaman);
        return $efektif * 100;
        // return $bungaPA;
    }

    static function tabunganPerBulan($bungaPA, $jumlahBln, $jumlahPinjaman)
    {
        $bungaEfektif = self::bungaEfektif(($bungaPA / 100), $jumlahBln, $jumlahPinjaman);

        // if($jumlahBln>6)
        $bungaEfektif2 = $bungaEfektif;
        // else
        //     $bungaEfektif2 = $bungaEfektif/2;

        $tabunganEfektif    = $jumlahPinjaman / (100 + $bungaEfektif2) * 100;
        // $tabunganPerBulan   = $tabunganEfektif / $jumlahBln;
        // $angsuran           = abs(self::PMT2(($bungaPA / 100) / 12, $jumlahBln, $jumlahPinjaman));
        // $angsuran           = self::ceiling(abs(self::PMTnew(($bungaPA / 100) / 12, $jumlahBln, 0, $jumlahPinjaman, 1)),100);
        $angsuran           = abs(self::PMTnew(($bungaPA / 100) / 12, $jumlahBln, 0, $jumlahPinjaman, 0));
        $tabunganPerBulan   = $angsuran;

        return [
            'tabunganEfektif'   => $tabunganEfektif,
            'tabunganPerBulan'  => $tabunganPerBulan,
            'bungaEfektif'      => $bungaEfektif,
            'angsuran'          => $angsuran,
        ];
    }

    static function cal_days_in_year($year)
    {
        $totalDaysInYear = date('z', strtotime($year . '-12-31')) + 1;
        return $totalDaysInYear;
    }

    static function add_months($months, DateTime $dateObject) 
    {
        $next = new DateTime($dateObject->format('Y-m-d'));
        $next->modify('last day of +'.$months.' month');

        if($dateObject->format('d') > $next->format('d')) {
            return $dateObject->diff($next);
        } else {
            return new DateInterval('P'.$months.'M');
        }
    }

    public static function endCycle($d1, $months)
    {
        $date = new DateTime($d1);

        // call second function to add the months
        $newDate = $date->add(SELF::add_months($months, $date));

        // goes back 1 day from date, remove if you want same day of month
        $newDate->sub(new DateInterval('P1D')); 

        //formats final date to Y-m-d form
        $dateReturned = $newDate->format('Y-m-d H:i:s'); 

        return $dateReturned;
    }
}
