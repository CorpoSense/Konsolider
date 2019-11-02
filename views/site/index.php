<?php

/* @var $this yii\web\View */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::$app->name.' v1.0';
?>

<div class="site-index">


    <!-- <div class="jumbotron">
        <h1><?= Yii::$app->name ?></h1>
        <p class="lead">Veuillez vous connecter afin d'accéder à l'application.</p>
    </div> -->

    <div class="container">
        <div class="row">
            <h1><?php //echo Yii::$app->user->identity->getRole() ?></h1>
            <p><?php //echo (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin())?'yes':'no' ?></p>
        </div>
      <div class="row">
        <div class="col-md-12">


          <?php
          if (Yii::$app->user->isGuest){

            echo '<h2>Connexion</h2>';

            $form = ActiveForm::begin([ 'id' => 'login-form' ]);
            echo $form->field($model, 'username')->textInput(['autofocus' => true]);
            echo $form->field($model, 'password')->passwordInput();
            echo $form->field($model, 'rememberMe')->checkbox([]);
            echo Html::submitButton('Connexion', ['class' => 'btn btn-primary', 'name' => 'login-button']);
            ActiveForm::end();

          } else {
            // user role is 'admin'
            if (Yii::$app->user->identity->isAdmin()){
              // var_dump($exercices);
              // die('');
              // echo 'yes admin';
                echo $this->render('_admin', ['exercices' => $exercices]);

            } else {
              // user role is 'user'
                echo $this->render('_user', ['exercices' => $exercices/*[0], 'indicateurs' => $indicateurs*/]);
            }
            ?>

            <?php
            // otherwise (other or unknown roles)
          }
          ?>

        </div><!-- .col-md-6 -->

      </div><!-- .row -->
    </div><!-- .container -->

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
              <h2></h2>
              <p></p>
            </div>
            <div class="col-lg-4">
            </div>
            <div class="col-lg-4">
            </div>
        </div>

    </div>
</div>
