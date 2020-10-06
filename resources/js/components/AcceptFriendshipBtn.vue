<template>
    <div v-if="localFriendshipStatus === 'pending'">
        <button dusk="accept-friendship" @click="acceptFriendshipRequest">Confirm</button>
    </div>
    <div v-else>
        <button>Friends</button>
    </div>
</template>

<script>
export default {
    props: {
        sender: {
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
    methods: {
        acceptFriendshipRequest() {
            axios.post(`/accept-friendships/${this.sender.username}`)
                .then(response => {
                    this.localFriendshipStatus = 'accepted'
                })
                .catch(error => console.log(error))
        },
    }
}
</script>

<style scoped>

</style>
