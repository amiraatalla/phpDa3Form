<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>  

<?php
// define variables and set to empty values
$nameErr = $emailErr = $genderErr = $passwordErr = "";
$name = $email = $gender = $comment = $password = "";





if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
  } else {
    $name = test_input($_POST["name"]);
  }
  
  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
  }
    
  if (empty($_POST["password"])) {
    $password = "";
  } else {
    $password = test_input($_POST["password"]);
  }

  if (empty($_POST["comment"])) {
    $comment = "";
  } else {
    $comment = test_input($_POST["comment"]);
  }

  if (empty($_POST["gender"])) {
    $genderErr = "Gender is required";
  } else {
    $gender = test_input($_POST["gender"]);
    
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<h2>PHP Form Validation Example</h2>
<p><span class="error">* required field</span></p>
<form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  Name: <input type="text" name="name">
  <span class="error">* <?php echo $nameErr;?></span>
  <br><br>
  E-mail: <input type="text" name="email">
  <span class="error">* <?php echo $emailErr;?></span>
  <br><br>
  password: <input type="text" name="password">
  <span class="error"><?php echo $passwordErr;?></span>
  <br><br>
  Comment: <textarea name="comment" rows="5" cols="40"></textarea>
  <br><br>
  Gender:
  <input type="radio" name="gender" value="female">Female
  <input type="radio" name="gender" value="male">Male
  <input type="radio" name="gender" value="other">Other
  <span class="error">* <?php echo $genderErr;?></span>
  <br><br>
  Room No:<select name="room">
      <option>Application1</option>
      <option>Application2</option>
      <option>Cloud</option>
  </select>
  <br><br>
  <input type="file" name="testfile" >
  <br><br>
  <input type="submit" name="submit" value="Submit">  
</form>

<?php





    echo "<h4> Uploading file<h4>";

    if(isset($_FILES["testfile"])) {

        $uploadfile = $_FILES["testfile"];

        if($uploadfile["name"]!=""){

            $filename= $uploadfile["name"];
            $filetmpname=$uploadfile["tmp_name"];
            $filesize=$uploadfile["size"];
            $ext=explode(".",$filename);
            $ext= end($ext);


            $extensions=["png","jpg"];
            $errors=[];

            if(!in_array($ext,$extensions)){
                $errors[]="this type is not allowed";
            }

            if($filesize> 1000000000){
                $errors[]="this is file is to long, please choose another one";
            }

            if(empty($errors)){
                move_uploaded_file($filetmpname, $filename);
                echo "filename : ".$filename." filetmpname : ".$filetmpname." filesize : ".$filesize."extention : ".$ext."<br>";
                echo "<br>";
                echo "<img src = '$filename'>";
                echo "<br>";

            }else{
                print_r($errors);
            }

          }
          else{
              echo " <br> No file choosen";
          }
        }


  echo "<br>****************************************<br>output<br>";





if (!empty($_POST["name"]) && !empty($_POST["gender"])) {

    if (($_POST["gender"])=="female") {
        echo "<h2>Thanks Mrs $name</h2>";
        echo "<h2>Please check your info : </h2>";

    } 
    else if (($_POST["gender"])=="male") {
        echo "<h2>Thanks Mr $name</h2>";
        echo "<h2>Please check your info : </h2>";
    }
    else{
        echo "<h2>Thanks Mr/Mis $name</h2>";
        echo "<h2>Please check your info : </h2>";
    }
}

if (!empty($_POST["name"])) {
    echo "Your Name : ". $name."<br>";
} 
    if (!empty($_POST["email"])){
    echo "Your email : ". $email."<br>";
} 
if (!empty($_POST["password"])) {
    echo "Your password : ". $password."<br>";
} 
if (!empty($_POST["comment"])) {
    echo "Your comment : ". $comment."<br>";
} 
if (!empty($_POST["gender"])) {
    echo "Your gender : ". $gender."<br>";
} 

echo "<br>****************************************<br>file output<br>";

$fileName = "formInfo.txt" ;
$file = fopen($fileName , "r+");

if ($file == false ) {
   echo "<br>can not open the file<br>";
   exit();
}
else {

    if (!empty($_POST["name"])) {

        fwrite($file, "Your Name : ". $name." ");
    } 
    if (!empty($_POST["email"])) {

        fwrite($file, "Your email : ". $email." ");

    } 
    if (!empty($_POST["password"])) {

        fwrite($file, "Your password : ". $password." ");
     
    } 
    if (!empty($_POST["comment"])) {

        fwrite($file, "Your comment : ". $comment." ");
        
    } 
    if (!empty($_POST["gender"])) {

        fwrite($file, "Your gender : ". $gender." && ");
       
    } 
 

   while(!feof($file)) {

        echo fread($file,filesize($fileName));

       
     }
    

    fclose($file);
}


echo "<br>*************************email validation****************<br><br>";
$pattern="/^([a-z0-9\+\-]+)(\.[a-z0-9\+\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix";

if(preg_match($pattern,$email)){
   echo "Valid email address ";
   echo "</br>";
}
else{
    echo "Is not Valid email address.";
    echo "</br>";

}
//email validation 2
if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo(" valid email address");
    echo "</br>";
} else {
    echo("not valid email address");
    echo "</br>";
}


echo "<br>*************************password validation****************<br><br>";

$password = $password;

// Validate password strength
$uppercase = preg_match('@[A-Z]@', $password);
$lowercase = preg_match('@[a-z]@', $password);
$number    = preg_match('@[0-9]@', $password);
$specialChars = preg_match('@[^\w]@', $password);

if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
    echo 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
}else{
    echo 'Strong password.';
}
echo "<br>*************************session & cookies****************<br><br>";

session_start();

$_SESSION["name"]= $name;
$_SESSION["email"]= $email;
$_SESSION["gender"]= $gender;

var_dump($_SESSION);

var_dump($_COOKIE);

setcookie("Name",$name,time()+25000);
setcookie("Email",$_SESSION["email"],time()+25000);
?>






</body>
</html>