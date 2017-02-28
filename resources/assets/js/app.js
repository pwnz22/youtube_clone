import Vue from 'vue'
require('./bootstrap');

import VideoUpload from './components/VideoUpload.vue'
import VideoPlayer from './components/VideoPlayer.vue'
import VideoVoting from './components/VideoVoting.vue'
import VideoComments from './components/VideoComments.vue'
import SubscribeButton from './components/SubscribeButton.vue'

const app = new Vue({
    el: '#app',
    data: {
        config: window.youtube_clone
    },
    components: {
        VideoUpload,
        VideoPlayer,
        VideoVoting,
        VideoComments,
        SubscribeButton
    }
})