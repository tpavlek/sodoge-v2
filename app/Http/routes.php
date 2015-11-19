<?php

get('/', 'Home@show')->name('home.index');

get('pls/open_door/wow/cold_out_here', 'Users@login')->name('user.login')->middleware('guest');
post('pls/open_door/wow/cold_out_here', 'Users@login')->name('user.auth')->middleware('guest');
get('pls/i_am_doge', 'Users@register')->name('user.register')->middleware('guest');
post('pls/i_am_doge', 'Users@store')->name('user.store')->middleware('guest');

get('bye', 'Users@logout')->name('user.logout')->middleware('user.logout');

get('customs/who_dat_shibe/wow/{id}', 'Users@show')->name('user.show');

get('doge/so_popular/wow/such_football_team', 'Stats@topTen')->name('stats.top10');

get('doge/much_create', 'Generator@index')->name('generator.index');
get('doge/much_create/wow/{hash}', 'Generator@create')->name('generator.create');
post('doge/much_create/wow/{hash}', 'Generator@store')->name('generator.store');
get('doge/very_view/wow/{hash}', 'Shibes@show')->name('shibe.show');

post('doge/much_upload', 'Assets@upload')->name('asset.upload');

