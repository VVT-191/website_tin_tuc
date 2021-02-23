@extends('front.template.master')

@section('title',$PageInfo->MetaTitle)

@section('description',$PageInfo->MetaDescription)

@section('keywords',$PageInfo->MetaKeyword)

@section('images',url('images/page/'.$PageInfo->Images))

@section('url',url('/'))
@section('home','active')
@section('content')

<div class="home_page">
    <div class="slider_wrap">
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
    
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item active">
      <img src="{{URL::asset('images/slider/slide1.png')}}" alt="Slider home">
      <div class="carousel-caption">
        ...
      </div>
    </div>
    <div class="item">
      <img src="{{URL::asset('images/slider/slide5.jpg')}}" alt="Slider home">
      <div class="carousel-caption">
        ...
      </div>
        ...
      </div>
      <div class="item">
      <img src="{{URL::asset('images/slider/slide4.jpg')}}" alt="Slider home">
      <div class="carousel-caption">
        ...
      </div>
        ...
      </div> 
    </div>
    ...
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
    </div>
    
    <div class="container">
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="home_top">
                <div class="home_top_left">
                    <div class="heading">
                      Blog mới nhất
                    </div>
                    <ul>
                      @if(isset($News) && count($News) > 0)
                      @foreach($News as $k=> $v)
                      <li>
                        <a href="{{url('/'.$v->Alias)}}.html" title="{{$v->Name}}">
                          <img src="{{URL::asset('images/news/'.$v->Images)}}" alt="{{$v->Name}}" />
                          <b>{{$v->Name}}</b>
                          <p>{{str_limit($v->SmallDescription, $limit = 90, $end = '...')}}
                            <span>[read more]</span>
                          </p>
                      </a>
                      </li>
                      @endforeach
                      @endif
                    </ul>
                </div>

                <div class="home_top_right">
                <div class="heading">
                      Về chúng tôi
                    </div>
                    <img src="{{URL::asset('images/PNV.jpg')}}" alt="About" />
                    <p><b>Phạm Nhật Vượng</b></p>
                    <p><strong>Phạm Nhật Vượng</strong> hiện là Chủ tịch Hội đồng quản trị Vingroup. Ông được xem là tỷ phú đô la Mỹ đầu
                       tiên trên sàn chứng khoán Việt Nam từ ngày 7 tháng 3 năm 2011 
                      với giá trị tài sản lên đến khoảng 21.200 tỷ đồng Việt Nam tương đương 1 tỷ đô la Mỹ tại thời điểm đó.</p>
                    <div class="home_social">
                    @if(isset($Social) && count($Social) > 0)
                  @foreach($Social as $k => $v)
                    <a href="{{$v->Alias}}" title="{{$v->Name}}">
                      {!!$v->Font!!}
                    </a>
                  @endforeach
                  @endif 
                    </div>
                </div>

            </div>
            </div>
            </div>
    </div>
</div>
<div class="container">
          <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="heading" style="margin-top: 55px; color: #FFF;">
                      Khuyến mại mới nhất
                    </div>
                    </div>
          @if(isset($NewsSale) && count($NewsSale) > 0)
          @foreach($NewsSale as $k=> $v)
            <div class="col-xs-12 col-sm-6 col-md-3">
                <div class="home_center">
                <a href="{{url('/'.$v->Alias)}}.html" title="{{$v->Name}}">
                          <img src="{{url('images/news/'.$v->Images)}}" alt="{{$v->Name}}" />
                          <b>{{$v->Name}}</b>
                          <p>{{str_limit($v->SmallDescription, $limit = 90, $end = '...')}}
                            <span>[read more]</span>
                          </p>
                      </a>    
              </div>
            </div>
          @endforeach
          @endif
          </div>
</div>
<div class="container">
          <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="home_bottom">
          <div class="heading">
                      Blog xem nhiều
                    </div>
                    
                    <ul>
                    @if(isset($NewsViews) && count($NewsViews) > 0)
                        @foreach($NewsViews as $k=> $v)
                      <li>
                    
                          
                              <a href="{{url('/'.$v->Alias)}}.html" title="{{$v->Name}}">
                                        <img src="{{url('images/news/'.$v->Images)}}" alt="{{$v->Name}}" />
                                        <b>{{$v->Name}}</b>
                                        <p>{{str_limit($v->SmallDescription, $limit = 90, $end = '...')}}
                                          <span>[read more]</span>
                                        </p>
                                    </a>    
                            
                        
                     
                      </li>
                      @endforeach
                        @endif
                    </ul>
                    </div>
          </div>
</div>




@stop