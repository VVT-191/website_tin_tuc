@extends('back.template.master')
@section('title','Quản lý nhận tin khuyến mãi')
@section('newsletter','active')
@section('heading','Danh sách nhận khuyến mãi')
@section('content')
<div class="col-md-12">
            <!-- general form elements -->
            <div class="card">
                
                <div class="card-body">
                    <table id ="example2" class="table table-bordered table hover">
                  <thead>
                  <tr>
                    <th class="text_align_center">STT</th>
                    <th>Email</th>
                    <th class="text_align_center">Trạng thái</th>
                    
                   
                    <th class="text_align_center"><i class="fas fa-wrench"></i></th>
                  </tr>
                  </thead>
                  <tbody>
                    @if(isset($Newsletter) && count($Newsletter) > 0 )
                    @foreach($Newsletter as $k => $v)
                  <tr>
                    <td class="text_align_center">{{$k+1}}</td>
                    <td>{{$v->Email}}
                    </td>
                    <td class="text_align_center">
                      @if($v->IsViews == 1)
                        <span class = "color_red">Đã xem</span>
                      @else
                      <span class = "color_green">Chưa xem</span>
                      @endif
                      </td>
                    
                    
                    <td class="text_align_center">
                        <a href="{{url('admin/newsletter/edit/'.$v->RowID)}}" title="Chỉnh sửa">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="{{url('admin/newsletter/delete/'.$v->RowID)}}" title="Xóa">
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