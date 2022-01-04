<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">

          <div class="col-12">

            <div class="card" v-if="$gate.isAdmin()">
              <div class="card-header">
                <h3 class="card-title">Shop Setting</h3>

                <div class="card-tools">

                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>SL</th>
                      <th>Key</th>
                      <th>Type</th>
                      <th>Value</th>
                    </tr>
                  </thead>
                  <tbody>
                     <tr v-for="(shop_set,index) in shop_settings" :key="index">

                      <td>{{index+1}}</td>
                      <td class="text-capitalize">{{shop_set.key}}</td>
                      <td>{{shop_set.type}}</td>
                      <td v-if="shop_set.type === 'image'">
                          <img :src=shop_set.value alt="image">
                            <form @submit="formSubmit($event, shop_set.id)" enctype="multipart/form-data" >
                                <input type="hidden" name="id" :value="shop_set.value">
                                <input type="file" class="form-control" v-on:change="onChange">
                                <button class="btn btn-primary btn-small mt-2">Upload</button>
                            </form>

                      </td>
                         <td v-else>
                             <textarea @change="updateInfo($event, shop_set.id)" >{{shop_set.value}}</textarea>
                         </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
<!--                  <pagination :data="categories" @pagination-change-page="getResults"></pagination>-->
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>


        <div v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>

    </div>
  </section>
</template>

<script>
    export default {
        data () {
            return {
                editmode: false,
                shop_settings : {},
                file: '',
            }
        },
        methods: {

            getResults(page = 1) {

                  this.$Progress.start();

                  // axios.get('/api/category?page=' + page).then(({ data }) => (this.categories = data.data));

                  this.$Progress.finish();
            },
            updateCategory(){
                this.$Progress.start();
                this.form.put('/api/category/'+this.form.id)
                .then((response) => {
                    // success
                    $('#addNew').modal('hide');
                    Toast.fire({
                      icon: 'success',
                      title: response.data.message
                    });
                    this.$Progress.finish();
                        //  Fire.$emit('AfterCreate');

                    this.loadCategories();
                })
                .catch(() => {
                    this.$Progress.fail();
                });

            },


            loadSetting(){
                if(this.$gate.isAdmin()){
                    axios.get("/api/shopping-setting").then(({ data }) => (this.shop_settings = data.data));
                }
            },

            onChange(e) {
                this.file = e.target.files[0];
            },

            formSubmit(e, id) {
                e.preventDefault();

                const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }

                let data = new FormData();
                data.append('file', this.file);
                data.append('id', id);

                axios.post('/api/shopping-setting/upload', data, config)
                    .then( (data) => {
                        // console.log(data);
                        if(data.statusText == 'OK'){

                            // console.log(data.data);
                            Toast.fire({
                                icon: 'success',
                                title: data.data.message
                            });
                            this.$Progress.finish();
                            this.loadSetting();

                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: 'Some error occured! Please try again'
                            });

                            this.$Progress.failed();
                        }
                    })
                    .catch( (error) => {
                        // console.log(error);
                        Toast.fire({
                            icon: 'error',
                            title: 'Some error occured! Please try again'
                        });

                    });
            },

            updateInfo(e, id){

                e.preventDefault();

                let data = new FormData();
                // console.log(e.target.value);

                axios.put('/api/shopping-setting/'+id, {value: e.target.value})
                    .then( (data) => {
                        // console.log(data);
                        if(data.statusText == 'OK'){

                            // console.log(data.data);
                            Toast.fire({
                                icon: 'success',
                                title: data.data.message
                            });
                            this.$Progress.finish();
                            this.loadSetting();

                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: 'Some error occured! Please try again'
                            });

                            this.$Progress.failed();
                        }
                    })
                    .catch( (error) => {
                        // console.log(error);
                        Toast.fire({
                            icon: 'error',
                            title: 'Some error occured! Please try again'
                        });

                    });

            }


        },
        mounted() {
            console.log('Component mounted.')
        },
        created() {

            this.$Progress.start();
            this.loadSetting();
            this.$Progress.finish();
        }
    }
</script>
