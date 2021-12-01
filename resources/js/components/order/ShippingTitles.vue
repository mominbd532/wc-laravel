<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-12">

                    <div class="card" v-if="$gate.isAdmin()">
                        <div class="card-header">
                            <h3 class="card-title">Shipping Titles List</h3>

                            <div class="card-tools">

                                <button type="button" class="btn btn-sm btn-primary" @click="newModal">
                                    <i class="fa fa-plus-square"></i>
                                    Add New
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="title in titles" :key="title.id">

                                    <td>{{title.id}}</td>
                                    <td class="text-capitalize">{{title.ship_title}}</td>
                                    <td>

                                        <a href="#" @click="editModal(title)">
                                            <i class="fa fa-edit blue"></i>
                                        </a>
                                        <a href="#" @click="deleteTitles(title.id)">
                                            <i class="fa fa-trash red"></i>
                                        </a>

                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <!--<div class="card-footer">-->
                        <!--<pagination :data="categories" @pagination-change-page="getResults"></pagination>-->
                        <!--</div>-->
                    </div>
                    <!-- /.card -->
                </div>
            </div>


            <div v-if="!$gate.isAdmin()">
                <not-found></not-found>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" v-show="!editmode">Create New Shipping Titles</h5>
                            <h5 class="modal-title" v-show="editmode">Update Shipping Titles</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <!-- <form @submit.prevent="createUser"> -->

                        <form @submit.prevent="editmode ? updateTitles() : createTitles()">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input v-model="form.ship_title" type="text" name="ship_title"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('ship_title') }">
                                    <has-error :form="form" field="ship_title"></has-error>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                                <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        data () {
            return {
                editmode: false,
                titles : {},
                form: new Form({
                    id : '',
                    ship_title: ''
                })
            }
        },
        methods: {

            getResults(page = 1) {

                this.$Progress.start();

                axios.get('/api/shipping-titles?page=' + page).then(({ data }) => (this.titles = data.data));

                this.$Progress.finish();
            },
            updateTitles(){
                this.$Progress.start();
                this.form.put('/api/shipping-titles/'+this.form.id)
                    .then((response) => {
                        // success
                        $('#addNew').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: response.data.message
                        });
                        this.$Progress.finish();
                        //  Fire.$emit('AfterCreate');

                        this.loadTitles();
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    });

            },
            editModal(title){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(title);
            },
            newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },

            loadTitles(){
                if(this.$gate.isAdmin()){
                    axios.get("/api/shipping-titles").then(({ data }) => (this.titles = data));
                }
            },

            createTitles(){

                this.form.post('/api/shipping-titles')
                    .then((response)=>{
                        $('#addNew').modal('hide');

                        Toast.fire({
                            icon: 'success',
                            title: response.data.message
                        });

                        this.$Progress.finish();
                        this.loadTitles();
                    })
                    .catch(()=>{
                        Toast.fire({
                            icon: 'error',
                            title: 'Some error occured! Please try again'
                        });
                    })
            },

            deleteTitles(id){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {

                    // Send request to the server
                    if (result.value) {
                        this.form.delete('api/shipping-titles/'+id).then(()=>{
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            );
                            // Fire.$emit('AfterCreate');
                            this.loadTitles();
                        }).catch((data)=> {
                            Swal.fire("Failed!", data.message, "warning");
                        });
                    }
                })

            }

        },
        mounted() {
            console.log('Component mounted.')
        },
        created() {

            this.$Progress.start();
            this.loadTitles();
            this.$Progress.finish();
        }
    }
</script>
