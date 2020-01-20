<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 12/05/2018
 * Time: 14:48
 */

namespace Base\Controller;


class BaseFunctions
{
    public function __construct()
    {
        
    }

    public function formatarTexto($string,$tirarAcento = 0){
        $especiais = array("\"","\\","'");
        $string = (trim(str_replace($especiais,'',$string)));

        if($tirarAcento){
            $string = preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/","/(ç)/","/(Ç)/"),explode(" ","a A e E i I o O u U n N c C"),$string);
        }

        return $string;
    }

    public function moedaToFloat($value){
        return str_replace(',','.',str_replace('.','',$value))*1;
    }

    public function floatToMoeda($value){
        return  number_format($value, 2, ',', '.');
    }

    function toCamelCase($string, $capitalizeFirstCharacter = false)
    {

        $str = str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));

        if (!$capitalizeFirstCharacter) {
            $str[0] = strtolower($str[0]);
        }

        return $str;
    }

    function strToFriendlyUrl($str){
        $str = mb_strtolower($str);
        $i=1;
        $arr_a = array('à','á','â','ã','ä','å','æ','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ø','ù','ú','û','ý','ý','ÿ');
        $arr_b = array('a','a','a','a','a','a','æ','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','o','u','u','u','y','y','y');

        $str = str_replace($arr_a, $arr_b,$str);

        $str = strtr($str, utf8_decode('àáâãäåæçèéêëìíîïñòóôõöøùúûýýÿ'), 'aaaaaaaceeeeiiiinoooooouuuyyy');
        $str = preg_replace("/([^a-z0-9])/",'-',utf8_encode($str));
        while($i>0) $str = str_replace('--','-',$str,$i);
        if (substr($str, -1) == '-') $str = substr($str, 0, -1);
        return $str;
    }

    function camel2dashed($str) {
        return strtolower(preg_replace('/([^A-Z-])([A-Z])/', '$1-$2', $str));
    }

    public function getLogin($redirect = true){

        $session = (array) $_SESSION['Person'];
        /**
         * @var User $user
         */
        foreach($session as $v){
            if(isset($v['storage']))
                $login = $v['storage'];
        }

        if($login) {
            $db_login = $this->getEm()->getRepository('Register\Entity\Person')->findOneById($login->getId());

            return $db_login;
        }else{
            if($redirect){
                return $this->redirect()->toRoute('not-have-permission');
            }else {
                return false;
            }
        }
    }

    function asortbyindex ($sortarray, $index) {
        $lastindex = count ($sortarray) - 1;
        for ($subindex = 0; $subindex < $lastindex; $subindex++) {
            $lastiteration = $lastindex - $subindex;
            for ($iteration = 0; $iteration < $lastiteration;    $iteration++) {
                $nextchar = 0;
                if (comesafter ($sortarray[$iteration][$index], $sortarray[$iteration + 1][$index])) {
                    $temp = $sortarray[$iteration];
                    $sortarray[$iteration] = $sortarray[$iteration + 1];
                    $sortarray[$iteration + 1] = $temp;
                }
            }
        }
        return ($sortarray);
    }

    public function smartCopy($source, $dest, $options=array('folderPermission'=>0777,'filePermission'=>0777))
    {
        $result=false;

        if (is_file($source)) {
            if ($dest[strlen($dest)-1]=='/') {
                if (!file_exists($dest)) {
                    cmfcDirectory::makeAll($dest,$options['folderPermission'],true);
                }
                $__dest=$dest."/".basename($source);
            } else {
                $__dest=$dest;
            }
            $result=copy($source, $__dest);
            chmod($__dest,$options['filePermission']);

        } elseif(is_dir($source)) {
            if ($dest[strlen($dest)-1]=='/') {
                if ($source[strlen($source)-1]=='/') {
                    //Copy only contents
                } else {
                    //Change parent itself and its contents
                    $dest=$dest.basename($source);
                    @mkdir($dest);
                    chmod($dest,$options['filePermission']);
                }
            } else {
                if ($source[strlen($source)-1]=='/') {
                    //Copy parent directory with new name and all its content
                    @mkdir($dest,$options['folderPermission']);
                    chmod($dest,$options['filePermission']);
                } else {
                    //Copy parent directory with new name and all its content
                    @mkdir($dest,$options['folderPermission']);
                    chmod($dest,$options['filePermission']);
                }
            }

            $dirHandle=opendir($source);
            while($file=readdir($dirHandle))
            {
                if($file!="." && $file!="..")
                {
                    if(!is_dir($source."/".$file)) {
                        $__dest=$dest."/".$file;
                    } else {
                        $__dest=$dest."/".$file;
                    }
                    //echo "$source/$file ||| $__dest<br />";
                    $result=smartCopy($source."/".$file, $__dest, $options);
                }
            }
            closedir($dirHandle);

        } else {
            $result=false;
        }
        return $result;
    }
}
