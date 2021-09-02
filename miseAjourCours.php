<?php

if (isset($_POST['Submit'])){

if ($_POST['date_debut']<$_POST['date_fin']){

  if(isset($_POST['checkbox_USD'])){
    //Recuperation $_POST
    $CODE_DVSE_CODE = 'USD';
    $CODE_DEBUT_VALIDITE= $_POST['date_debut'];
    $CODE_FIN_VALIDITE= $_POST['date_fin'];
    $CODE_COURS_OUT_USD= $_POST['cours_usd'];

    //Insertion D'une ligne
    $CoursModele->CoursInsert($CODE_DVSE_CODE, $CODE_DEBUT_VALIDITE, $CODE_FIN_VALIDITE, number_format($CODE_COURS_OUT_USD, 4, ',', ''));
  }else{
    if(isset($_POST['checkbox_TND'])){
      //Recuperation $_POST
      $CODE_DVSE_CODE = 'DTN';
      $CODE_DEBUT_VALIDITE= $_POST['date_debut'];
      $CODE_FIN_VALIDITE= $_POST['date_fin'];
      $CODE_COURS_OUT_TND= $_POST['cours_tnd'];

     //Insertion D'une ligne
      $CoursModele->CoursInsert($CODE_DVSE_CODE, $CODE_DEBUT_VALIDITE, $CODE_FIN_VALIDITE, number_format($CODE_COURS_OUT_TND, 4, ',', ''));
    }else{
      //affiché alert aucunne cours Cochée

?>
  <div class="alert alert-warning">
    <strong>Alerte!</strong> Cochée la cours que vous souhaitez mettre à jour.
  </div>
<?php
        }
      }
    }else{
      //affiché alert si les dates sont erroné
?>
<div class="alert alert-danger">
  <strong>Danger!</strong> La date du fin doit être supérieur à la date du début.
</div>
<?php

}

if ($CoursModele){
  //affiché alert si mise a jours avec succé
?>
<div class="alert alert-success">
  <strong>Success!</strong> Insertion faite avec succès.
</div>
<?php
}
}

 ?>
