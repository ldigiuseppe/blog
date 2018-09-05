<template>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="float-left">
                    <a class="btn btn-primary btn-sm" href="/posts"> Open without Vue.js</a>
                </div>
                <div class="float-right" v-if="user">
                    <button @click="initAddPost()" class="btn btn-primary btn-xs pull-right">Create New Post</button>
                </div>
            </div>
        </div>

        <div id="newPost" style="display: none" v-if="user">
            <div class="alert alert-danger" v-if="errors.length > 0">
                <ul>
                    <li v-for="error in errors">{{ error }}</li>
                </ul>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Title:</strong>
                        <input type="text" name="title" class="form-control" placeholder="Title" value="" v-model="posts.title">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Body:</strong>
                        <textarea id="summernote" class="form-control" style="height:300px" name="body" placeholder="Body" v-model="posts.body"></textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="button" @click="cancelPost" class="btn btn-default" >Cancel</button>
                    <button type="button" @click="createPost" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>

        <div v-if="posts.length > 0">
            <div class="card mt-2" v-for="(post, index) in posts">
                <div class="card-body">
                    <h5 class="card-title">{{ post.title }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{ post.created_at }} <b> by {{ post.created_by }} </b></h6>
                    <p class="card-text">
                        <div v-html="post.body"> </div>
                    </p>
                    <div v-if="user" class="float-right">
                        <!--button @click="updateForm(index)" class="btn btn-primary btn-sm">Edit</button-->
                        <button @click="deletePost(index)" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this post?');">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        <p v-else>No posts yet</p>
    </div>
</template>





<script>
    export default {
        data(){
            return {
                posts: {
                    title: '',
                    body: ''
                },
                errors: [],
                posts: [],
                update_post: {},
                user: ''
            }
        },
        mounted()
        {
            this.readPosts();
            this.user = window.Laravel.user;
        },
        methods: {
            readPosts()
            {
                axios.get('/readPosts')
                    .then(response => {
                        this.posts = response.data.posts;
                    });
            },

            initAddPost()
            {
                this.errors = [];
                $("#newPost").show();
            },

            createPost()
            {  
                console.log(this.posts.title);
                console.log(this.posts);

                axios.post('/createPosts', {
                    title: this.posts.title,
                    body: this.posts.body,
                })
                    .then(response => {
                        this.posts.unshift(response.data.post);
                        this.posts.title = '';
                        this.posts.body = '';
                        this.errors = [];
                        $("#newPost").hide();

                    })
                    .catch(error => {
                        this.errors = [];
                        if (error.response.data.errors.title) {
                            this.errors.push(error.response.data.errors.title[0]);
                        }

                        if (error.response.data.errors.body) {
                            this.errors.push(error.response.data.errors.body[0]);
                        }
                    });
            },

            cancelPost()
            {
                this.posts.title = '';
                this.posts.body = '';
                this.errors = [];
                $("#newPost").hide();

            },

            deletePost(index)
            {
                axios.delete('/deletePosts/' + this.posts[index]._id)
                    .then(response => {
                        this.posts.splice(index, 1);
                    })
                    .catch(error => {

                    });
            },
            
        }
    }
</script>