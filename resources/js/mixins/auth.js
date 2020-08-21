
const user = document.head.querySelector('meta[name="user"]').content

export default {
    computed: {
        currentUser() {
            return this.isAuthenticated
                    ? JSON.parse(user)
                    : { name: 'Usuario invitado' }
        },
        isAuthenticated() {
            return !! user
        },
        guest() {
            return ! this.isAuthenticated
        },
    },
    methods: {
        redirectIfGuest() {
            if( this.guest ){
                window.location.href = '/login'
            }
        },
    },
}
