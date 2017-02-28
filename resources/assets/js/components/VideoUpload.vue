<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Upload</div>

                    <div class="panel-body">
                        <input type="file" name="video" id="video" @change="fileInputChange" v-if="!uploading">

                        <div class="alert alert-danger" v-if="failed">Something went wrong. Please try again.</div>

                        <div id="video-form" v-if="uploading && !failed">
                            <div class="alert alert-info" v-if="!uploadingComplete">
                                Your video will be available at <a :href="$root.config.url/videos/uid" target="_blank">{{ $root.config.url }}/videos/{{ uid }}</a>.
                            </div>

                            <div class="alert alert-info" v-if="uploadingComplete">
                                Upload complete. Video is now processing.
                                <a href="/videos">Go to your videos</a>.
                            </div>

                            <div class="progress" v-if="!uploadingComplete">
                                <div class="progress-bar" :style="{ width: fileProgress + '%' }"></div>
                            </div>

                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" v-model="title">
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" v-model="description"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="visibility">Description</label>
                                <select class="form-control" v-model="visibility">
                                    <option value="private">Private</option>
                                    <option value="unlisted">Unlisted</option>
                                    <option value="public">Public</option>
                                </select>
                            </div>

                            <span class="help-block pull-right">{{ saveStatus }}</span>

                            <button class="btn btn-default" type="submit" @click.prevent="update">Save changes</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        data() {
            return {
                uid: null,
                uploading: false,
                uploadingComplete: false,
                failed: false,
                title: 'Untitled',
                description: null,
                visibility: 'private',
                saveStatus: null,
                fileProgress: 0
            }
        },

        methods: {
            fileInputChange() {
                this.uploading = true
                this.failed = false

                this.file = document.getElementById('video').files[0]

                this.store().then(() => {
                    let form = new FormData()

                    form.append('video', this.file)
                    form.append('uid', this.uid)

                    axios.post('/upload', form, {
                        onUploadProgress: (e) => {
                            if(e.lengthComputable) {
                                this.updateProgress(e)
                            }
                        }
                    }).then(() => {
                        this.uploadingComplete = true
                    }, () => {
                        this.failed = true
                    })
                }, () => {
                    this.failed = true
                })
            },

            store() {
                return axios.post('/video', {
                    title: this.title,
                    description: this.description,
                    visibility: this.visibility,
                    extension: this.file.name.split('.').pop()
                }).then((response) => {
                    console.log(response)
                    this.uid = response.data.data.uid
                })
            },

            update() {
                this.saveStatus = 'Saving changes.'
                return axios.post('/videos/' + this.uid, {
                    title: this.title,
                    description: this.description,
                    visibility: this.visibility
                }).then(response => {
                    this.saveStatus = 'Changes saved.'
                    setTimeout(() => {
                        this.saveStatus = null
                    }, 3000)
                }, () => {
                    this.saveStatus = 'Failed to save changes.'
                })
            },

            updateProgress(e) {
                e.percent = (e.loaded / e.total) * 100
                this.fileProgress = e.percent
            }
        },

        mounted() {
            window.onbeforeunload = () => {
                if (this.uploading && !this.uploadingComplete && !this.failed) {
                    return 'Are you sure you want to navigate away?'
                }
            }
        }
    }
</script>