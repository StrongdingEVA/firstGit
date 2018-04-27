@extends("Home.header")

@section("content")
	<link rel="stylesheet" href="/Home/css/normalize.css">

	<div class="">
		<div class="fixed-btn">
			<a class="go-top" href="/publish">发布</a>
			<a class="go-top" href="/picturewall/new">最新</a>
			<a class="qrcode" href="/picturewall/hot">最热</a>
			<a class="qrcode" href="/picturewall/old">最早</a>
		</div>
	</div>
	<section id="gallery-wrapper">
		@foreach($articleList as $val)
			<article class="white-panel locate" url-data="/article_detail/{{$val['id']}}">
				<a class="example-image-link" href="javascript:void(0)" data-lightbox="example-set" data-title="{{$val['article_disc']}}">
					<img style="width: 100%" class="example-image" src="@if($val['article_thumb']) {{$val['article_thumb']}} @else /Home/images/logo.jpg @endif" alt=""/>
				</a>
				<p>
                    <img src="{{$val['get_username']['logo']}}" style="height:25px" alt="">
                    <span>{{$val['get_username']['username']}}</span>
                </p>
				<p>{{$val['article_title']}}</p>
				<p>时间：{{$val['created_at']}}</p>
			</article>
		@endforeach
	</section>

	<script src="/Home/js/pinterest_grid.js"></script>
	<script type="text/javascript" charset="utf-8" src="/Home/js/myjs.js"></script>
	<script type="text/javascript" src="/Home/js/scroll.js"></script>
	<script type="text/javascript">
        $(function(){
            $("#gallery-wrapper").pinterest_grid({
                no_columns: 6,
                padding_x: 10,
                padding_y: 10,
                margin_bottom: 50,
            });
			blog.bindDump('.locate');
        });
	</script>
@endsection