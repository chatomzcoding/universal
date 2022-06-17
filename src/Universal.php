<?php
namespace zelnaradev\universe;

use DateTime;

class Universal {
    // HELPER BILANGAN
    // Mata Uang
    public static function rupiah($nominal=0)
    {
        if (is_string($nominal)) {
            $result = 'parameter harus angka/bilangan bulat';
        } else {
            $result = "Rp " . number_format($nominal,2,',','.');
        }
        return $result;
    }
    public static function norupiah($nominal=0)
    {
        if (is_string($nominal)) {
            $result = 'parameter harus angka/bilangan bulat';
        } else {
            $result = number_format($nominal,2,',','.');
            $result = str_replace(',00','',$result);
        }
        return $result;
    }

    public static function hapusrupiah($rupiah)
    {
        $result = str_replace('Rp. ', '', $rupiah);
        $result = str_replace('Rp ', '', $result);
        $result = str_replace('.', '', $result);
        $result = str_replace(',', '.', $result);

        return intval($result);
    }

    public static function terbilang($bilangan)
    {
        $param      = $bilangan;
        $bilangan   = intval($bilangan);
        if (empty($bilangan)) {
            return 'parameter tidak sesuai > '.$param;
        }
        $angka 		= array('0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0');
        $kata 		= array('','satu','dua','tiga','empat','lima','enam','tujuh','delapan','sembilan');
        $tingkat 	= array('','ribu','juta','milyar','triliun');

        $panjang_bilangan = strlen($bilangan);

        /* pengujian panjang bilangan */
        if ($panjang_bilangan > 15) {
            $kalimat = "Bilangan Diluar Batas";
            return $kalimat;
        }
        /* mengambil angka-angka yang ada dalam bilangan,
            dimasukkan ke dalam array */
        for ($i = 1; $i <= $panjang_bilangan; $i++) {
            $angka[$i] = substr($bilangan,-($i),1);
        }

        $i = 1;
        $j = 0;
        $kalimat = "";
        /* mulai proses iterasi terhadap array angka */
        while ($i <= $panjang_bilangan) {
            $subkalimat = "";
            $kata1 = "";
            $kata2 = "";
            $kata3 = "";

                /* untuk ratusan */
            if ($angka[$i+2] != "0") {
                if ($angka[$i+2] == "1") {
                    $kata1 = "seratus";
                } else {
                    $kata1 = $kata[$angka[$i+2]] . " ratus";
                }
            }

                /* untuk puluhan atau belasan */
            if ($angka[$i+1] != "0") {
                if ($angka[$i+1] == "1") {
                    if ($angka[$i] == "0") {
                    $kata2 = "sepuluh";
                    } elseif ($angka[$i] == "1") {
                    $kata2 = "sebelas";
                    } else {
                    $kata2 = $kata[$angka[$i]] . " belas";
                    }
                } else {
                    $kata2 = $kata[$angka[$i+1]] . " puluh";
                }
            }

                /* untuk satuan */
            if ($angka[$i] != "0") {
                if ($angka[$i+1] != "1") {
                    $kata3 = $kata[$angka[$i]];
                }
            }

                /* pengujian angka apakah tidak nol semua,
                lalu ditambahkan tingkat */
            if (($angka[$i] != "0") OR ($angka[$i+1] != "0") OR ($angka[$i+2] != "0")) {
                $subkalimat = "$kata1 $kata2 $kata3 " . $tingkat[$j] . " ";
            }

                /* gabungkan variabe sub kalimat (untuk satu blok 3 angka)
                ke variabel kalimat */
            $kalimat = $subkalimat . $kalimat;
            $i = $i + 3;
            $j = $j + 1;

        }

        /* mengganti satu ribu jadi seribu jika diperlukan */
        if (($angka[5] == "0") AND ($angka[6] == "0")) {
            $kalimat = str_replace("satu ribu","seribu",$kalimat);
        }

        return trim($kalimat);
    }

