<?php

/*

	Redirect form after success

	Needs something like:

	[hidden url_redirect "http://customurl.com?customvar=1"]

	In the form

*/

add_action( 'wp_footer', 'wpbc_wpcf7mailsent' );

function mycustom_wp_footer() {
?>
<script type="text/javascript">
document.addEventListener( 'wpcf7mailsent', function( e ) {

    var url_redirect = '';

    var inputs = e.detail.inputs;
    for ( var i = 0; i < inputs.length; i++ ) {

        if( 'url_redirect' == inputs[i].name ) {//used for misc forms
            url_redirect = inputs[i].value;//set the redirect value from current submitted form
        }

    }

    //Check for redirect 
    if( url_redirect ){
        location = url_redirect;
    }

}, false );  
</script>
<?php
}