@extends('back.template.master')
@section('title','Quản lý nhận tin khuyến mãi')
@section('heading','Chỉnh sửa email khuyến mãi')
@section('newsletter','active')
@section('content')
<div class="col-md-12">

                <div class="card-header">
                    <a class="btn btn-block btn-danger ad_add" href="{{url('admin/newsletter/list')}}" title="thêm">Quay lại</a>
                </div>
            <!-- general form elements -->
            <div class="card card-primary">
            
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="{{url('admin/newsletter/edit/'.$Newsletter->RowID)}}" method="POST">
                <div class="card-body">
                {!! csrf_field() !!}
                <div class="form-group">
                    <select class="form-control" name="IsViews">
                       
                        <option value="1" @if($Newsletter->IsViews == 1) selected="" @endif   >Trạng thái: Đã xem</option>
                        <option value="0" @if($Newsletter->IsViews == 0) selected="" @endif   >Trạng thái: Chưa xem</option>
                      
                    </select>
                  </div>
                  
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email<span class="color_red">*</span></label>
                    <input type="text" class="form-control" name="Email" value="{{$Newsletter->Email}}">
                  </div>
                 
                  
                  

                  
                  
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Chỉnh sửa</button>
                </div>
              </form>
            </div>
            <!-- /.card -->

            
            <!-- /.card -->

          </div>

@stop