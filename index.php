<!DOCTYPE html>
<?php
//instance de connexion BDD
include_once __DIR__."/bdd/BaseDeDonne.php";
include_once __DIR__."/modele/CoursModele.php";
$CoursModele = new CoursModele();

$AncienCoursDtn = $CoursModele->SelectCours('DTN');
$AncienCoursUsd = $CoursModele->SelectCours('USD');



//echo str_pad($AncienCoursDtn[0]['CODE_COURS_OUT'], 6, '0', STR_PAD_LEFT);
//echo str_pad($AncienCoursUsd[0]['CODE_COURS_OUT'], 6, '0', STR_PAD_LEFT);

//API GET
function cours($DEVISE){
    // Fetching JSON
    $req_url = 'https://v6.exchangerate-api.com/v6/27a99c9a1dd2ad7c1022f25e/latest/EUR';
    $response_json = file_get_contents($req_url);

    // Continuing if we got a result
    if(false !== $response_json) {

        // Try/catch for json_decode operation
        try {

        // Decoding
        $response_object = json_decode($response_json);

        // YOUR APPLICATION CODE HERE, e.g.
        //$base_price = 1; // Your price in USD
        //$EUR_price = $response_object->rates->$DEVIS;
        //$USD_price = $response_object->rates->$DEVIS;
        $DATA = $response_object->conversion_rates->$DEVISE;

        return ($DATA);
        //echo $EUR_price."<br>";
        //echo round(($EUR_price / $USD_price),3)."<br>";
        //echo round(($EUR_price / $TND_price),3)."<br>";
        }
        catch(Exception $e) {
            // Handle JSON parse error....
        }
    }

}

$dates1 =  $_SERVER['dataInicio'] = date('d/m/Y', mktime(0, 0, 0, date('m')+1, 1, date('Y')))."<br>";
$dates2 =  date("t/m/Y",strtotime("+1 month")) ;

