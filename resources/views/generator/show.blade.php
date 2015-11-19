@extends('layout')

@section('title')
    much crate wow
@stop

@section('content')

    <div class="centered">
        {!! Form::open() !!}
            <img src="/img/std/shibe-glasses-gif.jpg" />
            <br />
            <div>
                <div class="fileUpload pure-button pure-button-good pure-button-massive expand-left">
                    <span class="fileUpload-text">wow such choice. very upload. file 4 doge</span>
                    <span class="spinner"></span>
                    <input type="file" name="base_doge" class="upload" />
                </div>
            </div>
            <div class="pure-controls">
                <a id="toTheMoon" href="#" disabled class="pure-button size-150 pure-button-orange">
                    to the moon!
                </a>
                <a id="feelingShibe" href="#" disabled class="pure-button pure-button-yellow size-150">
                    i'm feeling shibe
                </a>
            </div>
        {!! Form::close() !!}
        <h3>how do i shibe?</h3>
        <ol>
            <li>
                clik green button
                <a href="{{ URL::route('generator.create', '1bd87e3e25d8e048c7138bd0b5195271840377895b286e211c710a00f7633ad3.jpg')}}"
                   class="pure-button size-80 pure-button-primary">
                    or use regular doge
                </a>
            </li>
            <li>dig 4 file (in flower bed)</li>
            <li>send shibe 2 moon!</li>
            <li>continue on next page...</li>
        </ol>

        @if (!Auth::check())
            <a href="{{ URL::route('user.register') }}" class="pure-button colour-purple size-140">
                get doge passport to adopt shibe
            </a><br /><br />
            <a href="{{ URL::route('user.login') }}" class="pure-button colour-brown size-90">
                or stamp doge loyalty card
            </a>
        @endif
    </div>

    <script>
        $('input[name=base_doge]').change(function() {
            $('.expand-left').attr('data-loading', "true");
            $('.fileUpload-text').html("process shibe now wow many fast");
            var myData = new FormData();
            myData.append('shibe', $(this)[0].files[0]);
            $.ajax({
                url: "{{ URL::route('asset.upload') }}",
                type: "POST",
                processData: false,
                contentType: false,
                cache: false,
                data: myData,
                success: function(data) {
                    $('.expand-left').removeAttr('data-loading');

                    if (data.status) {
                        $('.fileUpload').removeClass('pure-button-good');
                        $('.fileUpload').addClass('pure-button-red');
                        $('fileUpload-text').html('wow, error, halp! pls contact human');
                        return;
                    }

                    if ($('.fileUpload').hasClass('pure-button-red')) {
                        $('.fileUpload').removeClass('pure-button-red');
                        $('.fileUpload').addClass('pure-button-good');
                    }
                    $('.fileUpload-text').html('hooray!');

                    $('#toTheMoon').removeAttr('disabled');
                    $('#toTheMoon').attr('href', '/doge/much_create/wow/' + data.hash);

                    console.log(data);
                },
                error: function(jqxhr) {
                    console.log(jqxhr);
                }
            });
        });
    </script>
@stop
