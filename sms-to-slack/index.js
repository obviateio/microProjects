var ApiBuilder = require('claudia-api-builder'),
  api = new ApiBuilder();
var rp = require('request-promise');

var map =  "";


module.exports = api;

api.get('/hello', function () {
	'use strict';
	return 'Hello!';
});


api.post('/sendmsg', function (request) {
  'use strict';
  console.log("\nTo: "+request.post.To+"\nFrom: "+request.post.From+"\nBody: "+request.post.Body);

    return rp.post(map,
      {
        headers: {'Content-type':'application/json'},
        body: JSON.stringify({
          'icon_emoji': ":iphone:",
          username: "SMS"+request.post.From,
          channel: '#fish-club',
          text: request.post.Body
        })
      })
      .then(function(err,resp,body){
        console.log("Back from request");
      })
      .then(function(){
        console.log("Before end");
        return "Sent to Slack";
      });

}, {
  success: { contentType: 'text/plain' },
  error: {code: 403}
});
