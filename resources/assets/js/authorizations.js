let user = window.App.user

module.exports = {
    updateReply (reply) {
        return this.updateModel(reply)
    },
    updateThread (thread) {
        return this.updateModel(thread)
    },
    updateModel (model, prop = 'user_id') {
        return model[prop] == user.id
    }
}
