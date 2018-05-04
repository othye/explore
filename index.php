<?php
    require 'vendor/autoload.php';
    require 'asset/php/function.php';

    // rendu du template
    $loader = new Twig_Loader_Filesystem(__DIR__ . '/templates');
    $twig = new Twig_Environment($loader, [
        'cache' => false,   
        'debug' => true,

    ]);
    $twig->addExtension(new Twig_Extension_Debug());


   

    if(isset($_GET['data'])) {
    
        $data = $_GET['data'];
        $chemin = explode('/', $data);
        //$lien = reset($chemin);

        if($chemin[0] === 'My_Documents' && !strpos($data, '..') && file_exists($data)) {
            
            // changement de vue
            if (isset($_GET['view'])) {

                $template = 'simple'; 
    
            } else {
    
                $template = 'home';
            }
    
            echo $twig->render( $template.'.html', array(

                'mydata'    => displayData($data),
                'getMylink' => getMylink($data),
                'folder'    => $data,
                'racine'    => $chemin[0],
                'chemn' => $chemin
                
                
                
            ));
            
        } else {

            //potentielle attaque
            echo $twig->render('error.html', array(

            ));


        }

    } else {
        // changement de vue
        if (isset($_GET['view'])) {

            
            $template = 'simple'; 

        } else {

            $template = 'home';
        }

        echo $twig->render($template.'.html', array(

            'mydata'    => displayData('My_Documents'),
            'getMylink' => getMylink('My_Documents'),
            
            
        ));
        
    }

   


?>