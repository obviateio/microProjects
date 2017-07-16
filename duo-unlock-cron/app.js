var Client = require('duo-api');
var conf = require("./config.json");
var client = new Client({
    host: conf.host,
    ikey: conf.ikey,
    skey: conf.skey
});

setInterval(unlockThem,5*60*1000);

function unlockHenry(){
  var date = new Date();
  client.request('get', '/admin/v1/users', {username: 'USER@DOMAIN.TLD'}, function(error, res) {
    if(res.response[0].status == "active"){
      console.log(date.toISOString() + " active");
    }else{
      console.log(date.toISOString() + " reactivating");
      client.request('post', '/admin/v1/users/'+res.response[0].user_id, {status:'active'}, function(error, res) {
        if(error == null){
          console.log(date.toISOString() + " OK!");
        }
      });
    }
  });
}
