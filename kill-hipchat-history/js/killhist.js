var count = 0;
var done = false;
var intCount = 0;

var total = $( ".delete" ).each(function( index, obj ) {
  var url = $(this).find('form').attr('action');
  var xsrf = $(this).find('input[name=xsrf_token]').attr('value');
  var msgid = $(this).find('input[name=message_id]').attr('value');
  var msgin = $(this).find('input[name=message_index]').attr('value');
  ++count;
  $.ajax({
  	method: "POST",
  	url: url,
  	data: {"xsrf_token": xsrf, "message_id" : msgid, "message_index": msgin, "action": "delete"},
  	dataType: "html",
  	complete: function ( msg ) {
      --count;
      if(index == total - 1){ done = true;}
  	}
  });
}).length;

if(total == 0){
  done=true;
}

var morenext = $(".aui-nav-next a");
if( morenext.length > 0 ){
  console.log("next");
}

setInterval(function() {  
  console.log("tick " + intCount + " -- Done? " + done);
  ++intCount;
  if(done || intCount > 8){
    // Yes, is done
    if(morenext.length > 0){
        // There's a next
        $(".aui-nav-next a")[0].click();
        console.log("Next page, same day");
    }else{
        // No next, go to prev day
        $(".historynav .aui-buttons a")[0].click();
        console.log("Goto Previous Day");
    }
  }


  }, 1000);
