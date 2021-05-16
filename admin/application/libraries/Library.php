<?php
class Library
{

    public function __construct()
    {
        $this->CI = &get_instance();
    }
    public function printr($print, $exit = true)
    {
        echo '<pre>' . print_r($print, true) . '</pre>';
        if ($exit != false)
            exit(1);
    }
    function BulanToText($number)
    {
        $tampung = '';
        switch ($number) {
            case 1:
                $tampung = 'Januari';
                break;
            case 2:
                $tampung = 'Februari';
                break;
            case 3:
                $tampung = 'Maret';
                break;
            case 4:
                $tampung = 'April';
                break;
            case 5:
                $tampung = 'Mei';
                break;
            case 6:
                $tampung = 'Juni';
                break;
            case 7:
                $tampung = 'Juli';
                break;
            case 8:
                $tampung = 'Agustus';
                break;
            case 9:
                $tampung = 'September';
                break;
            case 10:
                $tampung = 'Oktober';
                break;
            case 11:
                $tampung = 'November';
                break;
            case 12:
                $tampung = 'Desember   ';
                break;
        }

        return $tampung;
    }
    public function ArrayToGet($array)
    {
        if (!is_array($array)) return false;

        // set var tampung
        $tampung = '';
        // convert array to object
        $counter = 0;
        foreach ($array as $key => $list) :

            if (strlen($list) > 0) {
                if ($counter == count($array) - 1)
                    $tampung .= "{$key}=$list";
                else
                    $tampung .= "{$key}=$list&";

                $counter++;
            }
        endforeach;

        return $tampung;
    }

    public function nowAccess()
    {
        $class = $this->CI->router->fetch_class();
        $method = $this->CI->router->fetch_method();

        return strtolower($class . '/' . $method);
    }

    function TanggalToText($Tgl, $Time = true)
    {

        $Explode = explode(' ', $Tgl);
        $ExplodeDate = explode('-', $Explode[0]);
        if ($Time == true) {
            $ExplodeTime = explode(':', $Explode[1]);
            $Jam = $ExplodeTime[0];
            $Menit = $ExplodeTime[1];
        }

        $Year = $ExplodeDate[0];
        $Month = $ExplodeDate[1];
        $Date = $ExplodeDate[2];


        $Month = $this->BulanToText($Month);
        if ($Time == false)
            return "{$Date} {$Month} {$Year}";

        return "{$Date} {$Month} {$Year} jam {$Jam}:{$Menit}";
    }

    function TimeToText($Time)
    {

        $Explode = explode(' ', $Time);
        $ExplodeDate = explode('-', $Explode[0]);
        $ExplodeTime = explode(':', $Explode[1]);

        $Year = $ExplodeDate[0];
        $Month = $ExplodeDate[1];
        $Date = $ExplodeDate[2];

        $Now = date('Y-m-d');
        $DateTime = "{$Year}-{$Month}-{$Date}";

        $JamNow = date('H');
        $MenitNow = date('i');

        $Jam = $ExplodeTime[0];
        $Menit = $ExplodeTime[1];
        $Detik = $ExplodeTime[2];

        // kalau sekarang
        if ($DateTime == $Now) {
            $MenitReal =  abs($this->timeDiff("{$Jam}:{$Menit}", "{$JamNow}:{$MenitNow}")) / 60;
            $Tanggal = intval($MenitReal) . " Menit lalu";
            if ($MenitReal > 60) {
                $MenitReal =  abs($this->timeDiff("{$Jam}:{$Menit}", "{$JamNow}:{$MenitNow}")) / 60 / 60;
                $Tanggal = intval($MenitReal) . ' Jam lalu';
            } elseif ($MenitReal <= 0)
                $Tanggal = 'Baru saja';
        }
        // kalau taun ini
        elseif (date('Y') == $Year) {
            $Tanggal = $Date . " " . $this->BulanToText($Month);
            $date1 = "2007-03-24";
            $date2 = "2009-06-26";

            $diff = abs(strtotime($DateTime) - strtotime($Now));
            $years = floor($diff / (365 * 60 * 60 * 24));
            $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
            $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
            // 1 - 7
            if ($days <= 30)
                $Tanggal = $days . " Hari lalu";
            // if(intval(date('d'))   )
        } elseif (date('Y') != $Year)
            $Tanggal = $Date . " " . $this->BulanToText($Month) . $Year;
        return $Tanggal;
    }

