// import mongoose from 'mongoose';
const mongoose = require('mongoose');

const DiscussionSchema = new mongoose.Schema({
    // _id: mongoose.Schema.Types.ObjectId,
    titre: {type: String, required: true}, // String is shorthand for {type: String}
    author: String,
    body: String,
    comments: [{ body: String, date: Date }],
    date: { type: Date, default: Date.now },
    hidden: Boolean,
    meta: {
        votes: Number,
        favs: Number
    }
});

DiscussionSchema.methods.speak = function () {
    const greeting = this.titre
        ? "Le titre de la discussion est : " + this.titre
        : "I don't have a name";
    console.log(greeting);
}

const Discussion = mongoose.model('Discussion', DiscussionSchema);
// let maDiscussion = new Discussion({ titre: "la mif" });
// // maDiscussion._id instanceof mongoose.Types.ObjectId;
// maDiscussion.author = "brayan";
// // maDiscussion.speak();

// maDiscussion.save(function (err, maDiscussion) {
//     if (err) { throw err; }
//     console.log('Commentaire ajouté avec succès !');
//     maDiscussion.speak();
//     mongoose.connection.close();
// });

module.exports = Discussion;