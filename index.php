<?php

use function PHPSTORM_META\type;

$rand_number;
$string = file_get_contents("people.json");
$json_a = json_decode($string, true);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="styles/default.css">
    <title>مشاوره بزرگان</title>
</head>
<body>
<p id="copyright">تهیه شده برای درس کارگاه کامپیوتر،دانشکده کامییوتر، دانشگاه صنعتی شریف</p>
<div id="wrapper">
    <div id="title">
        <span id="label" style="display:<?php echo (!isset($_POST['question']) ||$_POST['question']== "" || substr($_POST['question'],0,6) != "آیا" || (substr($_POST['question'],strlen($_POST['question'])-1,1) != "?" && substr($_POST['question'],strlen($_POST['question'])-2,2) != "؟")? "none": ""); ?>">پرسش:</span>
        <span id="question" style="display:<?php echo (!isset($_POST['question']) ||($_POST['question']== "" || substr($_POST['question'],0,6) != "آیا" || (substr($_POST['question'],strlen($_POST['question'])-1,1) != "?" && substr($_POST['question'],strlen($_POST['question'])-2,2) != "؟"))? "none": ""); ?>"><?php echo $_POST['question'] ?></span>
    </div>
    <div id="container">
        <div id="message">
            <p><?php 
            
            if( !isset($_POST['question']) || $_POST['question'] == ''){
                echo "سوال خود را بپرس!";
            }else if(substr($_POST['question'],0,6) != "آیا" || (substr($_POST['question'],strlen($_POST['question'])-1,1) != "?" && substr($_POST['question'],strlen($_POST['question'])-2,2) != "؟")){
                echo"سوال درستی پرسیده نشده";
            }
            else{
                $hash = hash("sha256", $_POST["question"].$_POST['person']);
                $hash = substr($hash, 0,6);
                $hash_int = 0;
                for ($i=0; $i < 6; $i++) { 
                    $hash_int += ($i+1)*($i+1)*ord($hash[$i]);
                }
                $line_i = 0;
                $line_n = $hash_int % 16+1;
                if ($file = fopen("messages.txt", "r")) {
                    while(!feof($file)) {
                        $line_i++;
                        $line = fgets($file);
                        if($line_i == $line_n) {echo $line; break;}
                    }
                    fclose($file);
                } 
            }  
            ?></p>
        </div>
        <div id="person">
            <div id="person">
                <img src="images/people/<?php
                if(!isset($_POST['question']) || $_POST['question'] == '' || (substr($_POST['question'],0,6) != "آیا" || (substr($_POST['question'],strlen($_POST['question'])-1,1) != "?" && substr($_POST['question'],strlen($_POST['question'])-2,2) != "؟"))){       
                    $rand_number = rand(1,16);
                    $i = 1;
                    foreach ($json_a as $en_name => $fa_name){
                        if($i == $rand_number){echo $en_name.'.jpg'; $his_name = $en_name;}
                        $i++;
                    }
                }else{
                    echo $_POST['person'].".jpg";
                }
                ?>"/>


                <p id="person-name"><?php
                if(!isset($_POST['person'])){echo $json_a[$his_name]; }else{
                $en_name = $_POST['person'];
                $string = file_get_contents("people.json");
                $json_a = json_decode($string, true);
                if($_POST['question'] == '' || (substr($_POST['question'],0,6) != "آیا" || (substr($_POST['question'],strlen($_POST['question'])-1,1) != "?" && substr($_POST['question'],strlen($_POST['question'])-2,2) != "؟"))){
                    echo $json_a[$his_name];
                }else{
                echo $json_a[$en_name];
            }}
                ?></p>
            </div>
        </div>
    </div>
    <div id="new-q">
        <form method="post">
            سوال
            <input type="text" maxlength="150" name="question" value="<?php if(isset($_POST['question'])){echo $_POST["question"];}?>"  placeholder="..."/>
            را از
            <select name="person">

                <?php

                    foreach ($json_a as $en_name => $fa_name) {
                    if($_POST['question'] == '' || (substr($_POST['question'],0,6) != "آیا" || (substr($_POST['question'],strlen($_POST['question'])-1,1) != "?" && substr($_POST['question'],strlen($_POST['question'])-2,2) != "؟"))){
                        if($en_name == $his_name){
                            $selected = "selected";
                        }else{$selected = "";}
                    }else{
                        if($en_name == $_POST['person']){
                            $selected = "selected";
                        }else{$selected = "";}
                    }
                    echo '<option value="'.$en_name.'" '.$selected.'>'.$fa_name.'</option>';
                    }

                ?>
            </select>
            <input type="submit" name="SubmitButton" value="بپرس"/>
        </form>

    </div>
</div>
</body>
</html>