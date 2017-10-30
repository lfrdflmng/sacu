<?php
/**
 * Created by PhpStorm.
 * User: Alfredo
 * Date: 4/10/2017
 * Time: 4:14 PM
 */

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Input;

class ImagenController {

    /**
     * Sube la imagen según el campo de un item
     *
     * @param $item
     * @param $nombre_campo
     * @param string $tamanos
     * @return bool|mixed|string
     */
    public static function subirImagenParaItem($item, $nombre_campo, $tamanos = 'lms') {
        $ha_cambiado = Input::get($nombre_campo . '_upload_modificado');
        $nombre = Input::get($nombre_campo);

        //cuando se ha modificado y se envía una imagen
        if ($ha_cambiado && Input::hasFile($nombre_campo . '_upload')) {

            //imagen enviada
            $archivo = Input::file($nombre_campo . '_upload');

            if ($archivo->isValid()) {
                //extrae la extensión del archivo (jpg, png)
                $extension = strtolower($archivo->getClientOriginalExtension());

                //ruta donde se guardará el archivo
                $ruta_destino = config('app.uploads_img_dir');

                //nombre que se le dará al archivo
                $nombre_archivo = uniqid() . '.' . $extension; //$file->getClientOriginalName();

                //si el nombre ya existe (no debería suceder), se intenta hasta que consiga uno que no exista
                $esc = 0;
                while (file_exists($ruta_destino . '/' . $nombre_archivo)) {
                    usleep(100);
                    $nombre_archivo = uniqid() . '.' . $extension;
                    $esc++;
                    if ($esc >= 30) return false; // !!!
                }

                //copia la imagen original al destino
                $copiado = $archivo->move($ruta_destino, $nombre_archivo);

                if ($copiado) {
                    if (strpos($tamanos, 's') !== false) {
                        self::redimensionar($ruta_destino . '/' . $nombre_archivo, null, 256, 256, true, $ruta_destino . '/s/' . $nombre_archivo, false);
                    }
                    if (strpos($tamanos, 'm') !== false) {
                        self::redimensionar($ruta_destino . '/' . $nombre_archivo, null, 512, 512, true, $ruta_destino . '/m/' . $nombre_archivo, false);
                    }
                    if (strpos($tamanos, 'l') !== false) {
                        self::redimensionar($ruta_destino . '/' . $nombre_archivo, null, 1024, 1024, true, $ruta_destino . '/l/' . $nombre_archivo, false);
                    }

                    //si se pasa el objeto, se actualiza el campo correspondiente
                    if ($item !== null) {
                        $item->$nombre_campo = $nombre_archivo;
                        $item->save();
                    }

                    return $nombre_archivo;
                }
            }
        }

        //cuando se ha cambiado pero no se ha enviado una imagen (fue borrada)
        elseif ($ha_cambiado) {
            if ($item !== null) {
                $item->$nombre_campo = '';
                $item->save();
            }
            return '';
        }

        //cuando no se ha modificado, se retorna el mismo nombre ya asignado
        elseif ($nombre) {
            return $nombre;
        }

        return false;
    }


    /**
     * Procedimiento para redimensionar una imagen y guardarla
     *
     * @param $file
     * @param null $string
     * @param int $width
     * @param int $height
     * @param bool $proportional
     * @param string $output
     * @param bool $delete_original
     * @param bool $use_linux_commands
     * @param int $quality
     * @return bool
     */
    public static function redimensionar($file, $string = null, $width = 0, $height = 0, $proportional = false, $output = 'file', $delete_original = true, $use_linux_commands = false, $quality = 100) {
        if ( $height <= 0 && $width <= 0 ) return false;
        if ( $file === null && $string === null ) return false;

        # Setting defaults and meta
        $info                         = $file !== null ? getimagesize($file) : getimagesizefromstring($string);
        $image                        = '';
        $final_width                  = 0;
        $final_height                 = 0;
        list($width_old, $height_old) = $info;
        $cropHeight = $cropWidth = 0;

        if ($proportional) {
            if      ($width  == 0)  $factor = $height/$height_old;
            elseif  ($height == 0)  $factor = $width/$width_old;
            else                    $factor = min( $width / $width_old, $height / $height_old );

            $final_width  = round( $width_old * $factor );
            $final_height = round( $height_old * $factor );
        }
        else {
            $final_width = ( $width <= 0 ) ? $width_old : $width;
            $final_height = ( $height <= 0 ) ? $height_old : $height;
            $widthX = $width_old / $width;
            $heightX = $height_old / $height;

            $x = min($widthX, $heightX);
            $cropWidth = ($width_old - $width * $x) / 2;
            $cropHeight = ($height_old - $height * $x) / 2;
        }

        switch ( $info[2] ) {
            case IMAGETYPE_JPEG:  $file !== null ? $image = imagecreatefromjpeg($file) : $image = imagecreatefromstring($string);  break;
            case IMAGETYPE_GIF:   $file !== null ? $image = imagecreatefromgif($file)  : $image = imagecreatefromstring($string);  break;
            case IMAGETYPE_PNG:   $file !== null ? $image = imagecreatefrompng($file)  : $image = imagecreatefromstring($string);  break;
            default: return false;
        }

        $image_resized = imagecreatetruecolor($final_width, $final_height);

        if ( ($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG) ) {
            $transparency = imagecolortransparent($image);
            $palletsize = imagecolorstotal($image);

            if ($transparency >= 0 && $transparency < $palletsize) {
                $transparent_color  = imagecolorsforindex($image, $transparency);
                $transparency       = imagecolorallocate($image_resized, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
                imagefill($image_resized, 0, 0, $transparency);
                imagecolortransparent($image_resized, $transparency);
            }
            elseif ($info[2] == IMAGETYPE_PNG) {
                imagealphablending($image_resized, false);
                $color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);
                imagefill($image_resized, 0, 0, $color);
                imagesavealpha($image_resized, true);
            }
        }

        imagecopyresampled($image_resized, $image, 0, 0, $cropWidth, $cropHeight, $final_width, $final_height, $width_old - 2 * $cropWidth, $height_old - 2 * $cropHeight);

        if ($delete_original) {
            if ($use_linux_commands) exec('rm '.$file);
            else @unlink($file);
        }

        switch (strtolower($output)) {
            case 'browser':
                $mime = image_type_to_mime_type($info[2]);
                header("Content-type: $mime");
                $output = NULL;
                break;

            case 'file':
                $output = $file;
                break;

            case 'return':
                return $image_resized;
                break;

            default:
                break;
        }

        switch ( $info[2] ) {
            case IMAGETYPE_GIF:   imagegif($image_resized, $output);    break;
            case IMAGETYPE_JPEG:  imagejpeg($image_resized, $output, $quality);   break;
            case IMAGETYPE_PNG:
                $quality = 9 - (int)((0.9*$quality)/10.0);
                imagepng($image_resized, $output, $quality);
                break;
            default: return false;
        }

        return true;
    }

}