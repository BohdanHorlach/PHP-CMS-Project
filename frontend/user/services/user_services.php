<?php
    function updateProfile(int $user_id, string $name, string $email) {
        $url = "http://localhost/Projects/PHP-CMS-Project/backend/users/user_api.php";
        
        $data = [
            'user_id' => $user_id,
            'name' => $name,
            'email' => $email
        ];
    
        $options = [
            'http' => [
                'header'  => "Content-Type: application/json",
                'method'  => 'POST',
                'content' => json_encode($data)
            ]
        ];
    
        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        
        return json_decode($response, true);
    }
?>