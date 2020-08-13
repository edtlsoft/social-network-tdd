
const user = document.head.querySelector('meta[name="user"]').content

export default {
    computed: {
        currentUser() {
            return this.isAuthenticated
                    ? JSON.parse(user)
                    : { name: 'Usuario invitado' }
        },
        isAuthenticated() {
            return !! this.user
        },
        guest() {
            return ! this.isAuthenticated
        },
    },
}
