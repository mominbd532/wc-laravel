<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-12">

                    <div class="card" v-if="$gate.isAdmin()">
                        <div class="card-header">
                            <h3 class="card-title">Payment Method List</h3>

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
                                    <th>Name</th>
                                    <th>Method</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="meth in methods" :key="meth.id">

                                    <td>{{meth.id}}</td>
                                    <td class="text-capitalize">{{meth.	pay_name}}</td>
                                    <td>{{meth.method}}</td>
                                    <td>

                                        <a href="#" @click="editModal(meth)">
                                            <i class="fa fa-edit blue"></i>
                                        </a>
                                        <a href="#" @click="deleteMethod(meth.id)">
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
                            <h5 class="modal-title" v-show="!editmode">Create New Payment Method</h5>
                            <h5 class="modal-title" v-show="editmode">Update Payment Method</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <!-- <form @submit.prevent="createUser"> -->

                        <form @submit.prevent="editmode ? updateMethods() : createMethods()">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input v-model="form.pay_name" type="text" name="pay_name"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('pay_name') }">
                                    <has-error :form="form" field="pay_name"></has-error>
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <input v-model="form.method" type="text" name="method"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('method') }">
                                    <has-error :form="form" field="method"></has-error>
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
                methods : {},
                form: new Form({
                    id : '',
                    pay_name: '',
                    method: '',
                })
            }
        },
        methods: {

            getResults(page = 1) {

                this.$Progress.start();

                axios.get('/api/payment-methods?page=' + page).then(({ data }) => (this.methods = data.data));

                this.$Progress.finish();
            },
            updateMethods(){
                this.$Progress.start();
                this.form.put('/api/payment-methods/'+this.form.id)
                    .then((response) => {
                        // success
                        $('#addNew').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: response.data.message
                        });
                        this.$Progress.finish();
                        //  Fire.$emit('AfterCreate');

                        this.loadMethods();
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    });

            },
            editModal(meth){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(meth);
            },
            newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },

            loadMethods(){
                if(this.$gate.isAdmin()){
                    axios.get("/api/payment-methods").then(({ data }) => (this.methods = data));
                }
            },

            createMethods(){

                this.form.post('/api/payment-methods')
                    .then((response)=>{
                        $('#addNew').modal('hide');

                        Toast.fire({
                            icon: 'success',
                            title: response.data.message
                        });

                        this.$Progress.finish();
                        this.loadMethods();
                    })
                    .catch(()=>{
                        Toast.fire({
                            icon: 'error',
                            title: 'Some error occured! Please try again'
                        });
                    })
            },

            deleteMethod(id){
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
                        this.form.delete('api/payment-methods/'+id).then(()=>{
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            );
                            // Fire.$emit('AfterCreate');
                            this.loadMethods();
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
            this.loadMethods();
            this.$Progress.finish();
        }
    }
</script>
