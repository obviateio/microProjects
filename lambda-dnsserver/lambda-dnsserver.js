var dns = require('native-dns');

exports.handler = function(event, context) {
    console.log("Request received:\n", JSON.stringify(event));
    console.log("Context received:\n", JSON.stringify(context));

    var question = dns.Question({
    name: event.domain,
    type: 'A',
    });

    var start = Date.now();

    var req = dns.Request({
        question: question,
        server: { address: '208.67.222.222', port: 53, type: 'udp' },
        timeout: 1000
    });

    req.on('message', function (err, answer) {
        answer.answer.forEach(function (a) {
            context.succeed(a.address);
            console.log(a.address);
        });
    });

    req.on('end', function () {
        var delta = (Date.now()) - start;
        console.log('Finished processing request: ' + delta.toString() + 'ms');
        context.done();
    });

    req.send();
}
