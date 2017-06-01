 
function t142_checkSize(recid){
  var el=$("#rec"+recid).find(".t142__submit");
  if(el.length){
    var btnheight = el.height() + 5;
    var textheight = el[0].scrollHeight;
    if (btnheight < textheight) {
      var btntext = el.text();
      el.addClass("t142__submit-overflowed");
      el.html("<span class=\"t142__text\">" + btntext + "</span>");
    }
  }
} 
function t330_showPopup(recid){
  var el=$('#rec'+recid).find('.t330');
  $('body').addClass('t330__body_popupshowed');
  if(el.find('.t330__popup').attr('style') && el.find('.t330__popup').attr('style') > '') {
    el.find('.t330__popup').attr('style','');
  }
  el.addClass('t330__popup_show');
  el.find('.t330__close, .t330__content, .t330__bg').click(function(){
  t330_closePopup();
  });
  $('.t330__mainblock').click(function( event ) {
    event.stopPropagation();
  });
  $(document).keydown(function(e) {
    if (e.keyCode == 27) {
     $('body').removeClass('t330__body_popupshowed');
      $('.t330').removeClass('t330__popup_show');
    }
});
}

function t330_closePopup(){
  $('body').removeClass('t330__body_popupshowed');
  $('.t330').removeClass('t330__popup_show');
  $('.t330__mainblock').click(function( event ) {
    event.stopPropagation();
  });
}

function t330_resizePopup(recid){
  var el = $("#rec"+recid);
  var div = el.find(".t330__mainblock").height();
  var win = $(window).height() - 170;
  var popup = el.find(".t330__content");
  if (div > win ) {
    popup.addClass('t330__content_static');
  }
  else {
    popup.removeClass('t330__content_static');
  }
}

function t330_initPopup(recid){
  var el=$('#rec'+recid).find('.t330');
  var hook=el.attr('data-tooltip-hook');
  if(hook!==''){
      var obj = $('a[href="'+hook+'"]');
      obj.click(function(e){
        t330_showPopup(recid);
        t330_resizePopup(recid);
        e.preventDefault();
      });
  }
}