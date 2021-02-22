<template>
    <div class="container-fluid pt-2">
        <div class="row">
            <div class="col-12">
                <!-- Default box -->
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Users</h3>
                        <div class="card-tools">
                            <button @click="editUser()"
                                    type="button"
                                    class="btn btn-sm btn-info"
                                    data-card-widget="add"
                                    title="New User">
                                <i class="fas fa-plus"></i>
                                Add User
                            </button>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-sm table-head-fixed text-nowrap">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="user in users">
                                <td>{{user.id}}</td>
                                <td>{{user.firstName}}</td>
                                <td>{{user.lastName}}</td>
                                <td>{{user.email}}</td>
                                <td>{{user.username}}</td>
                                <td>
                                    <template v-if="user.role">
                                        {{user.role.name}}
                                    </template>
                                </td>
                                <td>
                                    <button @click="editUser(user)" type="button" class="btn btn-info btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <ul class="pagination pagination-sm float-right">
                            <li class="page-item"><a class="page-link" href="#">«</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">»</a></li>
                        </ul>
                    </div>
                    <!-- /.card-footer-->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</template>

<script>
    import {mapGetters} from "vuex";
    import Spinner from "../../Shared/Spinner";
    import UserForm from "./UserForm";

    export default {
        computed: {
            ...mapGetters({
                users: "USERS",
                roles: "ROLES",
                permissions: "PERMISSIONS",
            }),
        },
        methods: {
            editUser(user = null) {
                return EventBus.$emit('EDIT_USER',user);
            }
        }
    }
</script>

<style scoped>

</style>
