<?php 

// Common Start

    function alert($data,$color="danger"){
        return "<p class='alert alert-$color'>$data</p>";
    }

    function runQuery($sql){
        if(mysqli_query(conn(),$sql)){
            return true;
        }
        else{
            die("Query Fail : ".mysqli_error());
        }
    }

    function fetch($sql){
        $query = mysqli_query(conn(),$sql);
        $row = mysqli_fetch_assoc($query);
        return $row;
    }

    function fetchAll($sql){
        $query = mysqli_query(conn(),$sql);
        $rows = [];
        while($row = mysqli_fetch_assoc($query)){
            array_push($rows,$row);
        }
        return $rows;
    }

    function redirect($l){
        header("location:$l");
    }

    function linkTo($l){
        echo "<script>location.href='$l'</script>";
    }

    function showTime($timestamp,$format = "d-m-y"){
        return date($format,strtotime($timestamp));
    }

    function countTotal($table,$condition=1){
        $sql = "SELECT COUNT(id) FROM $table WHERE $condition";
        $total = fetch($sql);
        return $total['COUNT(id)'];
    }

    function short($str,$length="100"){
        return substr($str,0,$length)."....";
    }

    function textFilter($text){
        $text = trim($text);
        $text = htmlentities($text,ENT_QUOTES);   //Quote <> ဖျက်တာ
        $text = stripcslashes($text);             //  //\\ ဖျက်တာ
        return $text;
    }

// Common End


// Auth Start 

