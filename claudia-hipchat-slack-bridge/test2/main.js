exports.handler = function (event, context) {
  'use strict';
  console.log("From SNS: " + event.Records[0].Sns.Message);
  context.succeed();
};
