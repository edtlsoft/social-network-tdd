<template>
    <button @click="toggleFriendshipStatus"
            text="">
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
            return this.localFriendshipStatus === 'pending' ? 'Cancel' : 'Add friend'
        },
    },
    methods: {
        toggleFriendshipStatus() {
            let method = this.localFriendshipStatus === 'pending' ? 'delete' : 'post'

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
