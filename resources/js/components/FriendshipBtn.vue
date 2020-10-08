<template>
    <button @click="toggleFriendshipStatus">
        {{ getText }}
    </button>
</template>

<script>
export default {
    props: {
        recipient: {
            type: Object,
            required: true
        },
        friendshipStatus: {
            type: String,
            required: true
        }
    },
    data() {
        return ({
            localFriendshipStatus: this.friendshipStatus,
        })
    },
    computed: {
        getText() {
            if( this.localFriendshipStatus === 'pending' ) {
                return "Cancel";
            }
            else if( this.localFriendshipStatus === 'accepted' ) {
                return "Delete";
            }
            else if( this.localFriendshipStatus === 'denied' ) {
                return "Request denied";
            }
            else {
                return "Add friend";
            }
        },
    },
    methods: {
        toggleFriendshipStatus() {
            let method = this.localFriendshipStatus === 'pending' || this.localFriendshipStatus === 'accepted'
                ? 'delete'
                : 'post'

            console.log(method)

            axios[method](`/friendships/${this.recipient.username}`)
            .then(response => {
                this.localFriendshipStatus = response.data.friendship_status
            })
            .catch(errors => console.log(errors))
        }
    }
}
</script>

<style scoped>

</style>
