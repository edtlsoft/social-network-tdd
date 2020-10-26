<template>
    <div>
        <div v-for="comment in comments" :key="comment.id" class="mb-3">
            <div class="d-flex">
                <img class="rounded shadow-sm mr-2" width="35" height="35" :src="comment.user.avatar" :alt="comment.user.name">
                <div class="flex-grow-1">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-2 text-secondary">
                            <a :href="comment.user.link">
                                <strong>{{ comment.user.username }}</strong>
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
    </div>
</template>

<script>

import LikeBtn from './LikeBtn'

export default {
    props: {
        comments: {
            type: Array,
            required: true
        },
        statusId: {
            type: Number,
            required: true
        }
    },
    components: {
        LikeBtn,
    },
    mounted() {
        Echo.channel(`statuses.${this.statusId}.comments`)
            .listen(
                'CommentCreated',
                event => {
                    console.log(event, event.comment);
                    this.comments.push(event.comment);
                }
            )

        EventBus.$on(`statuses.${this.statusId}.comments`, comment => this.comments.push(comment))
    },

}
</script>

<style scoped>

</style>
