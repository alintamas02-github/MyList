<?php
$page_title = 'Add User';
require_once('includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(1);
$groups = find_all('user_groups');
?>
<?php
if(isset($_POST['add_user'])){

 $req_fields = array('full-name','username','password','level' );
 validate_fields($req_fields);

 if(empty($errors)){
     $name   = remove_junk($db->escape($_POST['full-name']));
     $username   = remove_junk($db->escape($_POST['username']));
     $password   = remove_junk($db->escape($_POST['password']));
     $user_level = (int)$db->escape($_POST['level']);
     $password = sha1($password);
     $query = "INSERT INTO users (";
     $query .="name,username,password,user_level,status";
     $query .=") VALUES (";
     $query .=" '{$name}', '{$username}', '{$password}', '{$user_level}','1'";
     $query .=")";
     if($db->query($query)){
       //sucess
       $session->msg('s',"User account has been creted! ");
       redirect('add_user.php', false);
     } else {
       //failed
       $session->msg('d',' Sorry failed to create account!');
       redirect('add_user.php', false);
     }
 } else {
   $session->msg("d", $errors);
    redirect('add_user.php',false);
 }
}

// Verificați dacă butonul "Send Email Data" a fost apăsat
if(isset($_POST['send_email'])){
  $name = remove_junk($db->escape($_POST['full-name']));
  $username = remove_junk($db->escape($_POST['username']));
  $user_level = (int)$db->escape($_POST['level']);

  // Trimiteți datele prin EmailJS
  echo '
  <script src="https://cdn.emailjs.com/dist/email.min.js"></script>
  <script type="text/javascript">
    emailjs.init("3LStvFd1W_0kLm7GB"); // Înlocuiți cu ID-ul utilizatorului dvs. EmailJS

    var name = "'.$name.'";
    var username = "'.$username.'";
    var level = "'.$user_level.'";

    var params = {
      to_email: "alintamas26@gmail.com", // Adresa de email a destinatarului
      from_name: name,
      from_username: username,
      user_level: level,
    };

    emailjs.send("service_2wkh275", "template_h8gx0rr", params)
      .then(function (response) {
        console.log("Email trimis cu succes!", response);
      })
      .catch(function (error) {
        console.error("Eroare la trimiterea emailului:", error);
      });
  </script>
  ';
}
?>

<?php include_once('layouts/header.php'); ?>
<?php echo display_msg($msg); ?>
<div class="row">
  <div class="panel panel-default">
    <div class="panel-heading">
      <strong>
        <span class="glyphicon glyphicon-th"></span>
        <span>Add New User</span>
     </strong>
    </div>
    <div class="panel-body">
      <div class="col-md-6">
        <form method="post" action="add_user.php">
          <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control" name="full-name" placeholder="Full Name">
          </div>
          <div class="form-group">
              <label for="username">Username</label>
              <input type="text" class="form-control" name="username" placeholder="Username">
          </div>
          <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" name ="password"  placeholder="Password">
          </div>
          <div class="form-group">
            <label for="level">User Role</label>
              <select class="form-control" name="level">
                <?php foreach ($groups as $group ):?>
                 <option value="<?php echo $group['group_level'];?>"><?php echo ucwords($group['group_name']);?></option>
              <?php endforeach;?>
              </select>
          </div>
          <div class="form-group clearfix">
            <button type="submit" name="add_user" class="btn btn-primary">Add User</button>
          </div>
          <div class="form-group clearfix">
            <button type="submit" name="send_email" class="btn btn-primary">Send Email Data</button>
          </div>
      </form>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>