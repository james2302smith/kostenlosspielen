/**
 * Created with JetBrains PhpStorm.
 * User: nttuyen
 * Date: 2/25/14
 * Time: 9:41 PM
 * To change this template use File | Settings | File Templates.
 */

jQuery(document).ready(function($){
    var $FLASH = $('object');
    var FLASH_ORIGIN_WIDTH = parseInt($('object').attr('width'));
    var FLASH_ORIGIN_HEIGHT = parseInt($('object').attr('height'));
    var l = Math.round((735 - FLASH_ORIGIN_WIDTH) / 2);
    $FLASH.css('left', l + "px");

    $( "#game-zoomslider" ).slider({
        value: 675,
        min: 300,
        max: 735,
        change: function(event, ui) {
            var width = parseInt(ui.value);
            var height = Math.round(FLASH_ORIGIN_HEIGHT * (width/FLASH_ORIGIN_WIDTH));

            var $obj = $('object');
            $obj.attr('width', width);
            $obj.attr('height', height);
            var $parent = $obj.closest("div#divGamePad");
            $parent.css('height', height);

            //Calculate left
            var left = Math.round((735 - width) / 2);
            $obj.css('left', left + "px");
        }
    });
    $('a.zoom-normal').click(function(e){
        $( "#game-zoomslider" ).slider("value", FLASH_ORIGIN_WIDTH);
    });
    $('a.zoomaction').click(function(e){
        var $target = $(e.target);
        var currentValue = parseInt($( "#game-zoomslider" ).slider("value"));
        if($target.hasClass('zoomout')) {
            currentValue -= 5;
        } else {
            currentValue += 5;
        }

        $( "#game-zoomslider" ).slider("value", currentValue);
    });
    
    $('.favorite-action').on('click', 'a.favorite-ajax-action', function(e){
        var $target = $(e.target);
        var url = $target.attr('data-url');
        var action = $target.attr('data-action');
        var game = $target.attr('data-game');
        var data = {
            action: action,
            game: game
        }
        $.ajax({
            type: 'GET',
            url: url,
            data: data,
            dataType: 'json',
            error: function() {
                alert("add to favorite error, please try again");
            },
            success: function(data) {
                if(data.code == 200) {
                    var nextAction = action == 'unfavorite' ? 'favorite' : 'unfavorite'
                    var nextHtml = action == 'unfavorite' ? 'Zu Favoriten' : 'Dein Favorit';
                    $target.attr('data-action', nextAction);
                    $target.html(nextHtml);
                    var $li = $target.closest('li');
                    if(action == 'favorite') {
                        $li.addClass('favorite-action-unfavorite')
                    } else {
                        $li.removeClass('favorite-action-unfavorite')
                    }
                }
            }
        });
    });
    $('.share-action').on('click', 'a', function(e){
        e.preventDefault();
        var $target = $(e.target);
        var name = $target.attr('name');
        var link = $target.attr('link');
        var picture = $target.attr('picture');
        var description = $target.attr('description');
        try {
            FB.ui({
                method: 'feed',
                name: name,
                link: link,
                picture: picture,
                description: description
            }, function(response) {
                console.log("FB share response");
                console.log(response);
            });
        } catch(ex) {
            console.error(ex);
        }
        return false;
    });
});
