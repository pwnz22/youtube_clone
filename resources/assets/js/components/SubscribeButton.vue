<template>
    <div class="subscribe-button" v-if="subscribers !== null">
        {{ subscribers }} subscribers &nbsp;
        <button class="btn btn-xs btn-default" v-if="canSubscribe" @click.prevent="handle">{{ userSubscribed ? 'Unsubscribe' : 'Subscribe' }}</button>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                subscribers: null,
                userSubscribed: false,
                canSubscribe: false
            }
        },

        props: {
            channelSlug: null
        },

        methods: {
            getSubscriptionStatus() {
                axios.get(`/subscription/${this.channelSlug}`)
                    .then(response => {
                        this.subscribers = response.data.count
                        this.userSubscribed = response.data.user_subscribed
                        this.canSubscribe = response.data.can_subscribed
                    })
            },

            handle() {
                if (this.userSubscribed)
                    this.unsubscribe()
                else
                    this.subscribe()
            },

            subscribe() {
                this.userSubscribed = true
                this.subscribers++
                axios.post(`/subscription/${this.channelSlug}`)
            },

            unsubscribe() {
                this.userSubscribed = false
                this.subscribers--
                axios.delete(`/subscription/${this.channelSlug}`)
            }

        },
        mounted() {
            this.getSubscriptionStatus()
        }
    }
</script>