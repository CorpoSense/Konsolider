<?php use yii\helpers\Url; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.1/css/bulma.min.css" />
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/all.js" integrity="sha384-xymdQtn1n3lH2wcu0qhcdaOpQwyoarkgLVxC/wZ5q7h9gHtxICrpcaSUfygqZGOe" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/fontawesome-all.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    
</head>
<body style="background-color:#F5F5F5">
    <div class="columns" style="background-color:#F5F5F5">

    <!-- La premiere colonne qui contient les inputs et tout !-->   
        
        <div class="column is-half " >

            <article class="" style="margin-top:50px;margin-left:120px;padding-right:px;height:px;padding-top:40px;border-radius:%;width:600px;background-color:">

            <div class="">
    <!-- L'image CETIM !-->
                
                <div class="" style="padding-left:265px;">
                  
                    <img src="<?= Url::to('@web/assets/img/cetim.png')?>" style="height:100px;width:120px;border-radius:50%;margin-bottom:40px;margin-left:px;padding-left:px;">
                </div>
    <!-- Le message BIENVENUE !-->              
                <div class="field" style="padding-left:45px;">  
                    <span class="tag is-primary is-medium" style="margin-left:130px;width:299px;" >Bienvenue !</span>
                    
                </div>

                
            
            
            </div>  
        <form method="POST" action="<?= ?>">
          <!-- Les INPUTS !-->    
        <div class="section" style="background-color:">
          <div class="">

          <!-- MATRICULEE !-->

            <div class="field" style="padding-left:150px;">
              <p class="control has-icons-left has-icons-right">
                  <input class="input" name="email"type="text" placeholder="Matricule" style="margin-bottom:10px;width:300px;">
          <!-- ICONE MATRICULE !-->       
                    <span class="icon is-small is-left">
                      <i class="fas fa-id-badge"></i>
                    </span>
              </p>        
          </div>
        
          <!-- PASSWORD !-->
          <div class="field" style="padding-left:150px;">
            <p class="control has-icons-left has-icons-right">        
              <input class="input" name="pass" type="password" placeholder="Passowrd" style="margin-bottom:20px;width:300px;">
          <!-- ICONE PASSWORD !-->    
                <span class="icon is-small is-left">
                  <i class="fas fa-unlock"></i>
                </span> 
            </p>    
          </div>
          <!-- BOUTTON SE CONNECTER !-->
          <div class="field" style="padding-left:150px;">
            <p class="control has-icons-left has-icons-right">

              <button type="submit" class="button is-info">Se connecter</button>
            
            </p>  
          </div>  
 
      
        </div>            

      </div>
    </article>
  </div>
          
        </form>
    

<!-- L'image TYPEWRITER !-->
    <div class="column" style="background-color:#F5F5F5">
        <article class="" style=" background-color:;margin-top:50px;margin-right:00px;margin-left:200px;padding-bottom:-5px;">
            <img src="<?= Url::to('@web/assets/img/typewriter.jpg')?>" style="width:380px;height:480px;">
        </article>  
    </div>
    <!--partie verfication des données-->
  
   
    
    

</body>
</html>