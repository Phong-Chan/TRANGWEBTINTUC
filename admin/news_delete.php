<?php
    $id = $_GET['id'];
    $myfile = fopen("news.json","r");
    $filesize = filesize("news.json");
    if ($filesize > 0) {
        $newsData = json_decode(fread($myfile, $filesize), true);
    }

    foreach ($newsData as $key => $news){
        if ($news['id'] == $id){
            unset($newsData[$key]);
        }
    }
    $myfile = fopen("news.json","w");
    fwrite($myfile, json_encode($newsData));
    fclose($myfile);
    
    echo '<script>
        alert("Xóa thành công!");
        window.location.href="news.php";
    </script>';