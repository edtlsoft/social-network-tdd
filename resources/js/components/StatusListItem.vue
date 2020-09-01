<template>
    <div class="card mb-3 border-0 shadow-sm">
        <div class="card-body d-flex flex-column">
            <div class="d-flex align-items-center mb-3">
                <div>
                    <img class="rounded mr-3 shadow-sm" :src="status.user_avatar" alt="user-profile" width="40px">
                </div>
                <div>
                    <h5 class="mb-1" v-text="status.user_name"></h5>
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

            <div v-for="comment in comments" :key="comment.id" class="mb-3">
                <div class="d-flex">
                    <img class="rounded shadow-sm mr-2" width="35" height="35" :src="comment.user_avatar" :alt="comment.user_name">
                    <div class="flex-grow-1">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-2 text-secondary">
                                <a href="#">
                                    <strong>{{ comment.user_name }}</strong>
                                </a>
                                {{ comment.body }}
                            </div>
                        </div>
                        <small
                            class="float-right badge badge-pill badge-primary py-1 px-2 mt-1"
                            dusk="comment-likes-count"
                        >
                            <i class="fas fa-thumbs-up"></i>
                            {{ comment.likes_count }}
                        </small>
                        <like-btn
                            dusk="comment-like-btn"
                            :model="comment"
                            :url="`/comments/${comment.id}/likes`"
                            class="comment-like-btn"
                        >
                        </like-btn>
                    </div>
                </div>
            </div>

            <form @submit.prevent="storeComment" v-if="isAuthenticated">
                <div class="d-flex aling-items-center">
                    <img class="rounded shadow-sm mr-2"
                         width="35" src="/images/default-avatar.jpg"
                         :alt="currentUser.name"
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

export default {
    props: {
        status: {
            type: Object,
            required: true,
        }
    },
    components: {
        LikeBtn,
    },
    data() {
        return ({
            comment: '',
            comments: this.status.comments,
        })
    },
    methods: {
        storeComment() {
            axios.post(`/statuses/${this.status.id}/comments`, {
                body: this.comment
            })
            .then(response => {
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
