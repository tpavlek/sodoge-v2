@extends('layout')

@section('additional_head')
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
@stop

@section('title')
    wow crate shibe
@stop

@section('content')

    @if (!$image)
        <div class="error">wow. such not found. 404. pls try again.</div>
    @endif

    <div class="pure-g">
        <div class="pure-u-2-3">
            <div class="centered">
                <h2>base image wow!!!!</h2>
      <span class="constrain">
        <img src="{{ $image['path'] }}" data-base-width="{{ $image['width'] }}"  data-base-height="{{ $image['height'] }}"/>
      </span>
            </div>
        </div>

        <div class="pure-u-1-3">
            <div class="centered">
                <h2>controls!!!</h2>
                {!! Form::open([ 'class' => 'pure-form' ]) !!}
                <p>{!! Form::text('much_title', "Much Title", [ 'class' => 'pure-input-2-3' ]) !!}</p>
                {!! Form::label('many_phrase', "Many phrases (such 1 per line)") !!}<br />
                {!! Form::textarea('many_phrase') !!}<br/>
                <br />
                <div class="pure-controls">
                    <button id="generatePhrases" class="pure-button pure-button-primary">
                        to the moon
                    </button>
                </div>
                {!! Form::close() !!}
                <br />

                <div class="pallette">
                    <span class="pallette-element colour colour-red"></span>
                    <span class="pallette-element colour colour-blue"></span>
                    <span class="pallette-element colour colour-green"></span>
                    <span class="pallette-element colour colour-orange"></span>
                    <span class="pallette-element colour colour-purple"></span>
                    <span class="pallette-element colour colour-yellow"></span>
                    <span class="pallette-element colour colour-grey"></span>
                    <br />
                    <span class="pallette-element colour colour-lightred"></span>
                    <span class="pallette-element colour colour-lightblue"></span>
                    <span class="pallette-element colour colour-lightgreen"></span>
                    <span class="pallette-element colour colour-lightorange"></span>
                    <span class="pallette-element colour colour-lightpurple"></span>
                    <span class="pallette-element colour colour-brown"></span>
                    <span class="pallette-element colour colour-black"></span>
                </div>
                <br />
                <br />
                <div>
                    <button id="enlittle" class="pure-button size-change" data-change-amt="-10">-</button>
                    Size
                    <button id="embiggen" class="pure-button size-change" data-change-amt="10">+</button>
                </div>
                <br />
                <button id="finished" class="pure-button size-150 pure-button-good">updoge</button>
                <br />
                <br />
                <a id="completed" href="#" disabled class="pure-button pure-button-orange">
                    look
                </a>
                <br />
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.pallette-element').click(function() {
                $('.selected').css('color', $(this).data('color-hex'));
            });

            // TODO wtf does this do?
            $('.colour').each(function() {
                assignColourData($(this));
            });

            $('.size-change').click(function() {
                var amt = parseInt($(this).data('change-amt')) / 100;
                amt += 1; // We want to multiply by a factor of 1.x
                var fontSize = $('.selected').attr('data-font-size');
                console.log(amt);
                console.log(fontSize);
                var newFontSize = (fontSize * amt);
                console.log(newFontSize);
                $('.selected').attr('data-font-size', newFontSize);
                $('.selected').css('font-size', newFontSize * $('.constrain img').attr('data-scale-factor') + 'px');
            });

            $('#finished').click(function() {
                compileAndSend();
            });

            $(window).resize(function() {
                calculateScaleFactor();
                $('.phrase').each(function() {
                    $(this).css('top', $(this).data('y-percent') + '%');
                    $(this).css('left', $(this).data('x-percent') + '%');
                    scaleFonts();
                });
            });
            calculateScaleFactor();
            scaleFonts();
        });

        $('#generatePhrases').click(function(e) {
            e.preventDefault();
            var phrases = $('#many_phrase').val().split("\n");

            for (var p in phrases) {
                renderPhrase(phrases[p], getRandomXPos(), getRandomYPos(), getRandomColour(), getRandomFontSize());
            }
            bindUIEvents();

            $('#many_phrase').val("");
        });

        function scaleFonts() {
            $('.phrase').each(function() {
                $(this).css('font-size', $(this).attr('data-font-size') * $('.constrain img').attr('data-scale-factor') + 'px');
            });
        }

        function bindUIEvents() {
            $('.phrase').draggable({
                containment: ".constrain",
                scroll:false,
                stop: function() {
                    $(this).attr('data-y-percent', $(this).position().top / $(this).parent().height() *100);
                    $(this).attr('data-x-percent', $(this).position().left / $(this).parent().width() *100);
                }
            });
            $('.phrase').mousedown(function() {
                deselect();
                $(this).addClass('selected');
            });
        }

        function assignColourData(loc) {
            loc.attr('data-color-hex', loc.css('background-color'));
        }

        function calculateScaleFactor() {
            var realWidth = $('.constrain img').width();
            var origWidth = $('.constrain img').data('base-width');
            $('.constrain img').attr('data-scale-factor', realWidth / origWidth);
        }

        function getRandomColour() {
            return $($('.colour')[Math.floor(Math.random() * $('.colour').length)]).css('background-color');
        }

        function getRandomXPos() {
            return Math.floor(Math.random() * 90);
        }

        function getRandomYPos() {
            return Math.floor(Math.random() * 90);
        }

        function getRandomFontSize() {
            var scale = $('.constrain img').attr('data-scale-factor');
            var target = 20 / scale;
            var inc = Math.floor(Math.random() * (target * 0.6));

            var result = target + inc;

            return result + 'px';
        }

        function deselect() {
            $('.selected').each(function() {
                $(this).removeClass('selected');
            });
        }

        function renderPhrase(str, x, y, bg, fs) {
            var phrase = $("<span class='phrase'>" + str + "</span>");
            phrase.css('color', bg);
            phrase.css('font-size', fs.split('px')[0] * $('.constrain img').attr('data-scale-factor') + 'px');
            phrase.attr('data-font-size', fs.split('px')[0]);
            phrase.css('top', y + '%');
            phrase.attr('data-y-percent', y);
            phrase.css('left', x + '%');
            phrase.attr('data-x-percent', x);

            $('.constrain').append(phrase);
        }

        function compileAndSend() {
            var img = $('.constrain img');
            var scale = img.attr('data-scale-factor');
            var width = img.data('base-width');
            var height = img.data('base-height');
            var phrases = Array();
            $('.phrase').each(function() {
                var phrase = {
                    x_pos: Math.floor(($(this).data('x-percent') / 100) * width),
                    y_pos: Math.floor(($(this).data('y-percent') / 100) * height) + (Math.floor($(this).height() * 0.5)), // + Math.floor($(this).height() * 1.5)
                    font_size: $(this).attr('data-font-size'),
                    color: rgb2hex($(this).css('color')),
                    text: $(this).html()
                };
                phrases.push(phrase);
            });
            console.log(phrases);
            $.ajax({
                type: "POST",
                url: "{{ URL::route('generator.store', $image['hash']) }}",
                data: {
                    phrases: phrases,
                    title: $('input[name=much_title]').val(),
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    console.log(data);
                    if (data.status) {
                        alert(data.message + "\n" + data.data);
                        return;
                    }

                    $('#completed').removeAttr('disabled');
                    $('#completed').attr('href', '/doge/very_view/wow/' + data.new_file);
                    $('#finished').attr('disabled', "");
                    console.log(data.new_file);
                },
                error: function(jqxhr) {
                    console.log(jqxhr);
                    alert("there was an error. Please send a support email.");
                }
            });
        }

        function rgb2hex(rgb) {
            rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
            function hex(x) {
                return ("0" + parseInt(x).toString(16)).slice(-2);
            }
            return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
        }
    </script>
@stop
