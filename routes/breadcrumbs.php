<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', URL::to('/'));
});

// Home > Post Ad
Breadcrumbs::for('post-ad', function ($trail) {
    $trail->parent('home');
    $trail->push('Post Ad', route('user.post.ad'));
});

// Home > Ad List
Breadcrumbs::for('ad-list', function ($trail) {
    $trail->parent('home');
    $trail->push('Ad List', URL::to('ad-list'));
});

// Home > Ad List > Edit
Breadcrumbs::for('edit-ad', function ($trail,$data) {
    $trail->parent('ad-list');
    $ad_slug = $data['ad']->slug;
    $trail->push('Edit', URL::to('edit-ads/'.$ad_slug));
});

// Home > Ad List > Ad Title
Breadcrumbs::for('ad-detail', function ($trail,$data) {
    $trail->parent('ad-list');
    $ad_title = $data['ad']->title;
    $ad_slug = $data['ad']->slug;
    $trail->push($ad_title, URL::to('ad-details/'.$ad_slug));
});