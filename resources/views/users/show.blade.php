@extends('layouts.dashboard')

@section('content_header')
  <h3>Users Management</h3>
@endsection

@section('content')
  <div class="panel panel-primary">
    <div class="panel-heading">User Details</div>

    <div class="panel-body">
      <user-show-form :user-id="{{ $user->id }}">
        <form class="form-horizontal" action="#" role="form">
          <div class="form-group">
            <label class="col-md-4 control-label">Email</label>

            <div class="col-md-6">
              <input type="text" class="form-control" v-model="form.email" disabled>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-4 control-label">Name</label>

            <div class="col-md-6">
              <input type="text" class="form-control" v-model="form.name" disabled>
            </div>
          </div>
        </form>
      </user-show-form>
    </div>
  </div>
@endsection
