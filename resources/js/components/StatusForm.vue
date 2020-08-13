<template>
    <div>
        <form v-if="isAuthenticated" @submit.prevent="storeStatus">
            <div class="card-body">
                <textarea v-model="status.body" class="form-control border-0 bg-light" name="body" id="body"
                          :placeholder="`What's on your mind, ${currentUser.name}?`">
                </textarea>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary" id="create-status">Publish</button>
            </div>
        </form>
        <div v-else class="card-body">
            <a href="/login">Debes hacer login</a>
        </div>
    </div>
</template>

<script>
    export default {
        data: function() {
            return ({
                status: {
                    body: '',
                },
            })
        },
        methods: {
            storeStatus() {
                axios.post('/statuses', this.status)
                    .then(response => {
                        EventBus.$emit('status-created', response.data.data)
                        this.status.body = ''
                    })
                    .catch(errors => console.log(errors))
            }
        },
    }
</script>

<style scoped>

</style>
