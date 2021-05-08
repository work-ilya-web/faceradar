<?php

namespace App\Libraries;

class photosLib
{
    public function identifyFace($face, $camera_id){

        $target_url = "http://80.78.247.242:8000/hook/";
        $fname = WRITEPATH.$face;

        $cfile = new \CURLFile(realpath($fname));
        $cfile->mime = 'image/jpeg' ;

        $post = array (
            'face'      => $cfile,
            'idSource'  => $camera_id,
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $target_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");
        curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: multipart/form-data'));
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 100);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

        $result = curl_exec ($ch);

        if ($result === FALSE) {
            return  "Error sending" . $fname .  " " . curl_error($ch);
            curl_close ($ch);
        } else{
            curl_close ($ch);
            return json_decode($result);
        }
    }

    public function getYearBirth($age){
        if($age != 0 AND is_numeric($age)) {
            return date('Y') - $age;
        } else {
            return null;
        }
    }

    public function getGender($gender){
        switch ($gender) {
            case 0:
                return 1;
                break;
            case "M":
                return 1;
                break;
            case 'F':
                return 2;
                break;
            default:
                return 0;
        }
    }

}
