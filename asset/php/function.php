<?php

    // récupérer les données 

    function displayData($folder) { 

    $mydata = [];
    $directories = array_diff(scandir($folder), ['.', '..']);

    foreach ($directories as $name) {

        $path = $folder.DIRECTORY_SEPARATOR.$name;

        // dossier ou fichier
        $kind = is_dir($path);
        $date = filemtime($folder.DIRECTORY_SEPARATOR.$name);
        $modificationDate = date ("F d Y - H:i:s", $date);
        $userId = getmyuid();
        $userInfo = posix_getpwuid($userId);
        $user = $userInfo['name'];
        $size = filesize($path). ' bytes';
        //$permission = fileperms($folder.DIRECTORY_SEPARATOR.$name);
        
        $fileExt = null;
        $fileType = null;

        if($kind == false) {

            $path = $folder.DIRECTORY_SEPARATOR.$name;  //pour créer le chemin des fichier
            
            //$filetype =  mime_content_type ($path);     //definir le type des fichiers
            
            $ext = explode('.', $path);     //récupéré l'extention de fichier.
            $fileExt = end($ext);
            $fileType = strtoupper($fileExt); // Retourne la chaîne en majuscule. 

            // attribuer les icones par types de fichier 
            if($fileExt === 'png' || $fileExt === 'jpeg' || $fileExt === 'jpg' || $fileExt === 'gif' || $fileExt === 'svg') {
                $fileExt = 'picture';
            } else if($fileExt === 'mp3' || $fileExt === 'wav') {
                $fileExt = 'music';
            } else if($fileExt === 'txt') {
                $fileExt = 'text';
            }else if($fileExt === 'zip' || $fileExt === 'rar') {
                $fileExt = 'compressed';
            } else if($fileExt === 'php' || $fileExt === 'html' || $fileExt === 'css' || $fileExt === 'js') {
                $fileExt = 'code';
            } else {
                $fileExt = 'file';
            }

        }
        
    

        // la taille des fichier:
        if($size >= 1048576){
            $size = round($size/1048576,1).' MB';
        }else{
            if ($size >= 1024){
                $size = round($size/1024,1).' KB';
            }
        }


        array_push($mydata, [

            'filename' => $name,
            'path' => $path,
            'type' => $kind,
            'filetype' => $fileType ,
            'date' => $modificationDate,
            'user' => $user,
            'size' => $size,
            'icon' => $fileExt,
            //'perm' => $permission,

        ]);
        
    }

    return $mydata;

    }

    // fonction pour recupérer le lien de mes dossiers
    function getMylink(string $path): array {
        $exploded   = explode('/', $path);
        $getMylink = [];
        $step       = '';
        foreach($exploded as $explode) {
            $step .= $explode.'/';
            array_push($getMylink, ['name' => $explode, 'path' => substr($step, 0, -1)]);
        }
        return $getMylink;
    }

?>