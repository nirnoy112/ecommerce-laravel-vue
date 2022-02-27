<?php $url = url()->current();?>
<div class="col-sm-3 col-md-3 col-lg-2">
    <div class="myaccount_menu above_mobile">
        <h3 class="product_left_subtitle">My Account</h3>
        <ul>
            <li <?php if(preg_match("/dashboard/i", $url)):?> class="my_page_active" <?php endif;?>>
                <a href="{{route('buyer_show_dashboard')}}">Dashboard</a>
            </li>
            <li <?php if(preg_match("/overview/i", $url)):?> class="my_page_active" <?php endif;?>>
                <a href="{{route('buyer_shipping_info')}}">Account Settings</a>
            </li>
            <li <?php if(preg_match("/billing/i", $url)):?> class="my_page_active" <?php endif;?>>
                <a href="{{route('buyer_billing')}}">Addresses + Payments</a>
            </li>
            <li <?php if(preg_match("/orders/i", $url)):?> class="my_page_active" <?php endif;?>>
                <a href="{{route('buyer_show_orders')}}">Order History</a>
            </li>
            <li <?php if(preg_match("/message/i", $url)):?> class="my_page_active" <?php endif;?>>
                <a href="{{route('buyer_show_message')}}" style="display: inline-flex; margin-bottom: 12px;">Messages</a> 
                <span class="badge badge-info" id="message_count">@if(!empty($unread_messages)){{ $unread_messages }}@endif</span>
            </li> 
            <li>
                <a class="{{ (Request::route()->getName() == 'view_wishlist') ? 'active' : '' }}"
                    href="{{ route('view_wishlist') }}"><i class="icon-heart"></i>Wishlist</a>
            </li>
            
        </ul>
    </div>
    <div class="below_mobile">
        <ul>
            <li>
                <div class="myaccount_menu_mobile">
                    <h3>My Account</h3>
                    <ul>
                        <li <?php if(preg_match("/dashboard/i", $url)):?> class="my_page_active" <?php endif;?>>
                            <a href="{{route('buyer_show_dashboard')}}">Dashboard</a>
                        </li>
                        <li <?php if(preg_match("/overview/i", $url)):?> class="my_page_active" <?php endif;?>>
                            <a href="{{route('buyer_shipping_info')}}">Account Settings</a>
                        </li>
                        <li <?php if(preg_match("/billing/i", $url)):?> class="my_page_active" <?php endif;?>>
                            <a href="{{route('buyer_billing')}}">Addresses + Payments</a>
                        </li>
                        <li <?php if(preg_match("/orders/i", $url)):?> class="my_page_active" <?php endif;?>>
                            <a href="{{route('buyer_show_orders')}}">Order History</a>
                        </li>
                        <li <?php if(preg_match("/message/i", $url)):?> class="my_page_active" <?php endif;?>>
                            <a href="{{route('buyer_show_message')}}" style="display: inline-flex; margin-bottom: 12px;">Messages</a> 
                            <span class="badge badge-info" id="message_count">@if(!empty($unread_messages)){{ $unread_messages }}@endif</span>
                        </li>
                        <li <?php if(preg_match("/wishlist/i", $url)):?> class="my_page_active" <?php endif;?>>
                            <a href="#">Wish List</a>
                        </li> 
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>

