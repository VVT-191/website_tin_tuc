@extends('back.template.master')
@section('title','Quản lý tin tức')
@section('news','active')
@section('heading','Danh sách tin tức')
@section('content')
<div class="col-md-12">
            <!-- general form elements -->
            <div class="card">
            <div class="card-header">
                    <a class="btn btn-block btn-primary ad_add" href="{{url('admin/news/add')}}" title="thêm">Thêm</a>
                </div>
                <div class="card-body">
                    <table id ="example2" class="table table-bordered table hover">
                  <thead>
                  <tr>
                    <th class="text_align_center">STT</th>
                    <th>Thuộc danh mục</th>
                    <th>Tên tin tức</th>
                    <th>Ảnh đại diện</th>
                    <th class="text_align_center">Trạng thái</th>
               
                   
                    <th class="text_align_center"><i class="fas fa-wrench"></i></th>
                  </tr>
                  </thead>
                  <tbody>
                    @if(isset($News) && count($News) > 0 )
                    @foreach($News as $k => $v)
                  <tr>
                    <td class="text_align_center">{{$k+1}}</td>
                    <td>{{$v->CategoryName}}
                    <td>{{$v->Name}}
                    <td>
                        <img src="{{url('images/news/'.$v->Images)}}" width="100" alt="Avatar" />
                    </td>
                    <td class="text_align_center">
                      @if($v->Status == 1)
                        Bật
                      @else
                        Tắt
                      @endif
                      </td>
                    
                    
                    <td class="text_align_center">
                        <a href="{{url('admin/news/edit/'.$v->RowID)}}" title="Chỉnh sửa">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="{{url('admin/news/delete/'.$v->RowID)}}" title="Xóa">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                        
                    </td>
                  </tr>
                  @endforeach
                  @endif

                  
                  
                  
                  </tbody>
            </table>

          </div>
          </div>
</div>
@stop