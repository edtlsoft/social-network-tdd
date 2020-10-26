<template>
    <form @submit.prevent="storeComment" v-if="isAuthenticated">
        <div class="d-flex aling-items-center">
            <img class="rounded shadow-sm mr-2"
                 width="35" :src="currentUser.avatar"
                 :alt="currentUser.username"
            >
            <div class="input-group">
                        <textarea v-model="comment"
                                  dusk="comment"
                                  class="form-control border-0"
                                  rows="1"
                                  placeholder="Write a comment..."
                                  required
                        ></textarea>
                <div class="input-group-append">
                    <button dusk="comment-btn"
                            type="submit"
                            class="btn btn-primary">
                        Send
                    </button>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
export default {
    props: {
        statusId: {
            type: Number,
            required: true
        }
    },
    data() {
        return ({
            comment: '',
        })
    },
    methods: {
        storeComment() {
            axios.post(`/statuses/${this.statusId}/comments`, {
                body: this.comment
            })
                .then(response => {
                    EventBus.$emit(`statuses.${this.statusId}.comments`, response.data.data)

                    this.comment = ''
                })
                .catch(errors => console.log(errors))
        },
    },
}
</script>

<style scoped>

</style>
