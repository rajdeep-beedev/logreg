@extends('layout.master');
@section('title','profile');
@section('content')
  <div class="row">
    @include('../layout.flashmsg')
    <div class="col-sm-6 offset-sm-3 bg-dark text-white">
      <h3 class="text-center text-success mt-3">Update profile</h3>
    <form action="{{Request::root().'/update-profile'}}" method="POST" class="mt-5">
      @csrf
      <input type="hidden" name="id" value="{{isset($users)?$users->id:''}}">

      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label"><b>Email<span class="text-danger">*</span></b></label>
        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{isset($users)?$users->email:''}}" readonly>
      </div>

      <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label"><b>First Names<span class="text-danger">*</span></b></label>
        <input type="text" class="form-control" value="{{isset($users)?$users->first_name:''}}" name="first_name">
          @error('first_name')
            <span class="text-danger"><strong>{{$errors->first('first_name')}}</strong></span>
          @enderror
      </div>

      <div class="mb-3">  
        <label for="exampleInputEmail1" class="form-label"><b>Last name<span class="text-danger">*</span></b></label>
        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{isset($users)?$users->last_name:''}}" name="last_name">
          @error('last_name')
            <span class="text-danger"><strong>{{$errors->first('last_name')}}</strong></span>
          @enderror
      </div>

      <div class="mb-3">  
        <label for="exampleInputEmail1" class="form-label"><b>mobile<span class="text-danger">*</span></b></label>
        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{isset($users)?$users->mobile:''}}" name="mobile">
          @error('mobile')
            <span class="text-danger"><strong>{{$errors->first('mobile')}}</strong></span>
          @enderror
      </div>

      <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label"><b>Password</b></label>
        <input type="password" class="form-control" name="password">
          @error('password')
            <span class="text-danger"><strong>{{$errors->first('password')}}</strong></span>
          @enderror
      </div>
      <a href="{{url('/')}}" class="btn btn-danger">Back</a>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    @endsection
    
  </div>
</div>