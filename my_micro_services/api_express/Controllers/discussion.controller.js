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
    const id = req.params.id

    const discussion = await Discussion.findByIdAndUpdate(id)

    discussion.titre = req.body.titre
    await discussion.save()
        .then(() => res.status(201).json(discussion))
        .catch(err => res.status(400).json('Error Message pas envoyer avec succes ' + err))

};

const DeleteDiscussion = async (req, res) => {
    const id = req.params.id

    Discussion.findByIdAndDelete(id)
        .then(() => res.status(201).json("discussion supprimée avec succès."))
        .catch(err => res.status(400).json('Error Message pas envoyer avec succes ' + err))
};

module.exports = { FindAllDiscussion, FindOneDiscussion, CreateDiscussion, UpdateDiscussion, DeleteDiscussion };