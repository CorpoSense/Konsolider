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
        <div class="col-md-6">


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
            // isAdmin
            if (Yii::$app->user->id == 1){
              // echo 'yes admin';

            } else {
              // echo 'a Guest!';
            }
            ?>

            
            <div class="row">
                
                
                <div class="col-md-6">
                    
                    <div class="page-header">
                        <h4>
                            Résultat de l'exercice en cours
                        </h4>

                    </div>

            <table id="listUnit" class="table table-hover">
                <thead>
                <tr>
                    <th>Unite</th>
                    <th>Canevas</th>
                    <th>Progression</th>
                </tr>
                </thead>
                <tbody>

                  <!-- .foreach $exercices -->

                    <tr>
                        <td><?= '$exercice->unite->nom' ?></td>
                        <td>
                            <ul>
                              <!-- foreach...-->
                                  <li>canevas1</li>
                                  <li>canevas2</li>
                                  <li>canevas3</li>
                            </ul>
                        </td>
                        <td>
                          <div class="progress">
                            <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                              60%
                            </div>
                          </div>
                          <div class="progress">
                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 30%;">
                              30%
                            </div>
                          </div>
                          <div class="progress">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 70%;">
                              70%
                            </div>
                          </div>
                        </td>
                    </tr>

              <!-- end of foreach $exercices -->

                </tbody>
            </table>
                    
                    </div><!-- .col-md-6 -->
                </div><!-- .row -->
            
            <?php
            // otherwise
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
