<html>
<body>
    


<?php

include('instagram_basic.php');
$ig=new Instagrambasic();



if(!str_contains($_SERVER['REQUEST_URI'],'code') && $ig->shortlivedaccesstoken==null  ){ 
echo "<a href={$ig->getcode()}>click to get the code</a> <br> <br>";
}


else{
    $ig->code=trim($_SERVER['REQUEST_URI'],"/?code=");
    $ig->getshortlivedaccesstoken();
}


?>





</body>
</html>
