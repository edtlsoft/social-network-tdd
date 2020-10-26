<template>
    <div class="card mb-3 border-0 shadow-sm">
        <div class="card-body d-flex flex-column">
            <div class="d-flex align-items-center mb-3">
                <div>
                    <img class="rounded mr-3 shadow-sm" :src="status.user.avatar" alt="user-profile" width="40px">
                </div>
                <div>
                    <h5 class="mb-1">
                        <a :href="status.user.link" v-text="status.user.username"></a>
                    </h5>
                    <div class="small text-muted" v-text="status.ago"></div>
                </div>
            </div>
            <div>
                <p class="card-text text-secondary" v-text="status.body"></p>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between align-items-center">
            <like-btn
                dusk="status-like-btn"
                :model="status"
                :url="`/statuses/${status.id}/likes`"
            >
            </like-btn>

            <div class="text-secondary mr-2">
                <i class="far fa-thumbs-up"></i>
                <span dusk="likes-count">{{ status.likes_count }}</span>
            </div>
        </div>
        <div class="card-footer">
            <comment-list
                :comments="status.comments"
                :status-id="status.id"
            >
            </comment-list>

            <form @submit.prevent="storeComment" v-if="isAuthenticated">
                <div class="d-flex aling-items-center">
                    <img class="rounded shadow-sm mr-2"
                         width="35" :src="status.user.avatar"
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
        </div>
    </div>
</template>

<script>

import LikeBtn from './LikeBtn'
import CommentList from './CommentList'

export default {
    props: {
        status: {
            type: Object,
            required: true,
        }
    },
    components: {
        LikeBtn,
        CommentList,
    },
    data() {
        return ({
            comment: '',
        })
    },
    methods: {
        storeComment() {
            axios.post(`/statuses/${this.status.id}/comments`, {
                body: this.comment
            })
            .then(response => {
                EventBus.$emit(`statuses.${this.status.id}.comments`, response.data.data)

                this.comments.push(response.data.data)
                this.comment = ''
            })
            .catch(errors => console.log(errors))
        },
    },

}
</script>

<style scoped>

</style>
