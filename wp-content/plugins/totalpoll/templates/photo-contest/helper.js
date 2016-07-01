jQuery(document).delegate('.tp-poll-container .zoom-image', 'click', function(e){
   e.preventDefault(); 
   jQuery.colorbox({href:this.href, open:true, opacity:0.5, title: this.title});
});