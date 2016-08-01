<?php

function echoLine($GET_attr, $text){
    if (isset($_GET[$GET_attr])){
        if ($_GET[$GET_attr] == 1){
            echo "<h3>$text</h3>";
        }
    }   
}



                
                
                
