var ApiBuilder = require('claudia-api-builder'),
  api = new ApiBuilder();
var Promise = require("bluebird");
var Slack = require('node-slack');
var AWS = require('aws-sdk');
AWS.config.region = 'us-west-2';

var url = {
	'the-club':"https://hooks.slack.com/services/AAAAAAAA/BBBBBBB/ASDFASDFASDF",
	'eng':"https://hooks.slack.com/services/AAAAAAAA/BBBBBBB/ASDFASDFASDF"
};

module.exports = api;

api.get('/hello2/{id}', function (request) {
	'use strict';
	var id = request.pathParams.id;
	return 'Hello thing known as ' + id;
});

api.get('/hello', function () {
	'use strict';
	return 'Hello!';
});


api.post('/bridge/{room}', function (request) {
	'use strict';
	var room = request.pathParams.room;
	if(room in url){
		//var slack = Promise.promisifyAll(new Slack(url[room]));
		var msg = request.body.item.message;
		console.log("["+room+"] "+msg.from.name+": "+msg.message);

  //  var stringmsg = JSON.stringify(request);
    var sns = new AWS.SNS();
    sns.publish({
      Message: msg.message,
      TopicArn: 'arn:aws:sns:us-west-2:1111111111:topic1',
    }, function(err, data) {
      if (err) {
        console.log("error");
          console.log(err.stack);
          return true;
      }else{
        console.log("push sent");
        return true;
      }
    });
	}else{
		console.log("invalid room");
		return true;
	}
});



api.post('/simplebridge/{room}', function (request) {
	'use strict';
	var room = request.pathParams.room;
	if(room in url){
		var slack = Promise.promisifyAll(new Slack(url[room]));
		var msg = request.body.item.message;
		console.log("["+room+"] "+msg.from.name+": "+msg.message);
		return slack.send({
			username: msg.from.name,
			channel: '#'+room,
			text: msg.message
		}).then(function(){
			console.log("then");
			});
	}else{
		console.log("invalid room");
		return true;
	}
});
