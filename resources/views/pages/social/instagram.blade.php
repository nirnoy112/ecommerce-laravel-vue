@if(!empty($social_feeds))
    @foreach($social_feeds as $feed)
        <div class="modal fade bd-example-modal-lg common_popup_content_small" id="instamodal-{{$feed->id}}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body" style="padding: 16px 16px 4px 0px;">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="insta_pop_up_left">
                                        <div class="insta_popup_info" style="padding-left:0px !important">
                                            <img src="{{ $feed->images->standard_resolution->url }}" alt="" class="img-fluid">
                                            <h2 style="font-size:16px">@belitacollection</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <span aria-hidden="true" class="close" data-dismiss="modal" aria-label="Close">&times;</span>
                                    <div class="insta_pop_up_right" style="margin-top: 0px !important">
                                        {!!   $feed->caption->text ?  nl2br($feed->caption->text) : '' !!}
                                        <hr>
                                        <p style="text-align: right">
                                            <a target="_blank" href="{{ $feed->link }}">Details</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif
</div>
@if(!empty($social_feeds))
    <div class="row">
        <div class="col-md-12">
            <h2 class="best_seller_title">#Instagram Post</h2>
            <div id="instagram_slider" class="common_slide owl-carousel owl-theme owl-loaded owl-drag">
                @foreach($social_feeds as $feed)
                    <div class="product_slider_inner slider3_inner">
                        <a href="#" data-toggle="modal" data-target="#instamodal-{{$feed->id}}">
                            <img src="{{ $feed->images->standard_resolution->url }}" alt="">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif