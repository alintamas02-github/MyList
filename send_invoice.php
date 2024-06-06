<?php
  $page_title = 'Send Invoice';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(3);

  // Obțineți vânzările din baza de date
  $sales = find_all_sale();

// Verificați dacă există vânzări
  if ($sales !== null && is_array($sales) && count($sales) > 0) {
  // Calculați totalul vânzărilor
  $total = 0;
  foreach ($sales as $sale) {
    $total += (int)$sale['qty'] * (float)$sale['price'];
  }
} else {
    // Dacă nu există vânzări, puteți trata această situație aici sau afișa un mesaj de eroare.
    echo '<p>Nu există vânzări disponibile pentru a genera factura.</p>';
    exit(); // Ieșiți din script pentru a preveni erori ulterioare.
  }

  // Alte variabile pentru email
  $name = '';
  $username = '';
  $user_level = '';
?>

<?php include_once('layouts/header.php'); ?>

<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-envelope"></span>
          <span>Trimite Factura pe Email</span>
        </strong>
      </div>
      <div class="panel-body">
        <?php
          echo '
          <script src="https://cdn.emailjs.com/dist/email.min.js"></script>
          <script type="text/javascript">
            emailjs.init(""); // Înlocuiți cu ID-ul utilizatorului dvs. EmailJS

var name = "'.$name.'";
            var username = "'.$username.'";
            var level = "'.$user_level.'";
            var total = "'.$total.'"; // Adăugați totalul calculat aici

            var params = {
              to_email: "", // Adresa de email a destinatarului
from_name: name,
              from_username: username,
              user_level: level,
              total: total // Includeți totalul în parametrii email-ului
            };

            emailjs.send("", "", params)
              .then(function (response) {
                console.log("Email trimis cu succes!", response);
              })
              .catch(function (error) {
                console.error("Eroare la trimiterea emailului:", error);
              });
          </script>
          ';

          echo '<p>Email-ul a fost trimis cu succes!</p>';
        ?>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>
