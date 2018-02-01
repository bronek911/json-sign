$(function(){

  // console.log('abc');

  function colorText(div){

    var verifyStatus = $('.card-response').find(div);
    if(verifyStatus.data('status') == 0){
      verifyStatus.addClass('text-red');
    } else {
      verifyStatus.addClass('text-green');
    }

    console.log(verifyStatus);
  }

  colorText('.verify');
  colorText('.sign');

  var copyButton = $('.btn-get-sign');

    copyButton.click(function(){

      var $temp = $("<input>");
      $("body").append($temp);
      $temp.val($(this).data('sign')).select();
      document.execCommand("copy");
      $temp.remove();
      // console.log($(this).data('sign'));
    });

  });