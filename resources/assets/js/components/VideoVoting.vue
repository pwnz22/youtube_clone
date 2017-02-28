<template>
    <div class="video-voting">
        <div class="video__voting">
            <a href="" class="video__voting-button"
            :class="{ 'video__voting-button--voted': userVote == 'up' }" @click.prevent="vote('up')">
                <span class="glyphicon glyphicon-thumbs-up"></span>
            </a> {{ up }} &nbsp;

            <a href="" class="video__voting-button"
            :class="{ 'video__voting-button--voted': userVote == 'down' }"  @click.prevent="vote('down')">
                <span class="glyphicon glyphicon-thumbs-down"></span>
            </a> {{ down }} &nbsp;
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                up: 0,
                down: 0,
                userVote: null,
                canVote: false
            }
        },
        methods: {
            getVotes() {
                axios.get(`/videos/${this.videoUid}/votes`)
                    .then(response => {
                        this.up = response.data.up
                        this.down = response.data.down
                        this.userVote = response.data.user_vote
                        this.canVote = response.data.can_vote
                    })
            },

            vote(type) {
                if (this.userVote == type) {
                    this[type]--
                    this.userVote = null
                    this.deleteVote(type)
                    return
                }

                if (this.userVote ) {
                    this[type == 'up' ? 'down' : 'up']--
                }

                this[type]++
                this.userVote = type
                this.createVote(type)
            },

            deleteVote(type) {
                axios.delete(`/videos/${this.videoUid}/votes`)
            },

            createVote(type) {
                axios.post(`/videos/${this.videoUid}/votes`, { type })
            }
        },
        props: {
            videoUid: null
        },
        mounted() {
            this.getVotes()
        }
    }
</script>