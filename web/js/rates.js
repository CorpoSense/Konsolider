$(function () {

  $('.check-all').change(function(){
      var canevasId = $(this).attr('data-value');
      $('.check-mesure-'+canevasId).prop('checked', $(this).prop('checked'));
  });

  $('.mesure-input').change(function(){
      updateRate($(this));
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