    function timeDiff($firstTime, $lastTime)
    {
        $firstTime = strtotime($firstTime);
        $lastTime = strtotime($lastTime);
        $timeDiff = $lastTime - $firstTime;
        return $timeDiff;
    }
    function PostFile($FullPath, $type, $FileName)
    {
        // if (function_exists('curl_file_create')) { // php 5.5+
        //     $cFile = curl_file_create($FullPath, $type, $FileName);
        // } else { // 
        //     $cFile = '@' . realpath($FullPath);
        // }

        return curl_file_create($FullPath, $type, $FileName);
    }

    public function DownloadFile($url)
    {
        set_time_limit(0);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $r = curl_exec($ch);
        curl_close($ch);
        header('Expires: 0'); // no cache
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');
        header('Cache-Control: private', false);
        header('Content-Type: application/force-download');
        header('Content-Disposition: attachment; filename="' . basename($url) . '"');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . strlen($r)); // provide file size
        header('Connection: close');
        echo $r;
    }


    function LimitWords($text, $limit)
    {
        if (str_word_count($text, 0) > $limit) {
            $words = str_word_count($text, 2);
            $pos   = array_keys($words);
            $text  = substr($text, 0, $pos[$limit]) . '...';
        }
        return $text;
    }

    public function AccessPage($Access, $ClassName)
    {
        $Class = $this->CI->router->fetch_class();
        $Method = $this->CI->router->fetch_method();

        $AccessPage = $Class . '/' . $Method;
        if ($Access != $AccessPage)
            return false;

        return $ClassName;
    }

    public function PageNow()
    {
        return $_SERVER['REQUEST_URI'];
    }
    function DateNow($tanggal)
    {
        $bulan = array(
            1 =>   'Januari',
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
            'Desember'
        );
        $pecahkan = explode('-', $tanggal);

        return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
    }

    function SessionData()
    {
        $Level = $this->CI->credential->userdata('level');
        $NamaUser = $this->CI->credential->userdata('nama_user');
        $idUser = $this->CI->credential->userdata('id');


        return [
            'level'     => $Level,
            'nama_user' => $NamaUser,
            'id'        => $idUser
        ];
    }

    function GetPosition($level)
    {
        $position = '';
        if ($level == 1)
            $position = 'Super Admin';
        elseif ($level == 2)
            $position = 'Kepala Satker';
        elseif ($level == 100)
            $position = 'Admin Surat Masuk';
        elseif ($level == 101)
            $position = 'Admin Surat Keluar';
        elseif ($level == 'KOMANDAN')
            $position = 'KOMANDAN SESKO TNI';
        elseif ($level == 'WADAN')
            $position = 'Wakil Komandan SESKO TNI';

        return $position;
    }

    function BulanRomawi($number)
    {
        $romawi = '';
        switch ($number) {
            case 1:
                $romawi = 'I';
                break;
            case 2:
                $romawi = 'II';
                break;
            case 3:
                $romawi = 'III';
                break;
            case 4:
                $romawi = 'IV';
                break;
            case 5:
                $romawi = 'V';
                break;
            case 6:
                $romawi = 'VI';
                break;
            case 7:
                $romawi = 'VII';
                break;
            case 8:
                $romawi = 'VIII';
                break;
            case 9:
                $romawi = 'IX';
                break;
            case 10:
                $romawi = 'X';
                break;
            case 11:
                $romawi = 'XI';
                break;
            case 12:
                $romawi = 'XII';
                break;
        }
        return $romawi;
    }
    // filter array key
    public function ContainsArrayKey($arr, $contains, $except = null)
    {
        if (!is_array($arr))
            return false;
        $tampung = null;

        foreach ($arr as $key => $value) :
            if (strpos($key, $contains) !== false) {
                $tampung[$key] = $arr[$key];
            }

        endforeach;
        // cek kalo except tidak null
        if ($except != null) {
            // cek kalo bukan array
            if (!is_array($except)) return false;

            foreach ($except as $key => $list) :
                unset($tampung[$list]);
            endforeach;
        }

        return $tampung;
    }

    public function FilterArrayKey($array, $keyC, $contains)
    {
        if (!is_array($array))
            return false;

        $tampung = null;
        $counter = 0;
        $index = 0;
        foreach ($array as $key => $value) :
            if (isset($value[$keyC]) and $value[$keyC] == $contains)
                $tampung[$counter++] = $array[$index];

            $index++;
        endforeach;

        return $tampung;
    }

    public function AddPrefixArrayKeys($array, $prefix)
    {
        if (!is_array($array)) return false;
        $tampung = null;
        foreach ($array as $key => $list) :
            $tampung["{$key}{$prefix}"] = $list;
        endforeach;

        return $tampung;
    }
    public function ObjectToArray($object)
    {
        if (is_object($object)) {
            $object = get_object_vars($object);
        }
        if (is_array($object)) {
            return array_map(array($this, 'objectToArray'), $object);
        } else {
            return $object;
        }
    }

    public function ArrayGrouping($array, $key)
    {
        $result = [];
        foreach ($array as $element) {
            $result[$element[$key]][] = $element;
        }

        return $result;
    }

    public function JsonEncode($array)
    {
        $prefix = '';
        echo '[';
        foreach ($array as $row) {
            echo $prefix, json_encode($row);
            $prefix = ',';
        }
        echo ']';
    }

    public function Encode($string, $count = 7)
    {
        $tampung = [];
        for ($x = 0; $x < $count; $x++) {
            if (count($tampung) == 0) $tampung[] = base64_encode($string);
            else $tampung[] = base64_encode($tampung[$x - 1]);
        }

        return str_replace('=', '', ($tampung[count($tampung) - 1]));
    }

    public function Decode($stringDecode, $count = 7)
    {
        $tampung = [];
        for ($x = 0; $x < $count; $x++) {
            if (count($tampung) == 0) $tampung[] = base64_decode($stringDecode);
            else $tampung[] = base64_decode($tampung[$x - 1]);
        }

        return str_replace('=', '', ($tampung[count($tampung) - 1]));
    }

    public static function MimeToExt($mime)
    {
        $mime_map = [
            'video/3gpp2'                                                               => '3g2',
            'video/3gp'                                                                 => '3gp',
            'video/3gpp'                                                                => '3gp',
            'application/x-compressed'                                                  => '7zip',
            'audio/x-acc'                                                               => 'aac',
            'audio/ac3'                                                                 => 'ac3',
            'application/postscript'                                                    => 'ai',
            'audio/x-aiff'                                                              => 'aif',
            'audio/aiff'                                                                => 'aif',
            'audio/x-au'                                                                => 'au',
            'video/x-msvideo'                                                           => 'avi',
            'video/msvideo'                                                             => 'avi',
            'video/avi'                                                                 => 'avi',
            'application/x-troff-msvideo'                                               => 'avi',
            'application/macbinary'                                                     => 'bin',
            'application/mac-binary'                                                    => 'bin',
            'application/x-binary'                                                      => 'bin',
            'application/x-macbinary'                                                   => 'bin',
            'image/bmp'                                                                 => 'bmp',
            'image/x-bmp'                                                               => 'bmp',
            'image/x-bitmap'                                                            => 'bmp',
            'image/x-xbitmap'                                                           => 'bmp',
            'image/x-win-bitmap'                                                        => 'bmp',
            'image/x-windows-bmp'                                                       => 'bmp',
            'image/ms-bmp'                                                              => 'bmp',
            'image/x-ms-bmp'                                                            => 'bmp',
            'application/bmp'                                                           => 'bmp',
            'application/x-bmp'                                                         => 'bmp',
            'application/x-win-bitmap'                                                  => 'bmp',
            'application/cdr'                                                           => 'cdr',
            'application/coreldraw'                                                     => 'cdr',
            'application/x-cdr'                                                         => 'cdr',
            'application/x-coreldraw'                                                   => 'cdr',
            'image/cdr'                                                                 => 'cdr',
            'image/x-cdr'                                                               => 'cdr',
            'zz-application/zz-winassoc-cdr'                                            => 'cdr',
            'application/mac-compactpro'                                                => 'cpt',
            'application/pkix-crl'                                                      => 'crl',
            'application/pkcs-crl'                                                      => 'crl',
            'application/x-x509-ca-cert'                                                => 'crt',
            'application/pkix-cert'                                                     => 'crt',
            'text/css'                                                                  => 'css',
            'text/x-comma-separated-values'                                             => 'csv',
            'text/comma-separated-values'                                               => 'csv',
            'application/vnd.msexcel'                                                   => 'csv',
            'application/x-director'                                                    => 'dcr',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'   => 'docx',
            'application/x-dvi'                                                         => 'dvi',
            'message/rfc822'                                                            => 'eml',
            'application/x-msdownload'                                                  => 'exe',
            'video/x-f4v'                                                               => 'f4v',
            'audio/x-flac'                                                              => 'flac',
            'video/x-flv'                                                               => 'flv',
            'image/gif'                                                                 => 'gif',
            'application/gpg-keys'                                                      => 'gpg',
            'application/x-gtar'                                                        => 'gtar',
            'application/x-gzip'                                                        => 'gzip',
            'application/mac-binhex40'                                                  => 'hqx',
            'application/mac-binhex'                                                    => 'hqx',
            'application/x-binhex40'                                                    => 'hqx',
            'application/x-mac-binhex40'                                                => 'hqx',
            'text/html'                                                                 => 'html',
            'image/x-icon'                                                              => 'ico',
            'image/x-ico'                                                               => 'ico',
            'image/vnd.microsoft.icon'                                                  => 'ico',
            'text/calendar'                                                             => 'ics',
            'application/java-archive'                                                  => 'jar',
            'application/x-java-application'                                            => 'jar',
            'application/x-jar'                                                         => 'jar',
            'image/jp2'                                                                 => 'jp2',
            'video/mj2'                                                                 => 'jp2',
            'image/jpx'                                                                 => 'jp2',
            'image/jpm'                                                                 => 'jp2',
            'image/jpeg'                                                                => 'jpeg',
            'image/pjpeg'                                                               => 'jpeg',
            'application/x-javascript'                                                  => 'js',
            'application/json'                                                          => 'json',
            'text/json'                                                                 => 'json',
            'application/vnd.google-earth.kml+xml'                                      => 'kml',
            'application/vnd.google-earth.kmz'                                          => 'kmz',
            'text/x-log'                                                                => 'log',
            'audio/x-m4a'                                                               => 'm4a',
            'application/vnd.mpegurl'                                                   => 'm4u',
            'audio/midi'                                                                => 'mid',
            'application/vnd.mif'                                                       => 'mif',
            'video/quicktime'                                                           => 'mov',
            'video/x-sgi-movie'                                                         => 'movie',
            'audio/mpeg'                                                                => 'mp3',
            'audio/mpg'                                                                 => 'mp3',
            'audio/mpeg3'                                                               => 'mp3',
            'audio/mp3'                                                                 => 'mp3',
            'video/mp4'                                                                 => 'mp4',
            'video/mpeg'                                                                => 'mpeg',
            'application/oda'                                                           => 'oda',
            'audio/ogg'                                                                 => 'ogg',
            'video/ogg'                                                                 => 'ogg',
            'application/ogg'                                                           => 'ogg',
            'application/x-pkcs10'                                                      => 'p10',
            'application/pkcs10'                                                        => 'p10',
            'application/x-pkcs12'                                                      => 'p12',
            'application/x-pkcs7-signature'                                             => 'p7a',
            'application/pkcs7-mime'                                                    => 'p7c',
            'application/x-pkcs7-mime'                                                  => 'p7c',
            'application/x-pkcs7-certreqresp'                                           => 'p7r',
            'application/pkcs7-signature'                                               => 'p7s',
            'application/pdf'                                                           => 'pdf',
            'application/octet-stream'                                                  => 'pdf',
            'application/x-x509-user-cert'                                              => 'pem',
            'application/x-pem-file'                                                    => 'pem',
            'application/pgp'                                                           => 'pgp',
            'application/x-httpd-php'                                                   => 'php',
            'application/php'                                                           => 'php',
            'application/x-php'                                                         => 'php',
            'text/php'                                                                  => 'php',
            'text/x-php'                                                                => 'php',
            'application/x-httpd-php-source'                                            => 'php',
            'image/png'                                                                 => 'png',
            'image/x-png'                                                               => 'png',
            'application/powerpoint'                                                    => 'ppt',
            'application/vnd.ms-powerpoint'                                             => 'ppt',
            'application/vnd.ms-office'                                                 => 'ppt',
            'application/msword'                                                        => 'doc',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
            'application/x-photoshop'                                                   => 'psd',
            'image/vnd.adobe.photoshop'                                                 => 'psd',
            'audio/x-realaudio'                                                         => 'ra',
            'audio/x-pn-realaudio'                                                      => 'ram',
            'application/x-rar'                                                         => 'rar',
            'application/rar'                                                           => 'rar',
            'application/x-rar-compressed'                                              => 'rar',
            'audio/x-pn-realaudio-plugin'                                               => 'rpm',
            'application/x-pkcs7'                                                       => 'rsa',
            'text/rtf'                                                                  => 'rtf',
            'text/richtext'                                                             => 'rtx',
            'video/vnd.rn-realvideo'                                                    => 'rv',
            'application/x-stuffit'                                                     => 'sit',
            'application/smil'                                                          => 'smil',
            'text/srt'                                                                  => 'srt',
            'image/svg+xml'                                                             => 'svg',
            'application/x-shockwave-flash'                                             => 'swf',
            'application/x-tar'                                                         => 'tar',
            'application/x-gzip-compressed'                                             => 'tgz',
            'image/tiff'                                                                => 'tiff',
            'text/plain'                                                                => 'txt',
            'text/x-vcard'                                                              => 'vcf',
            'application/videolan'                                                      => 'vlc',
            'text/vtt'                                                                  => 'vtt',
            'audio/x-wav'                                                               => 'wav',
            'audio/wave'                                                                => 'wav',
            'audio/wav'                                                                 => 'wav',
            'application/wbxml'                                                         => 'wbxml',
            'video/webm'                                                                => 'webm',
            'audio/x-ms-wma'                                                            => 'wma',
            'application/wmlc'                                                          => 'wmlc',
            'video/x-ms-wmv'                                                            => 'wmv',
            'video/x-ms-asf'                                                            => 'wmv',
            'application/xhtml+xml'                                                     => 'xhtml',
            'application/excel'                                                         => 'xl',
            'application/msexcel'                                                       => 'xls',
            'application/x-msexcel'                                                     => 'xls',
            'application/x-ms-excel'                                                    => 'xls',
            'application/x-excel'                                                       => 'xls',
            'application/x-dos_ms_excel'                                                => 'xls',
            'application/xls'                                                           => 'xls',
            'application/x-xls'                                                         => 'xls',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'         => 'xlsx',
            'application/vnd.ms-excel'                                                  => 'xlsx',
            'application/xml'                                                           => 'xml',
            'text/xml'                                                                  => 'xml',
            'text/xsl'                                                                  => 'xsl',
            'application/xspf+xml'                                                      => 'xspf',
            'application/x-compress'                                                    => 'z',
            'application/x-zip'                                                         => 'zip',
            'application/zip'                                                           => 'zip',
            'application/x-zip-compressed'                                              => 'zip',
            'application/s-compressed'                                                  => 'zip',
            'multipart/x-zip'                                                           => 'zip',
            'text/x-scriptzsh'                                                          => 'zsh',
        ];

        return isset($mime_map[$mime]) === true ? $mime_map[$mime] : false;
    }
}
