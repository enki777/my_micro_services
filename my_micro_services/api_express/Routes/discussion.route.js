let express = require('express');
let router = express.Router();
const { FindAllDiscussion, CreateDiscussion, FindOneDiscussion, DeleteDiscussion } = require('../Controllers/discussion.controller');

router.post('/index', function (req, res) {
    FindAllDiscussion(req, res)
    // res.send('Wiki home page');
})

router.post('/create', function (req, res) {
    CreateDiscussion(req, res);
})

router.post('/find/:id', function (req, res) {
    FindOneDiscussion(req, res);
})

router.post('/delete/:id', function (req, res) {
    DeleteDiscussion(req, res);
})

module.exports = router;
