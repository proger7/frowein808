<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("../../includes/general.inc.php");

// $token = $DB->select("
//     SELECT * FROM `linkedin_tokens`
//     ORDER BY `id` DESC
//     LIMIT 1
// ");

// var_dump("
//     SELECT * FROM `linkedin_tokens`
//     ORDER BY `id` DESC
//     LIMIT 1
// ");
// var_dump(empty($token));
// die();

$update_token = function($token) use ($DB) {
    $request_data = http_build_query([
        'grant_type' => 'refresh_token',
        'refresh_token' => $token["refresh_token"],
        'client_id' => '78tvqu6wo3ng46',
        'client_secret' => 'GPFB7LNlgvO3FXs0'
    ]);

    $request_opts = ['http' => [
        'method'  => 'POST',
        'header'  => 'Content-Type: application/x-www-form-urlencoded',
        'content' => $request_data
    ]];
    
    $request_context = stream_context_create($request_opts);
    
    $response = file_get_contents("https://www.linkedin.com/oauth/v2/accessToken", false, $request_context);
    if(empty($response)){
        echo "Wrong response while requesting new token";
        die();
    }
    
    $response_arr = json_decode($response, true);
    
    // var_dump($response_arr);
    // die();
    
    if(empty($response_arr) || !is_array($response_arr) ||
    empty($response_arr["access_token"]) || empty($response_arr["expires_in"]) ||
    empty($response_arr["refresh_token"]) || empty($response_arr["refresh_token_expires_in"])){
        echo "Wrong response while requesting new token, wrong parameters all not all parameters present.";
        die();
    }
    
    $DB->query("
        INSERT INTO `linkedin_tokens`
        (
        	access_token,
        	access_token_expires_in,
        	access_token_will_expired_at,
        	refresh_token,
        	refresh_token_expires_in,
        	refresh_token_will_expired_at
        )
        VALUES
        (
            '" . $response_arr["access_token"] . "',
            '" . $response_arr["expires_in"] . "',
            '" . ($response_arr['expires_in'] + time()) . "',
            '" . $response_arr["refresh_token"] . "',
            '" . $response_arr["refresh_token_expires_in"] . "',
            '" . ($response_arr['refresh_token_expires_in'] + time()) . "'
        )
    ");
    // $response_arr["access_token"], $response_arr["expires_in"], ($response_arr['expires_in'] + time()),
    // $response_arr["refresh_token"], $response_arr["refresh_token_expires_in"], ($response_arr['refresh_token_expires_in'] + time()));
    
    // var_dump($response_arr);
    // die();
    
    $new_inserted_token = $DB->select("
        SELECT * FROM `linkedin_tokens`
        WHERE `id` = " . $DB->lastindex());
    if(!empty($new_inserted_token))
        $new_inserted_token = $new_inserted_token[0];
    
    return $new_inserted_token;
};

$token = $DB->select("
    SELECT * FROM `linkedin_tokens`
    ORDER BY `id` DESC
    LIMIT 1
");
if(!empty($token))
    $token = $token[0];
    
// var_dump($token);
// die();

// if(empty($token) || !is_array($token) || empty($token["access_token"]) || empty($token["access_token_expires_in"]) ||
// empty($token["access_token_will_expired_at"]) || empty($token["refresh_token"]) || empty($token["refresh_token_expires_in"]) ||
// empty($token["refresh_token_will_expired_at"])){
//     echo "Wrong token";
//     die();
// }

// var_dump(222);
// die();

// echo "<pre>";
// var_dump($token["access_token_will_expired_at"] - time());
// echo "</pre>";
// die();

// if(($token["access_token_will_expired_at"] - time()) < 432000)
if(($token["access_token_will_expired_at"] - time()) < 432000)
    $token = $update_token($token);

// echo "<pre>";
// var_dump($token);
// echo "</pre>";

// echo 1;
// die();

$posts_to_add = [];
$exclude_elements_ids = [];
// $exclude_elements_ids = [6909768982346526720, 6904762247692763136, 6906488616860598272];

// echo 444;
// die();

$posts_ids = $DB->select("SELECT DISTINCT `post_id` FROM linkedin_posts");
$posts_ids = !empty($posts_ids) ? array_column($posts_ids, "post_id") : [];

// echo 444;
// die();

$compose_api_link = function($link){
    return "https://api.linkedin.com" . $link;
};

// echo 22;
// die();

$is_next_in_links = function($links){
    if(!is_array($links) || empty($links))
        return false;
        
    foreach($links as $link)
        if(!empty($link["rel"]) && $link["rel"] == "next" && !empty($link["href"]))
            return $link["href"];
            
    return false;
};

// echo 22;
// die();

$proccess_elements = function($elements) use ($DB, $posts_ids, &$posts_to_add, $exclude_elements_ids) {
    foreach($elements as $element){
        
        if(in_array($element["id"], $exclude_elements_ids))
            continue;
            
        if(in_array($element["id"], $posts_ids))
            return false;
        
        $content_entities = array_shift($element["content"]["contentEntities"]);
            
        $post = [
            // "title" => !empty($content_entities["title"]) ? $content_entities["title"],
            "text" => $element["text"]["text"],
            "post_id" => $element["id"],
            "post_created_at" => floor($element["created"]["time"] / 1000),
        ];
        
        if(!empty($content_entities["title"]))
            $post["title"] = $content_entities["title"];
        
        if(!empty($content_entities["thumbnails"]) &&
        is_array($content_entities["thumbnails"]) &&
        count($content_entities["thumbnails"]) > 0){
            $thumbnail = array_shift($content_entities["thumbnails"]);
            if(!empty($thumbnail) && is_array($thumbnail) && !empty($thumbnail["resolvedUrl"])){
                $post["img"] = $thumbnail["resolvedUrl"];
            }
        }
        
        if(!empty($element["lastModified"]) && is_array($element["lastModified"])
        && !empty($element["lastModified"]["time"])){
            $post["post_modified_at"] = $thumbnail["lastModified"]["time"];
        }
        
        $posts_to_add[] = $post;
    }
};

// echo 44;
// die();

// $request_opts = [
//     'http' => [
//         'method' => "GET",
//         'header' => "Authorization: Bearer AQXwmOC54fHmIhPJptiIft9uxvZQnlG3en6j9NgP2qDBJVm20RvSPs6z6dnSytFdb6j19ubRdb6KnfHGfk0AK1xxhmzJWyV1hC1GnhMJbbhGXyo3CYuJaf-j3me0svOphXcDwZx5x6OgvBqPvxXVKKEUhApt9kV26RQz5ZLrcfJYDlNUtVs2HE1KDsTJpLBB8UlrKIkKzrSPm33RBUObhHL515qzPsefLWA4GgGsW0WDrmwrvKPaMRkgx5z6u7Cx-_HGEuJRgiAfD2BeRlx4eKLXYIWO33eyZh9RJUxCUZ0oTP_bgYrgCP5rGUjTSFzgZ36frsKwFy2ifsA9v5t0F8IX5iW9fw\r\n"
//     ]
// ];


$request_opts = [
    'http' => [
        'method' => "GET",
        'header' => "Authorization: Bearer " . $token["access_token"] . "\r\n"
    ]
];

// echo 111;
// die();

$request_context = stream_context_create($request_opts);

$loop_status = true;
$elements_per_request = 50;
$first_loop = true;
$response_arr = [];
do{
    if($first_loop){
        // $request_link = $compose_api_link('/v2/shares?q=owners&owners=urn:li:organization:89222491&count=' . $elements_per_request . '&start=0&sortBy=CREATED');
        
        $request_link = $compose_api_link('/v2/shares?q=owners&owners=urn:li:organization:2876431&count=' . $elements_per_request . '&start=0&sortBy=CREATED');
    }else{
        if(empty($response_arr["paging"]) || empty($response_arr["paging"]["links"]) ||
        !$next_link = $is_next_in_links($response_arr["paging"]["links"]))
            break;
        
        $request_link = $compose_api_link($next_link);
    }
    
    $response = file_get_contents($request_link, false, $request_context);
    
    // echo var_dump($response);
    // die();
    
    $response_arr = json_decode($response, true);
    
    if(empty($response_arr["elements"]) || !is_array($response_arr["elements"])
    || count($response_arr["elements"]) < 0){
        break;
    }

    $res = $proccess_elements($response_arr["elements"]);
    
    if($res === false)
        break;
        
    if($first_loop == true)
        $first_loop = false;
        
}while($loop_status);


// echo "<pre>";
// var_dump($posts_to_add);
// echo "</pre>";

// echo json_encode($posts_to_add);
// // echo 111;
// die();

if(!empty($posts_to_add)){
    // $DBS->query("TRUNCATE TABLE `linkedin_posts`");
    
    // var_dump($posts_to_add);
    // die();
    
    $posts_to_add = array_reverse($posts_to_add);
    foreach($posts_to_add as $post){
        $columns = array_keys($post);
        $columns = array_map(function($column){
            return "`" . $column . "`";
        }, $columns);
        
        // var_dump($columns);
        // die();
        
        $values = array_values($post);
        
        // var_dump($values);
        // die();
        
        $values = array_map(function($column){
            return "'" . addslashes($column) . "'";
        }, $values);
        
        
        // var_dump(222);
        // var_dump($values);
        // die();
        
        
        // var_dump($DB->parse("
        //     INSERT INTO `linkedin_posts`
        //     (" . implode(",", $columns) . ")
        //     VALUES (?a)
        // ", $values));
        // die();
        
        $DB->query("
            INSERT INTO `linkedin_posts`
            (" . implode(",", $columns) . ")
            VALUES (" . implode(",", $values) . ")
        ");
    }
}


