/*
* People who don't use npm registry....
* npm install usermindinc/node-marketo
*/

var Marketo = require('node-marketo');

var marketo = new Marketo({
  endpoint: 'https://ENDPOINT.mktorest.com/rest',
  identity: 'https://3ENDPOINT.mktorest.com/identity',
  clientId: 'asdf-asdf-asdf-asdf',
  clientSecret: 'secretsecretsecret'
});

//marketo.campaign.describe();
/*marketo.campaign.find('id', [2, 50, 100, 120]).then(function(data, resp) {
  console.log(JSON.stringify(data, null, 4));
});*/

marketo.campaign.byId(1,true).then(function(data, resp) {
  console.log(JSON.stringify(data, null, 4));
});
