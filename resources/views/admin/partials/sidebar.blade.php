<?php use App\Enumeration\PageEnumeration; ?>

<div class="brand">    
    @if(isset($logo_path))
        @if ($logo_path != '')
            <a href="{{ route('admin_dashboard') }}">
                <img src="{{ $logo_path }}" class="admin_img" alt="logo">
            </a>
        @endif
    @endif
</div>
<div class="side_nav_list">
    <ul>
        <?php
        $menu_items = ['Create a New Item', 'Category', 'Made In Country', 'Item Edit',
            'All Items', 'Data Import', 'Sort Items'];
        ?>
        <li data-toggle="accordion" data-target="#products" class="accordion_heading open_acc active {{ ((isset($page_title) && in_array($page_title, $menu_items)) || \Request::segment(3) == 'category') ? ' open_sec open_acc active' : '' }}" data-class="accordion">
            Products
        </li>
        <ul class="sub_accordion default_accrodion open {{ ((isset($page_title) && in_array($page_title, $menu_items)) || \Request::segment(3) == 'category') ? ' open' : '' }}" id="products">
            <?php $sub_menu_items = ['Category', 'Brands', 'Made In Country', '','Sort Items'] ?>

            <li class="{{ (isset($page_title) && $page_title == 'Create a New Item') ? 'active' : '' }}">
                <a href="{{ route('admin_create_new_item') }}">New Products</a>
            </li>

            <?php
                $sub_menu_items = ['Item Edit', 'All Items'];
                if(isset($categories)){
                    foreach($categories as $category) {
                        $sub_menu_items[] = $category['name'];

                        if (sizeof($category['subCategories']) > 0) {
                            foreach ($category['subCategories'] as $sub) {
                                $sub_menu_items[] = $sub['name'];
                            }
                        }
                    }
                }
                $title = isset($page_title) ? $page_title : '';
            ?>

            <li class="sub_child_accordion {{ ((isset($page_title) && in_array($page_title, $sub_menu_items)) || \Request::segment(3) == 'category') ? ' active' : '' }}">
                <div data-toggle="accordion" data-target="#listProducts" class="sub_child_accordion_open accordion_heading  {{ (isset($page_title) && in_array($page_title, $sub_menu_items)) ? ' open_sec' : '' }}" data-class="accordion"></div>
                <a href="{{ route('admin_item_list_all') }}">List Products</a>
            </li>

            <?php $sub_cat_id = Request::segment(4); ?>
            <ul class="sub_gchild_accordion default_accrodion {{ (isset($page_title) && in_array($page_title, $sub_menu_items)) ? 'open' : '' }}" id="listProducts">
                @if(isset($categories))
                    @foreach($categories as $category)
                        <?php
                        $subCat = [];

                        foreach ($category['subCategories'] as $sub)
                            $subCat[] = $sub['name'];
                        ?>

                        @if (sizeof($category['subCategories']) > 0)

                            <li class="{{ (in_array($title, $subCat) || $sub_cat_id == $category['id'])  ? ' active' : '' }}">
                                <a href="{{ route('admin_item_list_by_category', ['category' => $category['id']]) }}">{{ $category['name'] }}</a> <span data-toggle="accordion" data-target="#listProductsSub_{{ $category['id'] }}" class=" sub_gchild_accordion_open accordion_heading {{ in_array($title, $subCat) ? ' open_sec' : '' }}" data-class="accordion"></span>
                            </li>
                            <ul class="sub_gchild_accordion sub_ggchild_accordion default_accrodion {{ in_array($title, $subCat) ? ' open' : '' }}" id="listProductsSub_{{ $category['id'] }}">

                                @foreach($category['subCategories'] as $sub)
                                    <li class="{{ (isset($page_title) && $title == $sub['name']) ? 'active' : '' }}">
                                        <a href="{{ route('admin_item_list_by_category', ['category' => $sub['id']]) }}"> {{ $sub['name'] }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <li class="{{ ((isset($page_title) && $title == $category['name']) || in_array($title, $subCat)) ? 'active' : '' }} {{ sizeof($category['subCategories']) > 0 ? 'has-sub-categories' : '' }}" data-id="{{ $category['id'] }}">
                                <a href="{{ (sizeof($category['subCategories']) > 0) ? 'javascript:;' : route('admin_item_list_by_category', ['category' => $category['id']]) }}"> {{ $category['name'] }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            </ul>
            
            <?php $sub_menu_items = ['Category', 'Brands', 'Made In Country', 'Sort Items', 'Master Color', 'Color', 'Sizes', 'Item Values'] ?>

            <li class="sub_child_accordion {{ (isset($page_title) && in_array($page_title, $sub_menu_items)) ? ' active' : '' }}">
                <div data-toggle="accordion" data-target="#productSetting" class="sub_child_accordion_open accordion_heading  {{ (isset($page_title) && in_array($page_title, $sub_menu_items)) ? ' open_sec' : '' }}" data-class="accordion"></div>
                <a data-toggle="accordion" data-target="#productSetting">Product Settings</a>
            </li>
            <ul class="sub_gchild_accordion default_accrodion {{ (isset($page_title) && in_array($page_title, $sub_menu_items)) ? 'open' : '' }}" id="productSetting">
                <li class="{{ (isset($page_title) && $page_title == 'Category') ? 'active' : '' }}">
                    <a href="{{ route('admin_category') }}">Category</a>
                </li>
                <li class="{{ (isset($page_title) && $page_title == 'Brands') ? 'active' : '' }}">
                    <a href="{{ route('admin_brands') }}">Brands</a>
                </li>
                <li class="{{ (isset($page_title) && $page_title == 'Made In Country') ? 'active' : '' }}">
                    <a href="{{ route('admin_made_in_country') }}">Made In Country</a>
                </li>
                <li class="{{ (isset($page_title) && $page_title == 'Sort Items') ? 'active' : '' }}">
                    <a href="{{ route('admin_sort_items_view') }}">Sort Items</a>
                </li>
                <li class="{{ (isset($page_title) && $page_title == 'Master Color') ? 'active' : '' }}">
                    <a href="{{ route('admin_master_color') }}">Master Color</a>
                </li>
                <li class="{{ (isset($page_title) && $page_title == 'Color') ? 'active' : '' }}">
                    <a href="{{ route('admin_color') }}">Color</a>
                </li>
                <li class="{{ (isset($page_title) && $page_title == 'Sizes') ? 'active' : '' }}">
                    <a href="{{ route('admin_size') }}">Size</a>
                </li>
                <li class="{{ (isset($page_title) && $page_title == 'Item Values') ? 'active' : '' }}">
                    <a href="{{ route('admin_item_values') }}">Item Values</a>
                </li>
            </ul>
        </ul>

        <?php
            $menu_items = ['New Orders', 'Order Details', 'Confirmed Orders', 'Back Orders', 'Shipped Orders', 'Cancel Orders',
                'Return Orders', 'All Orders', 'Incomplete Checkouts'];
        ?>
        <li data-toggle="accordion" data-target="#orders" class="accordion_heading open_acc active {{ (isset($page_title) && in_array($page_title, $menu_items)) ? ' open_acc active' : '' }}" data-class="accordion">
            Orders
        </li>
        <ul class="sub_accordion default_accrodion open {{ (isset($page_title) && in_array($page_title, $menu_items)) ? ' open' : '' }}" id="orders">
            <?php
                $sub_menu_items = ['New Orders', 'Order Details', 'Confirmed Orders', 'Back Orders', 'Shipped Orders',
                    'Cancel Orders', 'Return Orders', 'All Orders'];
            ?>
            <li class="sub_child_accordion {{ (isset($page_title) && in_array($page_title, $sub_menu_items)) ? ' active' : '' }}">
                <div data-toggle="accordion" data-target="#allOrders" class="sub_child_accordion_open accordion_heading  {{ (isset($page_title) && in_array($page_title, $sub_menu_items)) ? ' open_sec' : '' }}" data-class="accordion"></div>
                <a href="{{ route('admin_all_orders') }}">All Orders</a>
            </li>
            <ul class="sub_gchild_accordion default_accrodion {{ (isset($page_title) && in_array($page_title, $sub_menu_items)) ? 'open' : '' }}" id="allOrders">
                <li class="{{ (isset($page_title) && $page_title == 'New Orders') ? 'active' : '' }}">
                    <a href="{{ route('admin_new_orders') }}">New Orders</a>
                </li>

                <li class="{{ (isset($page_title) && $page_title == 'Confirmed Orders') ? 'active' : '' }}">
                    <a href="{{ route('admin_confirmed_orders') }}">Confirmed</a>
                </li>

                <li class="{{ (isset($page_title) && $page_title == 'Back Orders') ? 'active' : '' }}">
                    <a href="{{ route('admin_backed_orders') }}">Back Ordered</a>
                </li>

                <li class="{{ (isset($page_title) && $page_title == 'Shipped Orders') ? 'active' : '' }}">
                    <a href="{{ route('admin_shipped_orders') }}">Shipped</a>
                </li>

                <li class="{{ (isset($page_title) && $page_title == 'Cancel Orders') ? 'active' : '' }}">
                    <a href="{{ route('admin_cancelled_orders') }}">Cancelled</a>
                </li>

                <li class="{{ (isset($page_title) && $page_title == 'Return Orders') ? 'active' : '' }}">
                    <a href="{{ route('admin_returned_orders') }}">Returned</a>
                </li>
            </ul>
            <li class="{{ (isset($page_title) && $page_title == 'Create New Order') ? 'active' : '' }}">
                <a href="{{ route('admin_new_order_create') }}">Create New Order</a>
            </li>
            <li class="{{ (isset($page_title) && $page_title == 'Incomplete Checkouts') ? 'active' : '' }}">
                <a href="{{ route('admin_incomplete_orders') }}">Incomplete Checkouts</a>
            </li>
        </ul>
        
        <?php $menu_items = ['Logo', 'Main Banner', 'Section Two Banner', 'Page/Meta - Home Page Custome Section'] ?>
        {{-- <li data-toggle="accordion" data-target="#bannerManager" class="accordion_heading {{ (isset($page_title) && in_array($page_title, $menu_items)) ? ' open_sec open_acc active' : '' }}" data-class="accordion">
            Banner Manager
        </li>
        <ul class="sub_accordion default_accrodion {{ (isset($page_title) && in_array($page_title, $menu_items)) ? ' open' : '' }}" id="bannerManager">
            <li class="{{ (isset($page_title) && $page_title == 'Logo') ? 'active' : '' }}">
                <a href="{{ route('admin_logo') }}">Logo</a>
            </li>
            <li class="{{ (isset($page_title) && $page_title == 'Main Banner') ? 'active' : '' }}">
                <a href="{{ route('admin_main_banner') }}">Main Banner</a>
            </li>
            <li class="{{ (isset($page_title) && $page_title == 'Section Two Banner') ? 'active' : '' }}">
                <a href="{{ route('admin_section_two_banner') }}">Section Two Banner</a>
            </li>
            <li class="{{ (isset($page_title) && $page_title == 'Page/Meta - Home Page Custome Section') ? 'active' : '' }}">
                <a href="{{ route('admin_page_view', ['id' => PageEnumeration::$HOME_PAGE_CUSTOM_SECTION]) }}"> HomePage Custom Section </a>
            </li>
        </ul> --}}

        <?php $menu_items = ['All Customer', 'Block Customers', 'Store Credit','Create Customer', 'Age Group', 'Skin Types'] ?>
        <li data-toggle="accordion" data-target="#customers" class="accordion_heading {{ (isset($page_title) && in_array($page_title, $menu_items)) ? ' open_sec open_acc active' : '' }}" data-class="accordion">
            Customers
        </li>
        <ul class="sub_accordion default_accrodion {{ (isset($page_title) && in_array($page_title, $menu_items)) ? ' open' : '' }}" id="customers">
            <li class="{{ (isset($page_title) && $page_title == 'All Customer') ? 'active' : '' }}">
                <a href="{{ route('admin_all_buyer') }}">All Customers</a>
            </li>
            <li class="{{ (isset($page_title) && $page_title == 'Create Customer') ? 'active' : '' }}">
                <a href="{{ route('customer_create') }}">Create Customer</a>
            </li>
            {{-- <li class="{{ (isset($page_title) && $page_title == 'Store Credit') ? 'active' : '' }}">
                <a href="{{ route('admin_store_credit_view') }}">Store Credit</a>
            </li> --}}
            <li class="{{ (isset($page_title) && $page_title == 'Age Group') ? 'active' : '' }}">
                <a href="{{ route('admin_age_group') }}">Age Group</a>
            </li>
            <li class="{{ (isset($page_title) && $page_title == 'Skin Types') ? 'active' : '' }}">
                <a href="{{ route('admin_skin_types') }}">Skin Types</a>
            </li>
        </ul>
        <?php $menu_items = ['Item Statistics'] ?>
        <li data-toggle="accordion" data-target="#statistics" class="accordion_heading {{ (isset($page_title) && in_array($page_title, $menu_items)) ? ' open_sec open_acc active' : '' }}" data-class="accordion">
            STATISTICS
        </li>
        <ul class="sub_accordion default_accrodion {{ (isset($page_title) && in_array($page_title, $menu_items)) ? ' open' : '' }}" id="statistics">
            <li class="{{ (isset($page_title) && $page_title == 'Item Statistics') ? 'active' : '' }}">
                <a href="{{ route('item_statistics') }}">Item Statistics</a>
            </li>
        </ul>
    </ul>
</div>