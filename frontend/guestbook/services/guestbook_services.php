<?php

    function getGuestbookList(bool $is_from_blocked = false){
        $query = http_build_query(['is_blocked' => $is_from_blocked]);
        $json_response = file_get_contents("http://localhost/Projects/PHP-CMS-Project/backend/guestbook/guestbook.php?$query");
        $result = json_decode($json_response, true);
        
        if($result === null){
            $result = [];
        }
    
        return $result;
    }

?>