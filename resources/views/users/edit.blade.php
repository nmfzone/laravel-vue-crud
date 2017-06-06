@extends('layouts.dashboard')

@section('content_header')
  <h3>Users Management</h3>
@endsection

@section('content')
  <div class="panel panel-primary">
    <div class="panel-heading">Edit User</div>

    <div class="panel-body">
      <user-edit-form :user-id="{{ $user->id }}">
        <form-alert :show="alert.show" :state="alert.type">
          @{{ alert.message }}
        </form-alert>

        <form class="form-horizontal" action="#" role="form" @submit.prevent="onSubmit" method="POST" @keydown="form.errors.clear($event.target.name)">
          <div class="form-group" v-bind:class="{ 'has-error' : form.errors.has('email') }">
            <label class="col-md-4 control-label">Email</label>

            <div class="col-md-6">
              <input type="text" class="form-control" v-model="form.email" required>

              <span class="help-block" v-if="form.errors.has('email')">
                <strong>@{{ form.errors.get('email') }}</strong>
              </span>
            </div>
          </div>

          <div class="form-group" v-bind:class="{ 'has-error' : form.errors.has('name') }">
            <label class="col-md-4 control-label">Name</label>

            <div class="col-md-6">
              <input type="text" class="form-control" v-model="form.name" required>

              <span class="help-block" v-if="form.errors.has('name')">
                <strong>@{{ form.errors.get('name') }}</strong>
              </span>
            </div>
          </div>

          <div class="form-group" v-bind:class="{ 'has-error' : form.errors.has('password') }">
            <label class="col-md-4 control-label">Password</label>

            <div class="col-md-6">
              <input type="password" class="form-control" v-model="form.password">

              <span class="help-block">
                Leave it blank if you don't intend to change the password.
              </span>

              <span class="help-block" v-if="form.errors.has('password')">
                <strong>@{{ form.errors.get('password') }}</strong>
              </span>
            </div>
          </div>

          <div class="form-group" v-bind:class="{ 'has-error' : form.errors.has('password_confirmation') }">
            <label class="col-md-4 control-label">Password Confirmation</label>

            <div class="col-md-6">
              <input type="password" class="form-control" v-model="form.password_confirmation">

              <span class="help-block" v-if="form.errors.has('password_confirmation')">
                <strong>@{{ form.errors.get('password_confirmation') }}</strong>
              </span>
            </div>
          </div>

          <div class="form-group m-t-lg">
            <div class="col-md-6 col-md-offset-4">
              <a href="{{ URL::previous() }}" class="btn btn-default">Back</a>
              <button type="submit" class="btn btn-primary" :disabled="form.errors.any()">
                <i class="fa fa-btn fa-save"></i> Update
              </button>
            </div>
          </div>
        </form>
      </user-edit-form>
    </div>
  </div>
@endsection
