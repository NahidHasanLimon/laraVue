<template>
    <div class="container">
        <div class="row justify-content-center">
        <div class="row mt-5" v-if="$gate.isAdminOrAuthor()">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">User Management </h3>

              <div class="box-tools mt-2">
                <button class="btn btn-success pull-right mb-2" @click="openAddModal">Add User
                  <i class="fas fa-user-plus fa-fw"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tbody><tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>

                  <th>Type</th>
                  <th>Created at</th>
                  <th>Modify</th>
                </tr>
                <tr v-for="user in users.data" :key="user.id">
                  <td>{{user.id}}</td>
                  <td>{{user.name}}</td>
                  <td>{{user.email}}</td>
                  <td>{{user.type|uptext}}</td>
                  <td>{{user.created_at|mydate}}</td>
                  <!-- <td><span class="label label-success">Approved</span></td> -->
                  <td>
                    <a href="#"@click="openEditModal(user)">
                      <i class="fa fa-edit blue"></i>
                    </a>||
                    <a href="#" @click="deleteUser(user.id)">
                            <i class="fa fa-trash red"></i>
                              </a>

                  </td>
                </tr>

              </tbody></table>
            </div>
            <!-- /.box-body -->
            <!-- <div class="card-footer">
              <pagination :data="users.data" @pagination-change-page="getResults"></pagination>
            </div> -->
          </div>
          <!-- /.box -->
        </div>
      </div>
            </div>
              <div v-if="!$gate.isAdminOrAuthor()">
                <not-found></not-found>
              </div>
<!-- Start of Modal  -->
  <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5  v-show="!editmode" class="modal-title" id="exampleModalLabel">Add New User</h5>

        <h5 v-show="editmode"  class="modal-title" id="exampleModalLabel">Edit User Information</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- Start Code For Vform Axios -->
      <form @submit.prevent="editmode ? updateUser() : addUser() " >
      <div class="modal-body">
    <div class="form-group">
      <label>name</label>
      <input v-model="form.name" type="text" name="name" id="name"
        class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
      <has-error :form="form" field="name"></has-error>
    </div>
    <div class="form-group">
      <label>email</label>
      <input v-model="form.email" type="text" name="email" id="email"
        class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
      <has-error :form="form" field="email"></has-error>
    </div>
    <div class="form-group">
      <label>biography</label>
      <textarea v-model="form.biography" type="text" name="biography" id="biography"
        class="form-control" :class="{ 'is-invalid': form.errors.has('biography') }">
      </textarea>
      <has-error :form="form" field="biography"></has-error>

    </div>

    <div class="form-group">
      <label>type</label>
      <select v-model="form.type" type="text" name="type" id="type"
        class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
        <option value="">Select User Role</option>
        <option value="admin">Admin</option>
        <option value="author">Author</option>
        <option value="user">User</option>
    </select>
    <has-error :form="form" field="type"></has-error>
    </div>

    <div class="form-group">
      <label>Password</label>
      <input v-model="form.password" type="password" name="password" id="password"
        class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
      <has-error :form="form" field="password"></has-error>
    </div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button  v-show="editmode" type="submit" class="btn btn-primary">Update</button>
        <button  v-show="!editmode" type="submit" class="btn btn-success">Add</button>
      </div>

      </form>
    </div>
  </div>
</div>
<!-- End of Modal  -->

</div>
<!-- End of All -->


</template>

<script>
    export default {
      data(){
        return{
          editmode:false,
          users:{},
          form:new Form({
            id:'',
            name:'',
            email:'',
            password:'',
            type:'',
            biography:'',
            photo:'',
          })

        }
      },
      methods:{
        getResults(page = 1) {
			axios.get('api/user?page=' + page)
				.then(response => {
					this.users = response.data;
				});
		},
        openAddModal(){
          this.editmode=false;
          this.form.reset();
          $('#userModal').modal('show')
        },
        openEditModal(user){
          this.editmode=true;
          this.form.reset();
          $('#userModal').modal('show')
          this.form.fill(user);

        },
        deleteUser(id){
          swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to Undo this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            //Send Request to the server
              if (result.value) {
                this.form.delete('api/user/'+id).then(()=>{

                swal.Fire(
                  'Deleted!',
                  'Your file has been deleted.',
                  'success'
                )
                Fire.$emit('PageRefresh');

            }).catch(()=>{
              swal.Fire("Failed to Delete!","There was something wrong.","warning");
            });
              }

          })
        },

        loadUsers(){
          if (this.$gate.isAdminOrAuthor()) {
            axios.get("api/user").then(({ data })=>(this.users=data));

          }
        },
      updateUser(){

          this.$Progress.start();
        this.form.put('api/user/'+this.form.id)
        .then(()=>{
          //success
          $('#userModal').modal('hide')
          Fire.$emit('PageRefresh');

          swal.fire(
            'Updated !',
            'Your Information has been Updated successfully.',
            'success'
          )
          this.$Progress.finish();
        })
        .catch(()=>{
          this.$Progress.fail();
        });

      },
      addUser(){
                this.$Progress.start();
                this.form.post('api/user')
                .then(()=>{
                    Fire.$emit('PageRefresh');
                    $('#userModal').modal('hide')
                    toast.fire({
                        type: 'success',
                        title: 'User Added in successfully'
                        })
                    this.$Progress.finish();
                })
                .catch(()=>{
                })
            }
        },
        created() {
          Fire.$on('searching',()=>{
              this.$Progress.start();
            let query= this.$parent.search;
            axios.get('api/findUser?q=' + query)
            .then((data)=>{
              this.users=data.data
                this.$Progress.finish();
            })
            .catch(()=>{
                swal.Fire("Failed to Delete!","There was something wrong.","warning");

            })

          })
            this.loadUsers();
          // setInterval(()=> this.loadUsers(),3000);
          Fire.$on('PageRefresh',()=>{
            this.loadUsers();
          });
          this.getResults();
        }
    }
</script>
