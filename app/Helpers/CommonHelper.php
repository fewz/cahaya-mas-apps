<?php

namespace App\Helpers;

class CommonHelper
{

    public static function redirectURL($url)
    {
        echo '<script>window.location.href = "' . $url . '"</script>';
    }

    public static function showAlert($judul, $isi, $tipe = "info", $url = "")
    {
        //tipe-> error, successs,info
        echo '<div style="display:none"></div>';
        echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>';
        if ($url == "back") {
            //SHOW MODAL & BACK 1 PAGE
            echo '
            <script>
                swal("' . $judul . '", "' . $isi . '", "' . $tipe . '").then((value)=>{
                    window.location.href = document.referrer;
                });
            </script>';
        } else if ($url != "") {
            //SHOW MODAL & GO TO URL
            echo '
            <script>
                swal("' . $judul . '", "' . $isi . '", "' . $tipe . '").then((value)=>{
                    window.location.href = "' . $url . '";
                });
            </script>';
        } else {
            //DEFAULT HANYA SHOW MODAL
            echo '
            <script>
                swal("' . $judul . '", "' . $isi . '", "' . $tipe . '");
            </script>';
        }
    }
}
