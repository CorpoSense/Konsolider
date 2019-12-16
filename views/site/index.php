<?php

/* @var $this yii\web\View */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::$app->name;//.' v1.0';
?>

<div class="site-index">

    <div class="container">
      <div class="row">
        <div class="col-md-12">

          <?php if (Yii::$app->user->isGuest): ?>

    <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                    'validateOnBlur' => false,
                    'validateOnType' => false,
                    'validateOnChange' => false,
                ]) ?>

                    <?= $form->field($model, 'username',
                        ['inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control', 'tabindex' => '1']]
                    );
                    ?>
                
                    <?= $form->field(
                        $model,
                        'password',
                        ['inputOptions' => ['class' => 'form-control', 'tabindex' => '2']])
                        ->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox(['tabindex' => '3']) ?>

                <?= Html::submitButton(
                    Yii::t('app', 'Connexion'),
                    ['class' => 'btn btn-success btn-block', 'tabindex' => '4']
                ) ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>

    </div>
          <?php else: ?>
            
            <?php
            // user role is 'admin'
            if (Yii::$app->user->identity->isAdmin()){
                echo $this->render('_admin', ['exercices' => $exercices, 'filterModel' => $filterModel]);

            } else {
              // user role is 'user'
                echo $this->render('_user', ['exercices' => $exercices, 'realisations' => $realisations]);
            }
            ?>
            
            <?php
            // otherwise (other or unknown roles)
                endif;
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
