const express = require('express');
const router = express.Router();
const app = require("express")();


router.get('/', (req, res) => {
    res.render('index');
    //res.send('Hello World');
});

module.exports = router;