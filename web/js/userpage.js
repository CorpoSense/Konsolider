$(function () {

  $('.check-all').change(function(){
      var canevasId = $(this).attr('data-value');
      var checkboxes = $('.check-mesure-'+canevasId);
      checkboxes.prop('checked', $(this).prop('checked'));
      checkboxes.prop('disabled', $(this).prop('checked'));
  });

  $('.mesure-input').change(function(){
      updateRate($(this));
  });
  
  $('form[data-async]').submit(function(event) {
      var $form = $(this);
      var $action = $form.attr('action');
      var formData = $form.serialize();      
      console.log(formData);
      $.post($action, formData).done(function(data){
          if (data == '' || data == null || data.length == 0){
              console.log(data);
          } else {
//               console.log('data.length: ', data.length);
               console.log('data: ', data);
               if (data === '1'){
                   $form.find('.mesure-input').prop('disabled', 'disabled');
                   $form.find('.btn-validate').prop('disabled', 'disabled');
               }
               
          }
      });
      event.preventDefault();
      
  });

  function updateRate(el){
  var id = $(el).attr('data-value');
      var result = '-';
      try {
          var forecast = parseFloat( $('#prevue-'+id).val() );
          var real =  parseFloat( $('#realise-'+id).val() );
          result = parseFloat( (real / forecast)*100 ).toFixed(1);
      } catch (e){
          result = '-';
      }
      $('#rate-mesure-input-'+id).text( isNaN(result)?'-':(result + '%') );

  }

});
