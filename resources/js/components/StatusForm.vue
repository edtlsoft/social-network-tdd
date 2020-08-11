<template>
    <div>
        <form @submit.prevent="storeStatus">
            <div class="card-body">
                <textarea v-model="status.body" class="form-control border-0 bg-light" name="body" id="body" placeholder="What's on your mind, Edward?"></textarea>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary" id="create-status">Publish</button>
            </div>
        </form>
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
                        EventBus.$emit('status-created', response.data)
                        this.status.body = ''
                    })
                    .catch(errors => console.log(errors))
            }
        },
    }
</script>

<style scoped>

</style>
