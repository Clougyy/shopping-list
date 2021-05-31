<?php

if(isset($_GET["get_lists"]) && !is_null($_GET["get_lists"])){

    $liste = array();
    if ($file = fopen("liste.txt", "r")) {
        while(!feof($file)) {
            $line = fgets($file);
            $it = htmlspecialchars(str_replace(["\n","\r"],"",$line));
                if ($it != "")
                    array_push($liste,$it);
        }
        fclose($file);
    }
    
    $archive = array();
    if ($file = fopen("archive.txt", "r")) {
        while(!feof($file)) {
            $line = fgets($file);
            $it = htmlspecialchars(str_replace(["\n","\r"],"",$line));
                if ($it != "")
                    array_push($archive,$it);
        }
        fclose($file);
    }

    $l = array($liste, $archive);
    $j = json_encode($l);
    echo $j;
    
}else if(isset($_GET["add"]) && !is_null($_GET["add"])){

    $fp = fopen('liste.txt', 'a+');
    fwrite($fp, "\n".$_GET["add"]);
    fclose($fp);
    
}else if(isset($_GET["switch"]) && !is_null($_GET["switch"])){

    $item=$_GET["item"];
    if($_GET["switch"] == "reset"){
            $fp = fopen('liste.txt', 'a+');
            fwrite($fp, "\n".$item);
            fclose($fp);
            
            $archive = array();
            if ($file = fopen("archive.txt", "r")) {
                while(!feof($file)) {
                    $line = fgets($file);
                    $a = htmlspecialchars(str_replace(["\n","\r"],"",$line));
                    if($a != $item)
                       array_push($archive,$a);
                }
                fclose($file);
            }
            
            $i=0;
            $file = fopen("archive.txt", "w");
            foreach ($archive as $value) {
                $i=$i+1;
                if($i != count($archive))
                    fwrite($file,htmlspecialchars(str_replace(["\n","\r"],"",$value))."\n");
                else
                    fwrite($file,htmlspecialchars(str_replace(["\n","\r"],"",$value)));
            }
            fclose($file);

    }else{
            
            $fp = fopen('archive.txt', 'a+');
            fwrite($fp, "\n".$item);
            fclose($fp);
            
            $archive = array();
            if ($file = fopen("liste.txt", "r")) {
                while(!feof($file)) {
                    $line = fgets($file);
                    $a = htmlspecialchars(str_replace(["\n","\r"],"",$line));
                    if($a != $item)
                       array_push($archive,$a);
                }
                fclose($file);
            }
            
            $i=0;
            $file = fopen("liste.txt", "w");
            foreach ($archive as $value) {
                $i=$i+1;
                if($i != count($archive))
                    fwrite($file,htmlspecialchars(str_replace(["\n","\r"],"",$value))."\n");
                else
                    fwrite($file,htmlspecialchars(str_replace(["\n","\r"],"",$value)));
            }
            fclose($file);
        
    }

    
}else if(isset($_GET["del"]) && !is_null($_GET["del"])){
    $fp = fopen('archive.txt', 'w');
    fwrite($fp, "");
    fclose($fp);
}


?>