<template>
    <button @click="sendFriendshipRequest"
            dusk="request-friendship"
            text="">
        {{ textBtn }}
    </button>
</template>

<script>
export default {
    props: {
        recipient: {
            type: Object,
            required: true
        }
    },
    data() {
        return ({
            textBtn: 'Add Friend',
        })
    },
    methods: {
        sendFriendshipRequest() {
            axios.post(`/friendship/${this.recipient.username}`)
            .then(response => {
                this.textBtn = 'Cancel'
            })
            .catch(errors => console.log(errors))
        }
    }
}
</script>

<style scoped>

</style>
