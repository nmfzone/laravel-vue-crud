@extends('layouts.dashboard')

@section('content_header')
  <h3>Users Management</h3>
@endsection

@section('content')
  <div class="panel panel-primary">
    <div class="panel-heading">User Lists</div>

    <div class="panel-body">
      <div class="row">
        <div class="pull-right m-b-lg m-r-lg">
          <a href="{{ route('users.create') }}">
            <div class="btn btn-primary">
              Add New User
            </div>
          </a>
        </div>
      </div>

      <user-lists>
        <form-alert :show="alert.show" :state="alert.type">
          @{{ alert.message }}
        </form-alert>

        <table class="table the-tables">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Email</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in additional.users">
              <td>@{{ user.id }}</td>
              <td>@{{ user.name }}</td>
              <td>@{{ user.email }}</td>
              <td>
                <a :href="`/dashboard/users/${user.id}/edit`" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                <div @click="onDelete(user.id)" class="btn btn-xs btn-primary delete-this"><i class="glyphicon glyphicon-remove"></i> Delete</div>
              </td>
            </tr>

            <tr v-if="additional.users && additional.users.length === 0">
              <td colspan="5">
                <center class="m-t-lg">Users is empty.</center>
              </td>
            </tr>
          </tbody>
        </table>

        <div class="text-center">

        </div>
      </user-lists>
    </div>
  </div>
@endsection
