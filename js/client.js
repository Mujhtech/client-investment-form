$('#clientInvestmentFormPlugin').on('submit', function(e){

  e.preventDefault();

  var form = $(this);
  var ajaxurl = form.data('url');
  var name = form.find('#name').val();
  var email = form.find('#email').val();
  var website = form.find('#website').val();
  var investment = form.find('#investment').val();
  var risk = form.find('input[name="chk[]"]:checked').val();
  var comment = form.find('#comment').val();

  if( email === '' ){
    $('#email').parent('.form-group').addClass('has-error');
    return;
  }

  if( investment === '' ){
    $('#investment').parent('.form-group').addClass('has-error');
    return;
  }

  form.find('input, button, textarea').attr('disabled','disabled');
  $('.js-form-submission').addClass('js-show-feedback');


  $.ajax({

    url : ajaxurl,
    type : 'post',
    dataType: 'json',
    data : {

      email : email,
      name : name,
      website : website,
      investment : investment,
      risk : risk,
      comment : comment,
      action: 'client_save_investment_form'

    },
    error : function( response ){
      $('.js-form-submission').removeClass('js-show-feedback');
      $('.js-form-error').addClass('js-show-feedback');
      form.find('input, button, textarea').removeAttr('disabled');
    },
    success : function( response ){
      if( response.success ){
        console.log(response);
        setTimeout(function(){
          $('.js-form-submission').removeClass('js-show-feedback');
          $('.js-form-success').addClass('js-show-feedback');
          form.find('input, button, textarea').removeAttr('disabled');
        },1500);
        setTimeout(function(){
          window.location.href = 'https://blocksociety.net';
        },3000);

      } else {

        setTimeout(function(){
          $('.js-form-submission').removeClass('js-show-feedback');
          $('.js-form-error').addClass('js-show-feedback');
          form.find('input, button, textarea').removeAttr('disabled').val('');
        },1500);

      }
    }

  });

});

var risk = null;
var riskLevel = $("#riskLevel").val();
var investLevel = $("#investLevel").val();
var calcValue = $("#calcValue").val();
if (riskLevel == 'low') {
  var risk = 1;
} else if (riskLevel == 'high') {
  var risk = 3;
} else if (riskLevel == 'moderate') {
  var risk = 2;
}
var totalRecommendInvest = (investLevel * calcValue)/risk;
$("#recommededInvest").html('$' + totalRecommendInvest);
