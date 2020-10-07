<template>
    <div class="d-flex justify-content-between">
        <span v-text="sender.username"></span>
        <div v-if="localFriendshipStatus === 'pending'">
            <button dusk="accept-friendship" @click="acceptFriendshipRequest">Confirm</button>
            <button dusk="deny-friendship" @click="denyFriendshipRequest">Deny</button>
        </div>
        <div v-else-if="localFriendshipStatus === 'accepted'">
            <span>Friends</span>
        </div>
        <div v-else-if="localFriendshipStatus === 'denied'">
            <span>Request denied</span>
        </div>
        <div v-if="localFriendshipStatus === 'deleted'">
            <span>Request removed</span>
        </div>
        <div v-else>
            <button dusk="delete-friendship" @click="deleteFriendshipRequest">Delete</button>
        </div>
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
                    this.localFriendshipStatus = response.data.friendship_status
                })
                .catch(error => console.log(error))
        },
        denyFriendshipRequest() {
            axios.delete(`/accept-friendships/${this.sender.username}`)
                .then(response => {
                    this.localFriendshipStatus = response.data.friendship_status
                })
                .catch(error => console.log(error))
        },
        deleteFriendshipRequest() {
            axios.delete(`/friendships/${this.sender.username}`)
                .then(response => {
                    this.localFriendshipStatus = response.data.friendship_status
                })
                .catch(error => console.log(error))
        },

    }
}
</script>

<style scoped>

</style>
