let user = window.App.user

module.exports = {
    owner (model, prop = 'user_id') {
        return model[prop] == user.id
    },
    isAdmin () {
        return ['dc'].includes(user.name)
    }
}
