<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <ul class="app-menu">
        <li>
            <a class="app-menu__item  {{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <span class="app-menu__label">Dashboard</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item {{ sidebar_open(['admin.users.*']) }}"
                href="{{ route('admin.users.index') }}">
                <span class="app-menu__label">Users Management</span>
            </a>
        </li>

        <li>
            <a class="app-menu__item {{ sidebar_open(['admin.teacher.*']) }}"
                href="{{ route('admin.teacher.index') }}">
                <span class="app-menu__label">Teacher Management</span>
            </a>
        </li>

        <li class="treeview">
            <a class="app-menu__item" href="#" data-toggle="treeview">
                <!--<i class="app-menu__icon fa fa-buffer"></i>-->
                <span class="app-menu__label">Course Management</span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                <li style="padding-left: 20px;">
                    <a class="treeview-item {{ sidebar_open(['admin.category.*']) }}" href="{{ route('admin.category.index') }}">Categories</a>
                </li>
                <li style="padding-left: 20px;">
                    <a class="treeview-item {{ sidebar_open(['admin.course']) }}" href="{{ route('admin.course') }}">Course</a>
                </li>
                <li style="padding-left: 20px;">
                    <a class="treeview-item {{ sidebar_open(['admin.course.chapters.*', 'admin.subject.chapter.*']) }}" href="{{ route('admin.course.chapters.index',0) }}">Chapters</a>
                </li>
                 <li style="padding-left: 20px;">
                    <a class="treeview-item {{ sidebar_open(['admin.course.sub_chapters.*', 'admin.subject.chapter.*']) }}" href="{{ route('admin.subject.chapter.index',0) }}">Sub Chapters</a>
                </li>
                <li style="padding-left: 20px;">
                    <a class="treeview-item {{ sidebar_open(['admin.question.*']) }}" href="{{ route('admin.question.index') }}">Questions</a>
                </li>
            </ul>
        </li>
        
        <li>
            <a class="app-menu__item {{ sidebar_open(['admin.allBooking.*']) }}" href="{{ route('admin.allBooking.index') }}">
                <span class="app-menu__label">All Bookings</span>
            </a>
        </li>
        
        <li>
            <a class="app-menu__item {{ sidebar_open(['admin.membershipBooking.*']) }}" href="{{ route('admin.membershipBooking.index') }}">
                <span class="app-menu__label">Membership Bookings</span>
            </a>
        </li>
        
        <li>
            {{-- <a class="app-menu__item {{ sidebar_open(['admin.tutor.*']) }}" href="{{ route('admin.tutor.index') }}">
                <span class="app-menu__label">Membership Bookings</span>
            </a> --}}
            <a class="app-menu__item {{ sidebar_open(['admin.zoom.*']) }}" href="{{ route('admin.zoom.index') }}">
                Zoom Meeting
            </a>
        </li>
        {{-- <li>
            <a class="app-menu__item {{ sidebar_open(['admin.tutor.*']) }}" href="{{ route('admin.tutor.index') }}">
                <span class="app-menu__label">Tutors Management</span>
            </a>
        </li> --}}
        {{-- <li>
            <a class="app-menu__item {{ sidebar_open(['admin.orders.*']) }}" href="{{ route('admin.orders.index') }}">
                <span class="app-menu__label">Booking</span>
            </a>
        </li> --}}
        <li>
            <a class="app-menu__item {{ sidebar_open(['admin.couponcode.*']) }}" href="{{ route('admin.couponcode.index') }}">
                <span class="app-menu__label">Coupon Management</span>
            </a>
        </li>
        <!--<li class="treeview">-->
        <!--    <a class="app-menu__item" href="#" data-toggle="treeview">-->
        <!--        <i class="app-menu__icon fa fa-group"></i>-->
        <!--        <span class="app-menu__label">Coupon Code</span>-->
        <!--        <i class="treeview-indicator fa fa-angle-right"></i>-->
        <!--    </a>-->
        <!--    <ul class="treeview-menu">-->
        <!--        <li>-->
        <!--            <a class="treeview-item {{ sidebar_open(['admin.couponcode.*']) }}"-->
        <!--            href="{{ route('admin.couponcode.index') }}">-->
        <!--            <i class="icon fa fa-circle-o"></i>All Coupon Codes-->
        <!--            </a>-->
        <!--        </li>-->
        <!--    </ul>-->
        <!--</li>-->
        <li class="treeview">
            <a class="app-menu__item" href="#" data-toggle="treeview">
                <span class="app-menu__label">Master Module</span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                <li style="padding-left: 20px;">
                    <a class="treeview-item {{ sidebar_open(['admin.board.*']) }}" href="{{ route('admin.board.index') }}">
                    All Board
                    </a>
                </li>
                <li style="padding-left: 20px;">
                    <a class="treeview-item {{ sidebar_open(['admin.class.*']) }}" href="{{ route('admin.class.index') }}">
                    All Class
                    </a>
                </li>
                <li style="padding-left: 20px;">
                    <a class="treeview-item {{ sidebar_open(['admin.subject.*']) }}" href="{{ route('admin.subject.index') }}">
                    All Subject
                    </a>
                </li>
                <li style="padding-left: 20px;">
                    <a class="treeview-item {{ sidebar_open(['admin.topic.*']) }}" href="{{ route('admin.topic.index') }}">
                    All Topic
                    </a>
                </li>
                <li style="padding-left: 20px;">
                    <a class="treeview-item {{ sidebar_open(['admin.subtopic.*']) }}" href="{{ route('admin.subtopic.index') }}">
                    All Sub Topic
                    </a>
                </li>
            </ul>
        </li>
        {{-- <li>
            <a class="app-menu__item {{ sidebar_open(['admin.questionpaper.*']) }}"
                href="{{ route('admin.questionpaper.index') }}">
                <span class="app-menu__label">Question Papers</span>
            </a>
        </li> --}}
        {{-- <li>
            <a class="app-menu__item {{ sidebar_open(['admin.keyconcept.*']) }}"
                href="{{ route('admin.keyconcept.index') }}">
                <span class="app-menu__label">Key Concepts</span>
            </a>
        </li> --}}
        {{-- <li>
            <a class="app-menu__item {{ sidebar_open(['admin.quiz.*']) }}"
                href="{{ route('admin.quiz.index') }}">
                <span class="app-menu__label">Quiz Management</span>
            </a>
        </li> --}}
        <li>
            <a class="app-menu__item {{ sidebar_open(['admin.membership.*']) }}"
                href="{{ route('admin.membership.index') }}">
                <span class="app-menu__label">Membership Plans</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item {{ sidebar_open(['admin.settings']) }}"
                href="{{ route('admin.settings') }}">
                <span class="app-menu__label">Site Settings</span>
            </a>
        </li>

        

        <li>
            <a class="app-menu__item {{ sidebar_open(['admin.contactus']) }}"
                href="{{ route('admin.contactus') }}">
                <!--<i class="app-menu__icon fa fa-user-cog"></i>-->
                <span class="app-menu__label">Contact us Setting</span>
            </a>
        </li>

        {{-- <li>
            <a class="app-menu__item {{ sidebar_open(['admin.contactus.list']) }}"
                href="{{ route('admin.contactus.list') }}">
                <!--<i class="app-menu__icon fa fa-user-cog"></i>-->
                <span class="app-menu__label">Contact us List</span>
            </a>
        </li> --}}

        <li>
            <a class="app-menu__item {{ sidebar_open(['admin.blog.*']) }}"
                href="{{ route('admin.blog.index') }}">
                <!--<i class="app-menu__icon fa fa-newspaper"></i>-->
                <span class="app-menu__label">Blog Management</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item {{ sidebar_open(['admin.testimonial.*']) }}"
                href="{{ route('admin.testimonial.index') }}">
                <!--<i class="app-menu__icon fa fa-cogs"></i>-->
                <span class="app-menu__label">Testimonials Management</span>
            </a>
        </li>

        <li class="treeview">
            <a class="app-menu__item" href="#" data-toggle="treeview">
                <!--<i class="app-menu__icon fa fa-buffer"></i>-->
                <span class="app-menu__label">Report</span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                <li style="padding-left: 20px;">
                    <a class="app-menu__item {{ sidebar_open(['admin.contactus.list']) }}" href="{{ route('admin.contactus.list') }}">
                    Contact Us
                    </a>
                </li>
                {{-- <li style="padding-left: 20px;">
                    <a class="app-menu__item {{ sidebar_open(['admin.zoom.*']) }}" href="{{ route('admin.zoom.index') }}">
                    Zoom Meeting
                    </a>
                </li> --}}
            </ul>
        </li>

        
        <!--<li class="treeview">-->
        <!--    <a class="app-menu__item" href="#" data-toggle="treeview">-->
        <!--        <i class="app-menu__icon fa fa-group"></i>-->
        <!--        <span class="app-menu__label">Questionpaper</span>-->
        <!--        <i class="treeview-indicator fa fa-angle-right"></i>-->
        <!--    </a>-->
        <!--    <ul class="treeview-menu">-->
        <!--        <li>-->
        <!--            <a class="treeview-item {{ sidebar_open(['admin.questionpaper.*']) }}"-->
        <!--            href="{{ route('admin.questionpaper.index') }}">-->
        <!--            <i class="icon fa fa-circle-o"></i>All Questionpapers-->
        <!--            </a>-->
        <!--        </li>-->
        <!--    </ul>-->
        <!--</li>-->
        <!--<li class="treeview">-->
        <!--    <a class="app-menu__item" href="#" data-toggle="treeview">-->
        <!--        <i class="app-menu__icon fa fa-group"></i>-->
        <!--        <span class="app-menu__label">Key Concept</span>-->
        <!--        <i class="treeview-indicator fa fa-angle-right"></i>-->
        <!--    </a>-->
        <!--    <ul class="treeview-menu">-->
        <!--        <li>-->
        <!--            <a class="treeview-item {{ sidebar_open(['admin.keyconcept.*']) }}"-->
        <!--            href="{{ route('admin.keyconcept.index') }}">-->
        <!--            <i class="icon fa fa-circle-o"></i>All Key Concept-->
        <!--            </a>-->
        <!--        </li>-->
        <!--    </ul>-->
        <!--</li>-->
        <!--<li class="treeview">-->
        <!--    <a class="app-menu__item" href="#" data-toggle="treeview">-->
        <!--        <i class="app-menu__icon fa fa-group"></i>-->
        <!--        <span class="app-menu__label">Quiz</span>-->
        <!--        <i class="treeview-indicator fa fa-angle-right"></i>-->
        <!--    </a>-->
        <!--    <ul class="treeview-menu">-->
        <!--        <li>-->
        <!--            <a class="treeview-item {{ sidebar_open(['admin.quiz.*']) }}"-->
        <!--            href="{{ route('admin.quiz.index') }}">-->
        <!--            <i class="icon fa fa-circle-o"></i>All Quiz-->
        <!--            </a>-->
        <!--        </li>-->
        <!--    </ul>-->
        <!--</li>-->

        <!--<li class="treeview">-->
        <!--    <a class="app-menu__item" href="#" data-toggle="treeview">-->
        <!--        <i class="app-menu__icon fa fa-group"></i>-->
        <!--        <span class="app-menu__label">Membership</span>-->
        <!--        <i class="treeview-indicator fa fa-angle-right"></i>-->
        <!--    </a>-->
        <!--    <ul class="treeview-menu">-->
        <!--        <li>-->
        <!--            <a class="treeview-item {{ sidebar_open(['admin.membership.*']) }}"-->
        <!--            href="{{ route('admin.membership.index') }}">-->
        <!--            <i class="icon fa fa-circle-o"></i>All Memberships-->
        <!--            </a>-->
        <!--        </li>-->
        <!--    </ul>-->
        <!--</li>-->
        <!--<li class="treeview">-->
        <!--    <a class="app-menu__item" href="#" data-toggle="treeview">-->
        <!--        <i class="app-menu__icon fa fa-group"></i>-->
        <!--        <span class="app-menu__label">Master</span>-->
        <!--        <i class="treeview-indicator fa fa-angle-right"></i>-->
        <!--    </a>-->
        <!--    <ul class="treeview-menu">-->
        <!--        <li>-->
        <!--            <a class="app-menu__item {{ sidebar_open(['admin.settings']) }}"-->
        <!--                href="{{ route('admin.settings') }}"><i class="app-menu__icon fa fa-cogs"></i>-->
        <!--                <span class="app-menu__label">Settings</span>-->
        <!--            </a>-->
        <!--        </li>-->
        <!--    </ul>-->
        <!--</li>-->

        <!--<li class="treeview">-->
        <!--    <a class="app-menu__item" href="#" data-toggle="treeview">-->
        <!--        <i class="app-menu__icon fa fa-group"></i>-->
        <!--        <span class="app-menu__label">Blog</span>-->
        <!--        <i class="treeview-indicator fa fa-angle-right"></i>-->
        <!--    </a>-->
        <!--    <ul class="treeview-menu">-->
        <!--        <li>-->
        <!--            <a class="treeview-item {{ sidebar_open(['admin.blog.*']) }}"-->
        <!--            href="{{ route('admin.blog.index') }}">-->
        <!--            <i class="icon fa fa-circle-o"></i>All Blog-->
        <!--            </a>-->
        <!--        </li>-->
        <!--    </ul>-->
        <!--</li>-->
        <!--<li class="treeview">-->
        <!--    <a class="app-menu__item" href="#" data-toggle="treeview">-->
        <!--        <i class="app-menu__icon fa fa-group"></i>-->
        <!--        <span class="app-menu__label">Testimonial</span>-->
        <!--        <i class="treeview-indicator fa fa-angle-right"></i>-->
        <!--    </a>-->
        <!--    <ul class="treeview-menu">-->
        <!--        <li>-->
        <!--            <a class="treeview-item {{ sidebar_open(['admin.testimonial.*']) }}"-->
        <!--            href="{{ route('admin.testimonial.index') }}">-->
        <!--            <i class="icon fa fa-circle-o"></i>All Testimonial-->
        <!--            </a>-->
        <!--        </li>-->
        <!--    </ul>-->
        <!--</li>-->
        
        
        
        
    </ul>
</aside>