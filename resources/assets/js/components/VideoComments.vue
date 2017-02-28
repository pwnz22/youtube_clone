<template>
    <div class="video-comments">
        <p>{{ comments.length }} comments</p>

        <div class="video-comment clearfix" v-if="userAuthenticated">
            <textarea placeholder="Say something" class="form-control video-comment__input" v-model="body"></textarea>

            <div class="pull-right">
                <button type="submit" class="btn btn-default" @click="createComment">Post</button>
            </div>
        </div>

        <ul class="media-list">
            <li class="media" v-for="comment in comments">
                <div class="media-left">
                    <a :href="'/channel/' + comment.channel.data.slug">
                        <img :src="comment.channel.data.image" :alt="comment.channel.data.name" class="media-object">
                    </a>
                </div>
                <div class="media-body">
                    <a href="'/channel/' + comment.channel.data.slug">
                        {{ comment.channel.data.name }}
                    </a> {{ comment.created_at_human }}
                    <p>{{ comment.body }}</p>

                    <ul class="list-inline">
                        <li v-if="userAuthenticated">
                            <a href="#" @click.prevent="toggleReplyForm(comment.id)">{{ replyFormVisible === comment.id ? 'Cancel' : 'Reply' }}</a>
                        </li>
                        <li>
                            <a href="#" v-if="userId == comment.user_id" @click.prevent="deleteComment(comment.id)">Delete</a>
                        </li>
                    </ul>

                    <div class="video-comment clearfix" v-if="replyFormVisible === comment.id">
                        <textarea class="form-control video-comment__input" v-model="replyBody"></textarea>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-default" @click.prevent="createReply(comment.id)">Post</button>
                        </div>
                    </div>

                    <div class="media" v-for="reply in comment.replies.data">
                        <div class="media-left">
                            <a :href="'/channel/' + reply.channel.data.slug">
                                <img :src="reply.channel.data.image" :alt="reply.channel.data.name" class="media-object">
                            </a>
                        </div>
                        <div class="media-body">
                            <a href="'/channel/' + reply.channel.data.slug">
                                {{ reply.channel.data.name }}
                            </a> {{ reply.created_at_human }}
                            <p>{{ reply.body }}</p>

                            <ul class="list-inline">
                                <li>
                                    <a href="#" v-if="userId == reply.user_id" @click.prevent="deleteComment(reply.id)">Delete</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                comments: [],
                body: null,
                replyBody: '',
                replyFormVisible: null
            }
        },

        props: {
            videoUid: null,
            userAuthenticated: false,
            userId: null
        },

        methods: {
            createReply(commentId) {
                axios.post(`/videos/${this.videoUid}/comments`, { body: this.replyBody, reply_id: commentId })
                    .then(response => {
                        this.getComments()
                        this.replyBody = null
                        this.replyFormVisible = null
                    })
            },

            toggleReplyForm(commentId) {
                this.replyBody = null

                if (this.replyFormVisible === commentId) {
                    this.replyFormVisible = null
                    return
                }
                this.replyFormVisible = commentId
            },

            getComments() {
                axios.get(`/videos/${this.videoUid}/comments`)
                    .then(response => {
                        this.comments = response.data.data
                    })
            },

            createComment() {
                axios.post(`/videos/${this.videoUid}/comments`, {body: this.body})
                    .then(response => {
                        this.getComments()
                        this.body = null
                    })
            },

            deleteComment(commentId) {
                if (!confirm('Are you sure you want to delete this comment?'))
                    return

                this.deleteById(commentId)
                axios.delete(`/videos/${this.videoUid}/comments/${commentId}`).then(response => {
                    console.log('deleted comment');
                })
            },

            deleteById(commentId) {
                this.comments.map((comment, index) => {
                    if (comment.id === commentId) {
                        this.comments.splice(index, 1)
                        return
                    }

                    comment.replies.data.map((reply, index) => {
                        if (reply.id === commentId) {
                            this.comments[index].replies.data.splice(replyIndex, 1)
                            return
                        }
                    })
                })
            }
        },

        mounted() {
            this.getComments()
        }
    }
</script>