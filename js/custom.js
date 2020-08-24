+function(t){ 

 	$('[data-is-inview]').is_inview();
 	
 	$(window).on('bc_inited', function(e){ 
    
  });  

  $('[data-slick]').on('init', function(slick){  
 		var me = $(this);
		me.find('[data-is-inview]').is_inview();  
	}); 

  /*
  var fx_btns = $('[data-btn="fx"], .as-btn-primary>a'); 
	fx_btns.each(function(){ 
		var me = $(this);
		if(!$('html').hasClass('touchevents')){
			me.addClass('js-enabled');
			
			var me_padding = me.css('padding');
			var me_min_width = me.css('min-width');

			if(me.find('.fx-w').length<=0){
				me.attr('data-btn','fx');
				me.css('padding','0');
				var x = me.attr('data-fx-over') ? me.attr('data-fx-over') : me.html();
				me.html( '<span class="fx-w">'+ me.html() +'</span><span class="fx-x">'+ x +'</span>' );
				me.find('.fx-w, .fx-x').css('padding', me_padding);
				me.find('.fx-w, .fx-x').css('min-width', me_min_width);
			}

		} 
		
	}); 
	*/

	$(window).on('bc_inited, scroll, resize',function(){

		$('[data-simulate-height-off]').each(function(){ 
			var target = $(this).attr('data-simulate-height-off'); 
			$(this).css('height', $(target).innerHeight() ); 
		});

		var $dif = $('body').attr('data-maxwidth-half-diference');
		$('.slick-adjust-width .slick-list').css('padding-right', $dif+'px'); 
		$('.slick-adjust-width .slick-list').css('padding-left', $dif+'px'); 
	});

	$('[data-slick]').on('mousedown', function(e){ 
		$(this).one('mouseup', function(e){ 
			$(this).off('mousemove'); 
			$(this).removeClass('slick-is-draggin');
		}).on('mousemove', function(e){ 
		  $(this).addClass('slick-is-draggin');
		}); 
	});


	/*
	
		[data-ajax-load]

	*/

	$(document).on('click', '[data-ajax-load]', function(ev){

 		var me = $(this);
 		var url = me.attr('data-ajax-load');
 		var target = me.attr('data-ajax-target');
 		var holder = me.parent();

 		AjaxLoad_start(me);

 		$.ajax({ type: "GET",   
		     url: url,   
		     success : function(text)
		     {
		         // $( target ).append(text);
		         AjaxLoad_success(me, text);
		         if( me.attr('data-href') ){
		         	var new_url = me.attr('data-href');
		         	var new_object = me.attr('data-href-id');
		         	console.log(new_object);
		         	window.history.pushState({id: new_object}, 'Title', new_url);
		         }
		         
		     }
		}); 
 	}); 

 	window.onpopstate = function (e) {
	  var id = e.state.id;
	  if(id && $('[data-ajax-load][data-href-id='+id+']').length>0 ){
	  	console.log(id);
	  	$('[data-ajax-load][data-href-id='+id+']').trigger('click');
	  } 
	};

 	function AjaxLoad_error(me){
 		var msg = "Sorry but there was an error: ";
		$( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
 	}
 	function AjaxLoad_start(me){
 		var target = me.attr('data-ajax-target');
 		$( target ).removeClass('ajax-loaded');
 		$( target ).addClass('ajax-loading');  

 		if( me.attr('data-ajax-scroll') ){

 			// bs_scroll_to(me.attr('data-ajax-scroll'),0,me);
 			scrollto_offset = $(me.attr('data-ajax-scroll')).offset().top; 
 			$('html, body').animate({
				scrollTop: scrollto_offset
				} );

 		}

 	}
 	function AjaxLoad_success(me, items){
 		var target = me.attr('data-ajax-target');
 		$( target ).fadeOut(0);
  	$( target ).removeClass('ajax-loading');
  	$( target ).addClass('ajax-loaded');
  	 
  	if(me.attr('data-ajax-load-remove') == 'me'){
	  	me.remove();
	  }

	  if(me.attr('data-ajax-load-method') == 'append'){
	  	$( target ).append(items);
	  }
	  if(me.attr('data-ajax-load-method') == 'replace' || !me.attr('data-ajax-load-method') ){
	  	$( target ).html(items); 
	  }
	  $( target ).fadeIn(300,function(){
	  	$( target ).find('[data-is-inview]').is_inview();
	  });
	  
	  
 	}


}(jQuery); 