include_once __DIR__."/miseAjourCours.php";
?>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Mecaprotec - Currency Update</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/Mecaprotec.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class=" align-items-center">
    <div class="container d-flex flex-column align-items-center">

      <h1>COURS DU CHANGE</h1>
      <h2>Automatisation de la mise à jour du cours monnaie OCTAL.</h2>
      <h2> <?php
                      date_default_timezone_set("Africa/Tunis");
                      echo date("d/m/Y h:i:s");
                      ?> </h2>

    </div>
     <form class="get" action="index.php" method="post">


      <div class="container col-8  align-items-center">
        <div class="table-responsive">
         <table class="table">
             <thead class="thead-dark">
                 <tr>
                     <th class="border-0 rounded-start">#</th>
                     <th class="border-0 rounded-start">Pays</th>
                     <th class="border-0">Monnaie</th>
                     <th class="border-0 rounded-end">Dernier Cours</th>
                     <th class="border-0 rounded-end">Debut Validite</th>
                     <th class="border-0 rounded-end">Fin Validite</th>
                     <th class="border-0 rounded-end" style="color:#00ffea">Cours <?=date("d/m/Y")?></th>
                 </tr>
             </thead>
             <tbody>
                 <!-- Item -->
                 <tr>
                     <td> <input type="checkbox" disabled> </td>
                     <td>
                         <a href="https://www.xe.com/currencyconverter/convert/?Amount=1&From=EUR&To=EUR" class="d-flex align-items-center">
                             <img class="me-2 image image-small rounded-circle" alt="Image placeholder"
                                 src="https://www.apryxia.com/assets/images/flags/flag-eu.svg"
                                 style="width:2rem">
                             <div><span class="h6">Union Européenne</span></div>
                         </a>
                     </td>
                     <td class="font-weight-bold">EUR</td>
                     <td >
                         <span class="font-weight-bold"><?=round(1 / cours('EUR'),4)?></span>
                     </td>
                     <td >
                         <span class="font-weight-bold">-</span>
                     </td>
                     <td >
                         <span class="font-weight-bold">-</span>
                     </td>
                     <td >
                         <span class="font-weight-bold"><?=round(1 / cours('EUR'),4)?></span>
                     </td>
                 </tr>
                 <!-- End of Item -->
                 <!-- Item -->
                 <tr>
                     <td> <input type="checkbox" name="checkbox_TND" value="oui"> </td>
                     <td>
                         <a href="https://www.xe.com/currencyconverter/convert/?Amount=1&From=TND&To=EUR" class="d-flex align-items-center">
                             <img class="me-2 image image-small rounded-circle" alt="Image placeholder"
                                 src="https://www.apryxia.com/assets/images/flags/flag-tn.svg" style="width:2rem">
                             <div><span class="h6">Tunisie</span></div>
                         </a>
                     </td>
                     <td class=" font-weight-bold">TND</td>
                     <td >
                         <span class="font-weight-bold"><?=str_pad($AncienCoursDtn[0]['CODE_COURS_OUT'], 6, '0', STR_PAD_LEFT)?></span>
                     </td>
                     <td >
                         <span class="font-weight-bold"><?=$AncienCoursDtn[0]['CODE_DEBUT_VALIDITE']?></span>
                     </td>
                     <td >
                         <span class="font-weight-bold"><?=$AncienCoursDtn[0]['CODE_FIN_VALIDITE']?></span>
                     </td>
                     <td >
                         <span class="font-weight-bold"><?=round(1 / cours('TND'),4)?></span>
                     </td>
                 </tr>
                 <!-- End of Item -->
                 <!-- Item -->
                 <tr>
                     <td> <input type="checkbox" name="checkbox_USD" value="oui"> </td>
                     <td>
                         <a href="https://www.xe.com/currencyconverter/convert/?Amount=1&From=USD&To=EUR" class="d-flex align-items-center">
                             <img class="me-2 image image-small rounded-circle" alt="Image placeholder"
                                 src="https://www.apryxia.com/assets/images/flags/flag-us.svg"
                                 style="width:2rem">
                             <div><span class="h6">United States</span></div>
                         </a>
                     </td>
                     <td class="font-weight-bold">USD</td>
                     <td>
                         <span class="font-weight-bold"><?=str_pad($AncienCoursUsd[0]['CODE_COURS_OUT'], 6, '0', STR_PAD_LEFT)?></span>
                     </td>
                     <td >
                         <span class="font-weight-bold"><?=$AncienCoursUsd[0]['CODE_DEBUT_VALIDITE']?></span>
                     </td>
                     <td >
                         <span class="font-weight-bold"><?=$AncienCoursUsd[0]['CODE_FIN_VALIDITE']?></span>
                     </td>
                     <td>
                         <span class="font-weight-bold"><?=round(1 / cours('USD'),4)?></span>
                     </td>
                 </tr>
                 <!-- End of Item -->
                 <!-- Item -->
                 <tr>
                     <td> <input type="checkbox" name="checkbox_CAD" value="oui" disabled> </td>
                     <td >
                         <a href="https://www.xe.com/currencyconverter/convert/?Amount=1&From=CAD&To=EUR" class="d-flex align-items-center" target="_blank">
                             <img class="me-2 image image-small rounded-circle" alt="Image placeholder"
                                 src="https://www.apryxia.com/assets/images/flags/flag-ca.svg"
                                 style="width:2rem">
                             <div><span class="h6">Canada</span></div>
                         </a>
                     </td>
                     <td class="font-weight-bold">CAD</td>
                     <td >
                         <span class="font-weight-bold">-</span>
                     </td>
                     <td >
                         <span class="font-weight-bold">-</span>
                     </td>
                     <td >
                         <span class="font-weight-bold">-</span>
                     </td>
                     <td >
                         <span class="font-weight-bold"><?=round(1 / cours('CAD'),4)?></span>
                     </td>
                 </tr>
                 <!-- End of Item -->
             </tbody>
         </table>
       </div>
       <br>
       <br>
       <br>
       <br>
       <br>
       <br>

         <div class="d-grid gap-2 col-6 mx-auto">
           <div class="input-group input-daterange">
              <input type="date" class="form-control" name="date_debut"required>
              <input type="date" class="form-control" name="date_fin" required>
              <input type="hidden" name="cours_tnd" value=<?=round(1 / cours('TND'),4)?>>
              <input type="hidden" name="cours_usd" value=<?=round(1 / cours('USD'),4)?>>
          </div>

           <button class="btn btn-outline-info" type="submit" name="Submit">Mettre a jour </button>
         </div>
       </form>
      </div>
  </header><!-- End #header -->

  <main id="main">

    <!-- ======= About Us Section ======= -->
    <!-- <section id="about" class="about">
      <div class="container">

        <div class="section-title">
          <h2>About Us</h2>
          <p>Illo velit quae dolorem voluptate pireda notila set. Corrupti voluptatum tempora iste ratione deleniti corrupti nostrum ut</p>
        </div>

        <div class="row mt-2">
          <div class="col-lg-4 col-md-6 icon-box">
            <div class="icon"><i class="bi bi-briefcase"></i></div>
            <h4 class="title"><a href="">Lorem Ipsum</a></h4>
            <p class="description">Voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident</p>
          </div>
          <div class="col-lg-4 col-md-6 icon-box">
            <div class="icon"><i class="bi bi-bar-chart"></i></div>
            <h4 class="title"><a href="">Dolor Sitema</a></h4>
            <p class="description">Minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat tarad limino ata</p>
          </div>
          <div class="col-lg-4 col-md-6 icon-box">
            <div class="icon"><i class="bi bi-brightness-high"></i></div>
            <h4 class="title"><a href="">Sed ut perspiciatis</a></h4>
            <p class="description">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur</p>
          </div>
        </div>

      </div>
    </section><!-- End About Us Section -->

    <!-- ======= Contact Us Section ======= -->
    <section id="contact" class="contact">
      <div class="container">

        <div class="section-title">
          <h2>Contact Us</h2>
        </div>

        <div class="row">

          <div class="col-lg-12 d-flex align-items-stretch">
            <div class="info">
              <div class="address">
                <i class="bi bi-geo-alt"></i>
                <h4>Location:</h4>
                <p>34, boulevard Joffrery - B.P. 30204 - 31605 MURET CEDEX</p>
              </div>

              <div class="email">
                <i class="bi bi-envelope"></i>
                <h4>Email:</h4>
                <p>contact@mecaprotec.com</p>
              </div>

              <div class="phone">
                <i class="bi bi-phone"></i>
                <h4>Call:</h4>
                <p>+(33) 05.61.51.82.00</p>
              </div>

              <iframe src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=%20MECAPROTEC%20INDUSTRIES%2034%20Bd%20de%20Joffrery,%2031600%20Muret,%20France+(Mecaprotec%20Industries)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed" frameborder="0" style="border:0; width: 100%; height: 290px;" allowfullscreen></iframe>
            </div>

          </div>


        </div>

      </div>
    </section><!-- End Contact Us Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span><a href="https://www.mecaprotec.fr/index.php/fr/">Mec@protec Industries</a></span></strong>. All Rights Reserved
      </div>
    </div>
  </footer><!-- End #footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <script src="assets/js/main.js"></script>

</body>

</html>
