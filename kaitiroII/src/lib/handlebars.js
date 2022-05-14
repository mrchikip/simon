const {format} = require('timeago.js');

const helpers = {};

helpers.timeago = (timestamp) => {
    return format(timestamp);
};

var moment = require('moment');
moment().format(); 


module.exports = helpers;

