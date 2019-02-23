<template>
    <div class="container">
        <div class="row justify-content-center">
        <div class="row mt-5">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Usewtyer Management </h3>

              <div class="box-tools mt-2">
                <button class="btn btn-success pull-right mb-2"data-toggle="modal" data-target="#addUserModal">Add User
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
                <tr v-for="user in users" :key="user.id">
                  <td>{{user.id}}</td>
                  <td>{{user.name}}</td>
                  <td>{{user.email}}</td>
                  <td>{{user.type|uptext}}</td>
                  <td>{{user.created_at|mydate}}</td>
                  <!-- <td><span class="label label-success">Approved</span></td> -->
                  <td>
                    <a href="#">
                      <i class="fa fa-edit blue"></i>
                    </a>||
                    <a href="#">
                      <i class="fa fa-trash red"></i>
                    </a>

                  </td>
                </tr>

              </tbody></table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
            </div>

<!-- Start of Modal  -->
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- Start Code For Vform Axios -->
      <form @submit.prevent="addUser" >
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
        <option value="standard">Standard</option>
        <option value="author">Author</option>
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
        <button type="submit" class="btn btn-primary">Add</button>
      </div>

      </form>
    </div>
  </div>
</div>
<!-- End of Modal  -->

</div>
</template>

<script>
    export default {
      data(){
        return{
          users:{},
          form:new Form({
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

        loadUsers(){
        axios.get("api/user").then(({ data })=>(this.users=data.data));
        },
        addUser(){
          this.$Progress.start();
          this.form.post('api/user');
          $('#addUserModal').modal('hide')
          toast.fire({
            type: 'success',
            title: 'User Added successfully'
          })
          this.$Progress.finish();
        }
      },
        mounted() {
            this.loadUsers();
        }
    }
</script>
