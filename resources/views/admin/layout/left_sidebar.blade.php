<aside class="left-sidebar" data-sidebarbg="skin5">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav" class="p-t-30">
                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('dashboard.index')}}"
                                            aria-expanded="false">
                        <i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span></a>
                </li>
                @can('category-list')
                    <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link"
                                                href="{{route('category.index')}}" aria-expanded="false"><i
                                class="mdi mdi-chart-bar"></i><span class="hide-menu">Categories</span></a></li>
                @endcan
                @can('product-list')
                    <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link"
                                                href="{{route('product.index')}}" aria-expanded="false"><i
                                class="mdi mdi-chart-bubble"></i><span class="hide-menu">Products</span></a></li>
                @endcan
                @can('sale_phone-list')
                    <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link"
                                                href="{{route('sale_phone.index')}}" aria-expanded="false"><i
                                class="mdi mdi-nature-people"></i><span class="hide-menu">Sale Phone</span></a></li>
                @endcan
                @can('order-list')
                    <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link"
                                                href="{{route('order.index')}}" aria-expanded="false"><i
                                class="mdi mdi-border-inside"></i><span class="hide-menu">Orders</span></a></li>
                @endcan
                @can('order_detail-list')
                    <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link"
                                                href="{{route('order_detail.index')}}" aria-expanded="false"><i
                                class="mdi mdi-border-inside"></i><span class="hide-menu">Orders Detail</span></a></li>
                @endcan
                @can('comment-list')
                    <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link"
                                                href="{{route('comment.index')}}" aria-expanded="false"><i
                                class="mdi mdi-receipt"></i><span class="hide-menu">Feedback</span></a></li>
                @endcan
                @can('image-list')
                    <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link"
                                                href="{{route('image.index')}}" aria-expanded="false"><i
                                class="mdi mdi-relative-scale"></i><span class="hide-menu">Images</span></a></li>
                @endcan
                @can('deliverer-list')
                    <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link"
                                                href="{{route('deliverer.index')}}" aria-expanded="false"><i
                                class="mdi mdi-face"></i><span class="hide-menu">Deliverers</span></a></li>
                @endcan
                @can('user-list')
                    <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link"
                                                href="{{route('user.index')}}" aria-expanded="false"><i
                                class="mdi mdi-nature-people"></i><span class="hide-menu">Users</span></a></li>
                @endcan
                @can('color-list')
                    <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link"
                                                href="{{route('color.index')}}" aria-expanded="false"><i
                                class="mdi mdi-format-color-fill"></i><span class="hide-menu">Colors</span></a></li>
                @endcan
                @can('status-list')
                    <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link"
                                                href="{{route('status.index')}}" aria-expanded="false"><i
                                class="mdi mdi-move-resize-variant"></i><span class="hide-menu">Status</span></a></li>
                @endcan
                @can('role-list')
                    <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link"
                                                href="{{route('role.index')}}" aria-expanded="false"><i
                                class="mdi mdi-move-resize-variant"></i><span class="hide-menu">Role</span></a></li>
                @endcan
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
