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
            <like-btn :status="status"></like-btn>
            <div class="text-secondary mr-2">
                <i class="far fa-thumbs-up"></i>
                <span dusk="likes-count">{{ status.likes_count }}</span>
            </div>
            <form @submit.prevent="storeComment">
                <textarea class="form-control" dusk="comment" v-model="comment"
                ></textarea>
                <button type="submit" dusk="comment-btn">Send </button>
            </form>
            <ul class="list-group">
                <li class="list-group-item" v-for="comment in comments" :key="comment.id">
                    {{ comment.body }}
                </li>
            </ul>
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
            comments: [],
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
        }
    },
}
</script>

<style scoped>

</style>
