<?php
ob_start();
session_start();
include 'connect.php';


if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['send'])){

   $name = $_POST['name'];
   $name = strip_tags($name);
   $email = $_POST['email'];
   $email = strip_tags($email);
   $number = $_POST['number'];
   $number = strip_tags($number);
   $msg = $_POST['msg'];
   $msg = strip_tags($msg);

   $select_message = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND email = ? AND number = ? AND message = ?");
   $select_message->execute([$name, $email, $number, $msg]);

   if($select_message->rowCount() > 0){
      $message[] = 'siap mengirim pesan!';
   }else{

      $insert_message = $conn->prepare("INSERT INTO `messages`(user_id, name, email, number, message) VALUES(?,?,?,?,?)");
      $insert_message->execute([$user_id, $name, $email, $number, $msg]);

      $message[] = 'pesan anda terkirim!';

   }

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>kontak</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="style.css?=<?php echo time(); ?>">

</head>
<body>
   
<?php include 'user_header.php'; ?>

<section class="contact">

   <form action="" method="post">
      <h3>pesan</h3>
      <input type="text" name="name" placeholder="masukan nama" required maxlength="20" class="box">
      <input type="email" name="email" placeholder="masukkan email" required maxlength="50" class="box">
      <input type="number" name="number" min="0" max="9999999999" placeholder="masukkan nomor anda" required onkeypress="if(this.value.length == 10) return false;" class="box">
      <textarea name="msg" class="box" placeholder="pesanan anda" cols="30" rows="10"></textarea>
      <input type="submit" value="kirim pesan" name="send" class="btn">
   </form>

</section>













<?php include 'footer.php'; ?>

<script src="script.js"></script>

</body>
</html>