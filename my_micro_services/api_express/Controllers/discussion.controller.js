const express = require('express');
const mongoose = require('mongoose');
const Discussion = require('../Models/discussion.model.js');

const FindAllDiscussion = async (req, res) => {
    const discussions = await Discussion.find();
    res.json(discussions);
};

const FindOneDiscussion = async (req, res) => {
    const id = req.params.id;
    const discussion = await Discussion.findById(id)
    res.json(discussion)
};

const CreateDiscussion = async (req, res) => {
    const discussion = new Discussion({
        titre: req.body.titre,
    });

    await discussion.save()
        .then(() => res.status(201).json(discussion))
        .catch(err => res.status(400).json('Error Message pas envoyer avec succes ' + err))
};

const UpdateDiscussion = async (req, res) => {

};

const DeleteDiscussion = async (req, res) => {
    const id = req.params.id
    // const q = Discussion.findByIdAndDelete(id, () => {})
    Discussion.findByIdAndDelete(id).exec()
    // q.status(201).json("discussion supprimée avec succès.")
    // q.then(() => res.status(201).json(q.titre))
    res.status(201).json("discussion supprimée avec succès.")
};

module.exports = { FindAllDiscussion, FindOneDiscussion, CreateDiscussion, UpdateDiscussion, DeleteDiscussion };