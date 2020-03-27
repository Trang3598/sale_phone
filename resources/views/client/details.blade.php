@extends('client.master')
@section('title','Detail Product')
@section('main')
    <link rel="stylesheet" href="{{asset('client/css/details.css')}}">
    <div id="wrap-inner">
        <div id="product-info">
            <div class="clearfix"></div>
            <h3>{{$product->name_phone}}</h3>
            <div class="row">
                <div id="product-img" class="col-xs-12 col-sm-12 col-md-4 text-center">
                    <div class="img col-sm-12" style="width: 100%; height: 300px;padding: 0">
                        <img src="{{asset('images/'.$product->thumbnail)}}" class="img-responsive"
                             style="height:100%;width: 100%">
                    </div>
                    <p>Xem hình thực tế sản phẩm</p>
                    <div class="row">
                        @foreach($images as $key => $image)
                            <div class="column">
                                <img src="{{asset('images/'.$image->image)}}" style="width:100%;height: 50%"
                                     onclick="openModal();currentSlide({{$key+1}})"
                                     class="hover-shadow cursor img-responsive">
                            </div>
                        @endforeach
                    </div>
                    <div id="myModal" class="modal">
                        <span class="close cursor" onclick="closeModal()">&times;</span>
                        <div class="modal-content">
                            @foreach($images as $key => $image)
                                <div class="mySlides" style="height: 350px">
                                    <div class="numbertext">{{$key+1}}/{{$count}}</div>
                                    <img src="{{asset('images/'.$image->image)}}" style="width:100%; max-height: 350px"
                                         class="img-responsive">
                                </div>
                            @endforeach
                            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                            <a class="next" onclick="plusSlides(1)">&#10095;</a>

                            <div class="caption-container">
                                <p id="caption"></p>
                            </div>
                            <div class="box_img"
                                 style="display: flex;flex-direction: row;flex-wrap: wrap;max-height: 150px;justify-content: center;align-items: center;">
                                @foreach($images as $key => $image)
                                    <div class="col-sm-4"
                                         style="max-height:150px; display: flex;flex-wrap: wrap;justify-items: center; padding:10px">
                                        <img class="" src="{{asset('images/'.$image->image)}}"
                                             style="width:100%;height: 120px "
                                             onclick="currentSlide({{$key}})" alt="" class="img-responsive">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div id="product-details" class="col-xs-12 col-sm-12 col-md-8">
                    @if($today >= $start['start_promotion'] && $today <= $end['end_promotion'])
                        <p><span class="price">{{number_format($product->promotion_price)}} ₫</span></p>
                        <p><span><strike style="font-size:20px">{{number_format($product->price)}} ₫</strike></span></p>
                    @else
                        <p>Chỉ: <span class="price">{{number_format($product->price)}} ₫</span></p>
                    @endif
                    <p>Màu có sẵn:</p>
                    <p>Bảo hành: {{$product->warranty}}</p>
                    <p>Thời gian khuyến mãi: {{$product->start_promotion->format('d/m/Y')}}
                        - {{$product->end_promotion->format('d/m/Y')}}</p>
                    <p class="add-cart text-center"><a href="#">Đặt hàng online</a></p>
                </div>
            </div>
        </div>
        <div id="product-detail">
            <h3>{{$product->title}}</h3>
            <p>{{$product->description}}</p>
            <p>{{$product->detail}}</p>
            <p class="text-justify">{{$product->detail}}</p>
        </div>

        <div id="product-detail">
            <h3>Thông số kĩ thuật</h3>
            <table class="table table-hover">
                <tr>
                    <td>Hệ điều hành</td>
                    <td>{{$product->os}}</td>
                </tr>
                <tr>
                    <td>Camera trước</td>
                    <td>{{$product->camera_primary}}</td>
                </tr>
                <tr>
                    <td>CPU</td>
                    <td>{{$product->cpu_speed}}</td>
                </tr>
                <tr>
                    <td>RAM</td>
                    <td>{{$product->ram}}</td>
                </tr>
                <tr>
                    <td>Bộ nhớ trong</td>
                    <td>{{$product->memory}}</td>
                </tr>
                <tr>
                    <td>Pin</td>
                    <td>{{$product->battery}}</td>
                </tr>
                <tr>
                    <td>Bluetooth</td>
                    <td>{{$product->bluetooth}}</td>
                </tr>
                <tr>
                    <td>Wlan</td>
                    <td>{{$product->wlan}}</td>
                </tr>
                <tr>
                    <td>Trọng lượng</td>
                    <td>{{$product->weight}} g</td>
                </tr>
                <tr>
                    <td>Kích thước</td>
                    <td>{{$product->size}}</td>
                </tr>
            </table>
        </div>
        <div id="comment">
            <h3>Bình luận</h3>
            <form method="post" id="js_activity_feed_form" class="js_cmt_form" autocomplete="off"
                  enctype="multipart/form-data" action="{{route('send.comment',$product->id)}}">
                @csrf
                <div class="edtCmt">
                    <textarea class="dropfirst textarea" id="comment_content" name="comment_content"
                              style="overflow-y: visible;"></textarea>
                    <input type="hidden" name="user_id">
                    <input type="hidden" name="product_id">
                    <div class="boxemotion">
                        <div class="motionsend">
                            <a href="javascript:void(0)" class="loadpic btnCmtUpload">
                                <i class="iconcom-pict"></i>
                                <span>Gửi ảnh</span>
                            </a>
                            <input id="hdFileCmtUpload" type="file" class="hide uploadFile" name="image[]"
                                   accept="image/x-png, image/gif, image/jpeg" multiple>
                            <div class="cmt_right">
                                <button class="btnSend btn btn-success" id="btnSendCmt">Gửi</button>
                                <div class="captchacmt hide"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div>
                  <span class="text-danger">
                      <strong id="comment_content-error"></strong>
                  </span>
                <div id="image_preview" style="display: flex;flex-wrap: wrap;flex-direction: row">
                </div>
            </div>
        </div>
        <div id="comment-list" style="margin-top: 50px">
            @foreach($comments as $key => $comment)
                <ul>
                    <li class="com-title">
                        {{$comment->user->username}}
                        <br>
                        <span>{{$comment->created_at}}</span>
                    </li>
                    <li class="com-details">
                        {{$comment->comment_content}}
                    </li>
                    <div style="display: flex;flex-wrap: wrap;flex-direction: row">
                        @for($i = 0;$i<sizeof($img_cmt); $i++)
                            @if($img_cmt[$key][$i])
                                <li class="com-image" style="margin: 0 5px; border: 1px solid black">
                                    <img src="{{asset('images_feedbacks/'.$img_cmt[$key][$i]['image'])}}" alt=""
                                         style="height:100px;width:100px" class="img-responsive"/>
                                </li>
                            @endif
                        @endfor
                    </div>
                    <li>
                        <a href="javascript:void(0)" class="respondent" onclick="">Trả lời</a>
                    </li>
                </ul>
            @endforeach

        </div>
    </div>
@section('forminfor')
    <div id="forminfor">
    </div>
@endsection
<script>
    function openModal() {
        document.getElementById("myModal").style.display = "block";
    }

    function closeModal() {
        document.getElementById("myModal").style.display = "none";
    }

    var slideIndex = 1;
    showSlides(slideIndex);

    function plusSlides(n) {
        showSlides(slideIndex += n);
    }

    function currentSlide(n) {
        showSlides(slideIndex = n);
    }

    function showSlides(n) {
        var i;
        var slides = document.getElementsByClassName("mySlides");
        var dots = document.getElementsByClassName("demo");
        var captionText = document.getElementById("caption");
        if (n > slides.length) {
            slideIndex = 1
        }
        if (n < 1) {
            slideIndex = slides.length
        }
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex - 1].style.display = "block";
        dots[slideIndex - 1].className += " active";
        captionText.innerHTML = dots[slideIndex - 1].alt;
    }
</script>
@stop