    // HELPER WAKTU
    public static function list_hari($style=NULL)
    {
        switch ($style) {
            case 'EN':
                $list 		= ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
                break;
            
            default:
                // default ke list bulan dalam bahasa indonesia
                $list 		= ['minggu','senin','selasa','rabu','kamis','jumat','sabtu'];
                break;
        }
        return $list;
    }
    public static function list_bulan($style=NULL,$index=NULL)
    {
        switch ($style) {
            case 'EN':
                $list 		= [	
                    '01' => 'january',
                    '02' => 'february',
                    '03' => 'march',
                    '04' => 'april',
                    '05' => 'may',
                    '06' => 'juny',
                    '07' => 'july',
                    '08' => 'august',
                    '09' => 'september',
                    '10' => 'oktober',
                    '11' => 'november',
                    '12' => 'december'
                ];
                break;
            
            default:
                // default ke list bulan dalam bahasa indonesia
                $list 		= [	
                    '01' => 'januari',
                    '02' => 'februari',
                    '03' => 'maret',
                    '04' => 'april',
                    '05' => 'mei',
                    '06' => 'juni',
                    '07' => 'juli',
                    '08' => 'agustus',
                    '09' => 'september',
                    '10' => 'oktober',
                    '11' => 'november',
                    '12' => 'desember'
                ];
                break;
        }
        if (!is_null($index)) {
            return $list[$index];
        } else {
            return $list;
        }
        
    }
    public static function ubah_hari($key,$value,$hari=null)
    {
        $key = self::list_hari($key);
        $value = self::list_hari($value);
        $result = [];
        for ($i=0; $i < count($key); $i++) { 
            $data = [$key[$i] => $value[$i]];
            $result = array_merge($result,$data);
        }
        return $result[strtolower($hari)];
    }
    public static function tgl_sekarang() {
        return date('Y-m-d');
    }
    public static function ambil_hari() {
        return date('l');
    }
    public static function ambil_tgl() {
        return date('d');
    }
    public static function ambil_bulan() {
        return date('m');
    }
    public static function ambil_tahun() {
        return date('Y');
    }
    public static function jam_sekarang() {
        return date('H:i:s');
    }
    public static function bulan_indo($m=null)
    {
        if (is_null($m)) {
            $m = self::ambil_bulan();
        } else {
            if (strlen($m) == 1)
                $m = '0'.$m;
        }
        return self::list_bulan('ID',$m);
    }
    public static function hari_indo($tgl=null)
    {
        if (is_null($tgl)) {
            $tgl = self::tgl_sekarang();
        }
        $hari = date('l', strtotime($tgl));
        return self::ubah_hari('EN','ID',$hari);
    }
    public static function tgl_indo($date=null,$info=null)
    {
        if (!is_null($date) AND $date <> '0000-00-00') {
            if ($date == 'hariini') {
                $date = self::tgl_sekarang();
            }
            $tgl			= substr($date, 8,2);
            $bulan			= substr($date, 5,2);
            $tahun			= substr($date, 0,4);
            return $tgl.' '.self::bulan_indo($bulan).' '.$tahun;
        } else {
            $notif = 'Parameter tanggal tidak sesuai';
            if (!is_null($info)) {
                $notif = $info;
            }
            return $notif;
        }
    }

    // advance of time
    public static function selisihwaktu($tanggal)
    {
        $tanggal 	    = new Datetime($tanggal);
        $result = $tanggal->diff(new Datetime());
        return $result;
    }

    public static function hitung_hari($tanggal)
    {
        $selisih = self::selisihwaktu($tanggal);
        return $selisih->days;
    }
    public function usia($tanggal,$info=FALSE)
    {
        $ultah = self::selisihwaktu($tanggal);
        if ($ultah->m == 0) {
            $usia = $ultah->d;
            $notif = "hari";
        }elseif ($ultah->y == 0) {
            $usia = $ultah->m;
            $notif = "bulan";
        } else {
            $usia = $ultah->y;
            $notif = "tahun";
        }
        if ($info) {
            $usia = $usia.' '.$notif;
        }
        return $usia;
    }
}