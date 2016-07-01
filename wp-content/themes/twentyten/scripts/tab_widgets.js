jQuery.noConflict();
jQuery(document).ready(function($) {
    $('div.widget-tab').on('click', 'ul.header > li > a', function(e){
        console.log(e);
        var $a = $(e.target || e.srcElement);
        var $li = $a.closest('li');
        if($li.hasClass('active')) {
            return false;
        }

        var $widget = $a.closest('div.widget-tab');
        var href = $a.attr('href');
        var $content = $widget.find('div.contents > div' + href );

        $widget.find('ul.header > li').removeClass('active');
        $widget.find('div.contents > div.content').removeClass('active');
        $li.addClass('active');
        $content.addClass('active');

        return false;
    });
});