function register(){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    if($password == $cpassword){
        $spass = md5($password);
        $spass = sha1($spass);
        $spass = password_hash($spass,PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (name,email,password) VALUES ('$name','$email','$spass')";
        if(runQuery($sql)){
            redirect("login.php");
        }
    }else{
        return alert("Password don't match");
    }
}

function login(){

    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM users WHERE email='$email'";
    $spass = md5($password);
    $spass = sha1($spass);
    $query = mysqli_query(conn(),$sql);
    $row = mysqli_fetch_assoc($query);

    if(!$row){
        return alert("Incorrect Email or Password");
    }
    else{
        if(!password_verify($spass,$row['password'])){
            return alert("Incorrect Email or Password");
        }
        else{
            session_start();
            $_SESSION['user'] = $row;
            redirect("dashboard.php");
        }
    }
}

// Auth End 

// User Start

function user($id){
    $sql = "SELECT * FROM users WHERE id=$id";
    return fetch($sql);
}

function users(){
    $sql = "SELECT * FROM users";
    return fetchAll($sql);
}

// User Start


// Category Start

function categoryAdd(){

    $title = textFilter(strip_tags($_POST['title']));  //xss ko kar tar
    $user_id = $_SESSION['user']['id'];
    $sql = "INSERT INTO categories (title,user_id) VALUES ('$title','$user_id')";

    if(runQuery($sql)){
        linkTo("category_add.php");
    }
}

function category($id){
    $sql = "SELECT * FROM categories WHERE id=$id";
    return fetch($sql);
}

function categories(){
    $sql = "SELECT * FROM categories ORDER BY ordering DESC";
    return fetchAll($sql);
}

function categoryDelete($id){
    $sql = "DELETE FROM categories WHERE id=$id";
    return runQuery($sql);
}

function categoryUpdate(){
    $id = $_POST['id'];
    $title = $_POST['title'];
    $sql = "UPDATE categories SET title='$title' WHERE id=$id";
    return runQuery($sql);
}

function categoryPinToTop($id){

    $sql = "UPDATE categories SET ordering='0'";  //all to 0
    mysqli_query(conn(),$sql);

    $sql = "UPDATE categories SET ordering='1' WHERE id=$id"; //id to 1
    return runQuery($sql);
}

function categoryRemovePin(){

    $sql = "UPDATE categories SET ordering='0'";  //all to 0
    return runQuery($sql);

    
}

function isCategory($id){
    if(category($id)){
        return $id;
    }
    else{
        die("Category is invalid");
    }
}

// Category End

// Post Start

function postAdd(){

    $title = textFilter($_POST['title']);
    $description = textFilter($_POST['description']);
    $category_id = isCategory($_POST['category_id']);
    $user_id = $_SESSION['user']['id'];
    $sql = "INSERT INTO posts (title,description,category_id,user_id) VALUES ('$title','$description','$category_id','$user_id')";
    if(runQuery($sql)){
        linkTo("post_add.php");
    }
}

function post($id){
    $sql = "SELECT * FROM posts WHERE id=$id";
    return fetch($sql);
}

function posts($limit = 99999999999999999){
    if($_SESSION['user']['role'] == 2 ){
        $current_user_id = $_SESSION['user']['id'];
        $sql = "SELECT * FROM posts WHERE user_id ='$current_user_id' LIMIT $limit";  //for user
    }
    else{
        $sql = "SELECT * FROM posts LIMIT $limit";               //for other
    }
    return fetchAll($sql);
}

function postDelete($id){
    $sql = "DELETE FROM posts WHERE id=$id";
    return runQuery($sql);
}

function postUpdate(){
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category_id = $_POST['category_id'];
    $sql = "UPDATE posts SET title='$title',description='$description',category_id='$category_id' WHERE id=$id";

    return runQuery($sql);
}

// Post End

// Front Panel Start

    function fPosts($orderBy = 'id',$orderType = 'DESC'){
        
            $sql = "SELECT * FROM posts ORDER BY $orderBy $orderType";               
       
        return fetchAll($sql);
    }

    function fCategories(){
        
        $sql = "SELECT * FROM categories ORDER BY ordering DESC";               
   
    return fetchAll($sql);
}

    function fPostsByCat($category_id,$limit="99999",$id = 0){
       
        $sql = "SELECT * FROM posts WHERE category_id = $category_id AND id != $id ORDER BY id DESC LIMIT $limit";

        return fetchAll($sql);
    }

    function fSearch($searchKey){
        $sql = "SELECT * FROM posts WHERE title LIKE '%$searchKey%' OR description LIKE '%$searchKey%' ORDER BY id DESC";               
       
        return fetchAll($sql);
    }

    function fSearchByDate($start,$end){
        $sql = "SELECT * FROM posts WHERE created_at BETWEEN '$start' AND '$end' ORDER BY id DESC";               
       
        return fetchAll($sql);
    }

// Front Panel End

// Viewer Count Start

function viewerRecord($userId,$postId,$device){
    $sql = "INSERT INTO viewers (user_id,post_id,device) VALUES ('$userId','$postId','$device')";
    runQuery($sql);
}

function viewerCountByPost($postId){
    $sql = "SELECT * FROM viewers WHERE post_id = $postId";
    return fetchAll($sql);
}

function viewerCountByUser($userId){
    $sql = "SELECT * FROM viewers WHERE user_id = $userId";
    return fetchAll($sql);
}

// Viewer Count End

// ads start

function ads(){
    $today = date("Y-m-d");
    $sql = "SELECT * FROM ads WHERE start <= '$today' AND end > '$today'";
    return fetchAll($sql);
}

function adAdd(){

    $ownerName = $_POST['owner_name'];
    $adLink = $_POST['ad_link'];
    $start = $_POST['startAd'];
    $end = $_POST['endAd'];
    $file = $_FILES['file'];
    $fileTmpName = $file['tmp_name'];
    $fileName = $file['name'];
    $saveFolder = "assets/img/";

    foreach($fileName as $key=>$x){

        $newName = uniqid().$fileName[$key];
        move_uploaded_file($fileTmpName[$key],$saveFolder.$newName);

        $sql = "INSERT INTO ads (owner_name,photo,link,start,end) VALUES ('$ownerName','$newName','$adLink','$start','$end')";

        
        if(runQuery($sql)){
            linkTo("ad_add.php");
        }
        
    }

    
}

function ad($id){
    $sql = "SELECT * FROM ads WHERE id='$id'";
    return fetch($sql);
}

function adList(){
    
    $sql = "SELECT * FROM ads";
    return fetchAll($sql);
}

function adDelete($id){

    $sql = "SELECT * FROM ads";
    $ad = fetch($sql);
    unlink($ad['photo']);

    $sql = "DELETE FROM ads WHERE id='$id'";
    return runQuery($sql);
}

function adUpdate(){

    $id = $_POST['id'];
    $ownerName = $_POST['owner_name'];
    $adLink = $_POST['ad_link'];
    $start = $_POST['startAd'];
    $end = $_POST['endAd'];
    $file = $_FILES['file'];
    $fileTmpName = $file['tmp_name'];
    $fileName = $file['name'];
    $saveFolder = "assets/img/";

    foreach($fileName as $key=>$x){

        $newName = uniqid().$fileName[$key];
        move_uploaded_file($fileTmpName[$key],$saveFolder.$newName);

        $sql = "UPDATE ads SET owner_name='$ownerName',photo='$newName',link='$adLink',start='$start',end='$end' WHERE id='$id'";
       
        return runQuery($sql);
        
    }
}

// ads end

// payment start

function payNow(){

    $from = $_SESSION['user']['id'];
    $to = $_POST['to_user'];
    $amount = $_POST['amount'];
    $description = $_POST['description'];

    // From User money update (-)
    $fromUserDetail = user($from);
    $leftMoney = $fromUserDetail['money'] - $amount;

    if($fromUserDetail['money'] >= $amount){            //for security

        $sql = "UPDATE users SET money='$leftMoney' WHERE id='$from'";
        mysqli_query(conn(),$sql);

        //To user money update (+)
        $toUserDetail = user($to);
        $newMoney = $toUserDetail['money'] + $amount;
        $sql = "UPDATE users SET money='$newMoney' WHERE id='$to'";
        mysqli_query(conn(),$sql);

        //add to transition table
        $sql = "INSERT INTO transition (from_user,to_user,amount,description) VALUES ('$from','$to','$amount','$description')";
        runQuery($sql);
    }
    
}

function transitions(){
    $userId = $_SESSION['user']['id'];

    if($_SESSION['user']['role'] == 0){
        $sql = "SELECT * FROM transition";
    }
    else{
        $sql = "SELECT * FROM transition WHERE from_user ='$userId' OR to_user = '$userId'";
    }
    
    return fetchAll($sql);
}

// payment end

// dashboard start

function dashboardPosts($limit = 99999999999999999){
    if($_SESSION['user']['role'] == 2 ){
        $current_user_id = $_SESSION['user']['id'];
        $sql = "SELECT * FROM posts WHERE user_id ='$current_user_id' ORDER BY id DESC LIMIT $limit";  //for user
    }
    else{
        $sql = "SELECT * FROM posts ORDER BY id DESC LIMIT $limit";               //for other
    }
    return fetchAll($sql);
}

// dashboard end

// api start

function apiOutput($arr){

   echo  json_encode($arr);          // php array to javascript object
}

// api end