+function(t){ 



	$(document.body).on('click', '[data-filterby]', function(e) {

		var $button = $(this);
		 
		var $target = $button.attr('data-filter-target');
		var $nav = $button.attr('data-filter-nav');
		var $filterby = $button.attr('data-filterby');
		var $item = $button.attr('data-filter-item');

		var $active_class = $button.attr('data-active-class');
		var $default_class = $button.attr('data-default-class');

		if(!$button.hasClass('active')){
			$($nav).find('[data-filterby]').each(function(){
				var $active = $(this).attr('data-active-class');
				var $default = $(this).attr('data-default-class');
				$(this).removeClass($active).addClass($default);
			});

			$button.addClass($active_class).removeClass($default_class);

			$($target).find($item).fadeOut(0);
			$($target).find($item+$filterby).each(function(e){
				$(this).delay((e*100)).fadeIn(1200, function(){
					$(this).find('[data-is-inview]').is_inview();
				});

			});
			
		}

		console.log($filterby);

		return false;
	});
 
	$(document.body).on('click', '[data-remove-product_ids]', function(e) {
		var $button = $(this);
		var values = $button.attr('data-remove-product_ids');
		// values = JSON.parse(values);
		$('.woocommerce-cart-form, .cart_totals').addClass('loading');
		var ajax_url = $button.attr('data-ajax-url')+'&items='+values;
		$.ajax({ type: "GET",   
		     url: ajax_url,   
		     success : function(text)
		     {

		     		window.location = $button.attr('data-redirect-url');

		     }
		});  
		return false;
	});

	var data_ordenar_fields = $('[data-ordenar-field]');

	data_ordenar_fields.each(function(){
		var me = $(this);
		var target = me.attr('data-ordenar-field');
		me.find('[type="radio"]').on('change', function(e) {  
			if( $(this).is(":checked") ){  
	      $(target).attr('value', $(this).val()); 
	      $(target+'_count').html($(this).val()); 
	      $(target+'_max').html($(this).val());  
	    }
		});
	});  

	$('[data-ordenar-field="#grouped_personas"]').find('[type="radio"]').on('change', function(e) { 
			var target = $('[data-ordenar-field="#grouped_personas"]').attr('data-ordenar-field'); 

			if( $(this).is(":checked") ){  
	      $(target).attr('value', $(this).val()); 
	      $(target+'_count').html($(this).val());
	      $(target+'_count_modal').html($(this).val()); 
	      $(target+'_max').html($(this).val()); 
	      $('#ordenar-paso-1').addClass('passed');
	      $('#ordenar-paso-2').removeClass('disabled'); 
	     
	      /*
					Reseteo si clickeo de nuevo  y ademas filtro, si es 2 personas, no muestro el item 1 de recetas,
					O sea, para 2 personas muestro 2, 4 y 4 recetas
					y para  4 personas muestro 1, 2, 3 y 4 recetas
	      */
	      if( $(this).attr('value') > 2 ){
	      	$('[data-ordenar-field="#grouped_recetas"] [data-value="1"]').removeClass('d-none');
	      }else{
	      	$('[data-ordenar-field="#grouped_recetas"] [data-value="1"]').addClass('d-none'); 
	      }
	      $('[data-ordenar-field="#grouped_recetas"]').find('[type="radio"]').prop( "checked", false ); 
	      $('#ordenar-paso-2').removeClass('passed');
	      $('#grouped_recetas_siguiente').attr('disabled',true);
	    }
		});

	$('[data-ordenar-field="#grouped_recetas"]').find('[type="radio"]').on('change', function(e) { 
			var target = $('[data-ordenar-field="#grouped_recetas"]').attr('data-ordenar-field'); 
			if( $(this).is(":checked") ){  
	      $(target).attr('value', $(this).val()); 
	      $(target+'_count').html($(this).val()); 
	      $(target+'_count_modal').html($(this).val());
	      $(target+'_max').html($(this).val());  
	      $('#ordenar-paso-2').addClass('passed');
	      $('#grouped_recetas_siguiente').attr('disabled',false); 
	    }
		});

	/*

	Receta quantity buttons click actions

		Agrega o resta al minicart, calcula el total via ajax, muestra/oculta los mensajes correspondientes

		Ver
			-> _build/sass/customs/theme/_woo.scss -> 
			-> template-parts/woocommerce/grouped_product/ordenar-mini_cart.php

	*/

	$(document.body).on('click', '[data-ordenar="receta"] .quantity-buttons .btn', function() {
		var $button = $(this);
	  //var oldValue = $button.parent().parent().find("input.qty").val();

	  var oldValue = $button.parent().parent().find("span.qty[data-value]").attr('data-value');
	  	oldValue = parseInt(oldValue);

	  var steps = parseInt( $('#grouped_personas_count').html() );

	  //console.log(steps);

	  var data_elem = $button.parent(); 

	  if(!oldValue) oldValue = 0; 

	  var rest = parseInt( $('#grouped_recetas_rest').html() );
	  var rest_count = parseInt( $('#grouped_recetas_rest_count').html() );
	  var max = parseInt( $('#grouped_recetas_max').html() );
	  var list = $('#grouped_recetas_list');
	  var list_out = $('#grouped_recetas_list_out');
	  var list_totals = $('#grouped_recetas_list_totals');

	  var list_count = list.find('div.is-recetas').length; 
	  	list_count = list_count/steps;
	  var list_vinos_count = list.find('div.is-vinos').length; 
	  // If max reached, show modal 

	  var enable_modal_max = true;
	  if( list_count == max && $button.hasClass('btn-plus') && enable_modal_max && $button.hasClass('btn-recetas') ){
	  	// alert("max");
	  	$('#modal_cart_max').modal('show')
	  	return;
	  } 
	  // If minus clicked but empty list (you can´t rest anything), just do nothing.
	  if( list_count === 0 && $button.hasClass('btn-minus') ){
	  	return;
	  }
 
	  if ( $button.hasClass('btn-plus') ) { 

		  var newVal = parseFloat(oldValue) + 1; 
		  var rest = parseInt( $('#grouped_recetas_rest').html() ) + 1;   

		  var div_class = $button.hasClass('btn-recetas') ? 'is-recetas' : '';
		  div_class = $button.hasClass('btn-vinos') ? 'is-vinos' : div_class;
 			
 			if($button.hasClass('btn-recetas')){
 				for (var i = 0; i < steps; i++) {
			  	 list.append('<div class="'+div_class+'" data-id="'+data_elem.attr('data-id')+'" data-price="'+data_elem.attr('data-price')+'" data-refid="cart_'+data_elem.attr('data-id')+'_'+newVal+'"><span class="nn">1</span>'+data_elem.attr('data-name')+' <b class="price">'+data_elem.attr('data-price-html')+'</b></div>');

			  		list_totals.append('<div class="'+div_class+'" data-refid="cart_total_'+data_elem.attr('data-id')+'_'+newVal+'">'+data_elem.attr('data-price')+'</div>');
			  }
 			}else{
 				list.append('<div class="'+div_class+'" data-id="'+data_elem.attr('data-id')+'" data-price="'+data_elem.attr('data-price')+'" id="cart_'+data_elem.attr('data-id')+'_'+newVal+'"><span class="nn">1</span>'+data_elem.attr('data-name')+' <b class="price">'+data_elem.attr('data-price-html')+'</b></div>');

			  		list_totals.append('<div class="'+div_class+'" id="cart_total_'+data_elem.attr('data-id')+'_'+newVal+'">'+data_elem.attr('data-price')+'</div>');
 			}
		  

		} else {
	   // Don't allow decrementing below zero
	    if (oldValue > 0) {
	      var newVal = parseFloat(oldValue) - 1;
	      var rest = parseInt( $('#grouped_recetas_rest').html() ) - 1; 
	      if($button.hasClass('btn-recetas')){
		      for (var i = 0; i < steps; i++) {
		      	//console.log(data_elem.attr('data-id')+'_'+parseFloat(oldValue));
			      list.find('[data-refid="cart_'+data_elem.attr('data-id')+'_'+parseFloat(oldValue)+'"]').remove();
			      list_totals.find('[data-refid="cart_total_'+data_elem.attr('data-id')+'_'+parseFloat(oldValue)+'"]').remove();
			    }
			  }else{
			  	list.find('#cart_'+data_elem.attr('data-id')+'_'+parseFloat(oldValue)+'').remove();
			      list_totals.find('#cart_total_'+data_elem.attr('data-id')+'_'+parseFloat(oldValue)+'').remove();
			  }

	    } else {
	      newVal = 0;
	      var rest = '0';
	    }
	  }  

	  var list_count = list.find('div.is-recetas').length;
	  list_count = list_count/steps; 

	  list_vinos_count = list.find('div.is-vinos').length; 

		var total_calculated = 0;
		
		list_totals.find('div').each(function(){
			total_calculated = total_calculated + parseFloat($(this).html());
		});
 		
		var list_pre_order = list.find('div.is-vinos');
		list.find('.is-vinos').remove();

		list.append(list_pre_order);
		list.find('.is-vinos').eq(0).addClass('first_vino');

		list_out.html(list.html());

		var list_temp = [];

		list_out.find('div').each(function(){

			var this_id = $(this).attr('data-id');


			if(list_temp.indexOf(this_id)>=0) {

			}else{
				list_temp.push(this_id);
			}
			

			var length = list.find( '[data-id="'+this_id+'"]' ).length;
			if( length > 1 ){ 
				$(this).attr('data-length',length);
				$(this).addClass('is_not_visible').addClass('is_cloned');
				$(this).find('.nn').html( list.find( '[data-id="'+this_id+'"]' ).length );
			}

		});

		// list_out.find('.is_cloned:not(.unique)').eq(0).addClass('unique').addClass('bg-verde');
		list_out.find( '[data-id]' ).removeClass('is_visible');
		$.each(list_temp, function( index, value ) {
		  // console.log( index + ": " + value );
		  list_out.find( '[data-id="'+value+'"]' ).eq(0).removeClass('is_not_visible').addClass('is_visible');
		});


		list_out.find( '[data-id]' ).each(function(){

			if(!$(this).hasClass('is_visible')){
				$(this).addClass('d-none');
			}else{
				$(this).removeClass('d-none');
			}

		});

		// console.log(list_temp);

		// list_out.find('.is_cloned').eq(0).removeClass('bg-rojo').removeClass('is_cloned');


		if( list_count>0 ){ 
			list_out.removeClass('empty-result');
		}else{
			list_out.addClass('empty-result');
		}
		
		$('#grouped_recetas_items').addClass('loading');
		$('#grouped_recetas_mini_cart').addClass('loading');
 		
 		var ajax_url = $('#total_calculated').attr('data-ajax-url')+'&price='+total_calculated;

		$.ajax({ type: "GET",   
		     url: ajax_url,   
		     success : function(text)
		     {

		     		$('#grouped_recetas_rest').html(list_count); 

		     		var rest_count = max - list_count;

		     		if(rest_count > 1){ 
		     			$('#grouped_recetas_rest_amout .rest_count').addClass('is_plural');
		     			$('#grouped_recetas_rest_amout .rest_count').removeClass('is_singular');
		     			$('#grouped_recetas_rest_amout .rest_count').removeClass('is_none');
		     		}else{
		     			$('#grouped_recetas_rest_amout .rest_count').addClass('is_singular');
		     			$('#grouped_recetas_rest_amout .rest_count').removeClass('is_plural');
		     			$('#grouped_recetas_rest_amout .rest_count').removeClass('is_none');
		     		}
		     		if(rest_count == 0){
		     			$('#grouped_recetas_rest_amout .rest_count').addClass('is_none');
		     			$('#grouped_recetas_rest_amout .rest_count').removeClass('is_plural');
		     			$('#grouped_recetas_rest_amout .rest_count').removeClass('is_singular');
		     			rest_count = '';
		     		}
		     		
		     		$('#grouped_recetas_rest_count').html( rest_count ); 
		     		if(rest_count==0){
		     			$('#grouped_recetas_rest_count').addClass('d-none');
		     		}else{
		     			$('#grouped_recetas_rest_count').removeClass('d-none');
		     		}

		     		if(list_vinos_count>0){
		     			$('#grouped_recetas_add_vinos .n').html( 'Modificar' ); 
		     		}else{
		     			$('#grouped_recetas_add_vinos .n').html( 'Agregar' ); 
		     		}

		     		$('#grouped_recetas_rest_amout .msg_vinos .n').html(list_vinos_count);

						if( list_count==max ){ 
							ordear_reach_max(); 
						}else{
							ordear_not_max();  
						}

						if(rest_count==1){
							$('#grouped_recetas_rest_amout').addClass('text-rojo');
						}else{
							$('#grouped_recetas_rest_amout').removeClass('text-rojo');
						} 

		        $('#total_calculated').html(text);
		        $('#grouped_recetas_items').removeClass('loading');
		        $('#grouped_recetas_mini_cart').removeClass('loading');

		        var button_newVal = parseFloat($button.parent().find(".qty").attr('data-value'));
		        if ( $button.hasClass('btn-plus') ) { 
		        	button_newVal = button_newVal + 1;
		        }else{
		        	button_newVal = button_newVal - 1;
		        } 
		        
		        $button.parent().find(".qty").attr('data-value',button_newVal).html(button_newVal);
		        
		        if ( $button.hasClass('btn-recetas') ) {
		        	$button.parent().parent().find("input.qty").val(parseFloat(newVal)*steps);
		        }else{
		        	$button.parent().parent().find("input.qty").val(parseFloat(newVal));
		        }
					  
					  $button.parent().parent().find("input.qty").trigger('input');

		     }
		});  
	  

  });

	function ordear_reach_max(){  

		$('#grouped_recetas_add_vinos:not(.is_selecting_vinos)').removeClass('d-none'); 
		$('#grouped_recetas_add_to_cart').attr('disabled',false); 
	}

	function ordear_not_max(){

		$('#grouped_recetas_rest_amout .msg').removeClass('d-none');
		$('#grouped_recetas_rest_amout .msg_vinos').addClass('d-none');

		$('#grouped_recetas_add_vinos').addClass('d-none'); 
		$('#grouped_recetas_add_to_cart').attr('disabled',true); 
	}

	$(document.body).on('click', '#grouped_recetas_add_vinos', function() { 
		
		$('#grouped_recetas_add_vinos').addClass('d-none').addClass('is_selecting_vinos');

		$('#grouped_recetas_hide_vinos').removeClass('d-none');

		$('.visible_recetas').addClass('d-none');
		$('.visible_vinos').removeClass('d-none');
		$('.is_vinos.not_visible').removeClass('not_visible');
		$('.is_recetas').addClass('not_visible');

		$('#grouped_recetas_rest_amout .msg').addClass('d-none');
		$('#grouped_recetas_rest_amout .msg_vinos').removeClass('d-none');

		bs_scroll_to('#main-content-wrap');

		return false;

	});

	$(document.body).on('click', '#grouped_recetas_hide_vinos', function() {

		$('#grouped_recetas_hide_vinos').addClass('d-none');

		$('#grouped_recetas_add_vinos').removeClass('d-none').removeClass('is_selecting_vinos');

		$('.visible_recetas').removeClass('d-none');
		$('.visible_vinos').addClass('d-none');
		$('.is_vinos').addClass('not_visible');
		$('.is_recetas.not_visible').removeClass('not_visible');

		$('#grouped_recetas_rest_amout .msg').removeClass('d-none');
		$('#grouped_recetas_rest_amout .msg_vinos').addClass('d-none');

		bs_scroll_to('#main-content-wrap');

		return false;

	});

	$(document.body).on('click input', '[data-ordenar="receta"] input.qty', function() { 
    $(this).parent().parent().find('a[data-quantity]').attr('data-quantity', $(this).val());
    // (optional) Removing other previous "view cart" buttons
    // $(".added_to_cart").remove();

  });


	/*
	Auto open modal if button rendered on html
	*/
	if($('[data-modal-open="onload"]').length>0){
	  $('[data-modal-open="onload"]').trigger('click');
	}

}(jQuery); 