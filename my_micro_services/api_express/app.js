const express = require('express');
const bodyParser = require('body-parser');
const mongoose = require('mongoose');
const discussion_route = require('./Routes/discussion.route.js');
require('dotenv').config();


const app = express();
const uri = process.env.ATLAS_URI;

mongoose.connect(uri, { useNewUrlParser: true, useUnifiedTopology: true });
mongoose.Promise = global.Promise;

let db = mongoose.connection;
db.on('error ', console.error.bind(console, 'Erreur de connexion à MongoDB : '));

const urlencodedParser = bodyParser.urlencoded({
    extended: true
});

app.use(function (req, res, next) {
    res.setHeader('Access-Control-Allow-Headers', 'X-Requested-With,content-type');
    res.setHeader('Access-Control-Allow-Origin', '*');
    res.setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, PATCH, DELETE');
    res.setHeader('Access-Control-Allow-Credentials', true);
    next();
});

app.use(bodyParser.json());
app.use(urlencodedParser);
app.use('/', discussion_route);

const port = 5555;
app.listen(port, () => { console.log(`Serveur à l'écoute sur le port : ${port}`); });
