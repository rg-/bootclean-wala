+function(t){ 

 
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

	$(document.body).on('click', '[data-ordenar="receta"] .quantity-buttons .btn', function() {
		var $button = $(this);
	  var oldValue = $button.parent().parent().find("input.qty").val();

	  var data_elem = $button.parent(); 

	  if(!oldValue) oldValue = 0; 

	  var rest = parseInt( $('#grouped_recetas_rest').html() );
	  var rest_count = parseInt( $('#grouped_recetas_rest_count').html() );
	  var max = parseInt( $('#grouped_recetas_max').html() );
	  var list = $('#grouped_recetas_list');
	  var list_totals = $('#grouped_recetas_list_totals');

	  var list_count = list.find('div').length;

	  if( list_count==max && $button.hasClass('btn-plus') ){
	  	// alert("max");
	  	$('#modal_cart_max').modal('show')
	  	return;
	  } 

	  if ($button.hasClass('btn-plus') ) { 

		  var newVal = parseFloat(oldValue) + 1; 
		  var rest = parseInt( $('#grouped_recetas_rest').html() ) + 1;   

		  list.append('<div data-price="'+data_elem.attr('data-price')+'" id="cart_'+data_elem.attr('data-id')+'_'+newVal+'">'+data_elem.attr('data-name')+' <b class="price">'+data_elem.attr('data-price-html')+'</b></div>');

		  list_totals.append('<div id="cart_total_'+data_elem.attr('data-id')+'_'+newVal+'">'+data_elem.attr('data-price')+'</div>');

		} else {
	   // Don't allow decrementing below zero
	    if (oldValue > 0) {
	      var newVal = parseFloat(oldValue) - 1;
	      var rest = parseInt( $('#grouped_recetas_rest').html() ) - 1; 

	      list.find('#cart_'+data_elem.attr('data-id')+'_'+parseFloat(oldValue)+'').remove();
	      list_totals.find('#cart_total_'+data_elem.attr('data-id')+'_'+parseFloat(oldValue)+'').remove();

	    } else {
	      newVal = 0;
	      var rest = '0';
	    }
	  }  

	  var list_count = list.find('div').length; 

		var total_calculated = 0;
		list_totals.find('div').each(function(){
			total_calculated = total_calculated + parseFloat($(this).html());
		});
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
		     		}else{
		     			$('#grouped_recetas_rest_amout .rest_count').addClass('is_singular');
		     			$('#grouped_recetas_rest_amout .rest_count').removeClass('is_plural');
		     		}
		     		if(rest_count == 0){
		     			$('#grouped_recetas_rest_amout .rest_count').addClass('is_none');
		     			$('#grouped_recetas_rest_amout .rest_count').removeClass('is_plural');
		     			$('#grouped_recetas_rest_amout .rest_count').removeClass('is_singular');
		     			rest_count = '';
		     		}
		     		
		     		$('#grouped_recetas_rest_count').html( rest_count ); 

						if( list_count==max ){
							$('#grouped_recetas_add_to_cart').attr('disabled',false); 
						}else{
							$('#grouped_recetas_add_to_cart').attr('disabled',true); 
						}

		        $('#total_calculated').html(text);
		        $('#grouped_recetas_items').removeClass('loading');
		        $('#grouped_recetas_mini_cart').removeClass('loading');

		        $button.parent().find(".qty").attr('data-value',newVal).html(newVal);
					  $button.parent().parent().find("input.qty").val(newVal);
					  $button.parent().parent().find("input.qty").trigger('input');

		     }
		});  
	  

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