<?php

function _get_icon_FX($args, $content=NULL, $tag){

  $defs = array();  
  if(empty($args)){
    $args = array();
  } 
  $args = array_merge($defs, $args);

  $fill = !empty($args['color']) ? $args['color'] : '#ffffff';
  $class = !empty($args['class']) ? 'class="'.$args['class'].'"' : '';

  if($tag=='social_facebook'){
    $icon = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
   width="28px" height="28px" viewBox="0 0 28 28" enable-background="new 0 0 28 28" xml:space="preserve">
<path '.$class.' fill="'.$fill.'"  d="M28,14.085C28,6.307,21.732,0,14,0C6.268,0,0,6.307,0,14.085C0,21.115,5.12,26.943,11.812,28v-9.843
  H8.258v-4.072h3.554v-3.102c0-3.53,2.09-5.481,5.29-5.481c1.53,0,3.133,0.275,3.133,0.275v3.467h-1.764
  c-1.74,0-2.281,1.086-2.281,2.2v2.641h3.883l-0.621,4.072h-3.262V28C22.88,26.943,28,21.116,28,14.085"/>
</svg>'; 
  }
  if($tag=='social_instagram'){
    $icon = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
   width="28px" height="28px" viewBox="0 0 28 28" enable-background="new 0 0 28 28" xml:space="preserve">
<path '.$class.' fill="'.$fill.'"  d="M14,0c3.802,0,4.279,0.016,5.771,0.084c1.49,0.068,2.508,0.305,3.399,0.651
  c0.92,0.358,1.7,0.836,2.479,1.615c0.779,0.778,1.257,1.559,1.615,2.48c0.346,0.89,0.582,1.908,0.649,3.398
  C27.984,9.721,28,10.198,28,14s-0.016,4.279-0.084,5.771c-0.068,1.49-0.305,2.508-0.65,3.399c-0.358,0.92-0.836,1.7-1.615,2.479
  c-0.778,0.779-1.56,1.257-2.48,1.615c-0.891,0.346-1.908,0.582-3.398,0.649C18.279,27.984,17.802,28,14,28s-4.278-0.016-5.772-0.084
  c-1.49-0.068-2.508-0.305-3.398-0.65c-0.92-0.358-1.7-0.836-2.48-1.615c-0.777-0.778-1.256-1.56-1.613-2.48
  c-0.346-0.891-0.584-1.908-0.65-3.398C0.015,18.279,0,17.802,0,14s0.017-4.279,0.084-5.771C0.151,6.738,0.39,5.72,0.735,4.829
  c0.357-0.92,0.836-1.7,1.615-2.48C3.128,1.571,3.909,1.093,4.83,0.735c0.89-0.346,1.907-0.583,3.397-0.65C9.72,0.015,10.198,0,14,0z
   M14,2.523c-3.737,0-4.181,0.014-5.657,0.081c-1.365,0.062-2.105,0.29-2.6,0.482C5.09,3.34,4.623,3.644,4.133,4.133
  C3.644,4.623,3.34,5.09,3.086,5.743c-0.192,0.494-0.42,1.235-0.481,2.6C2.537,9.818,2.522,10.262,2.522,14s0.015,4.182,0.082,5.657
  c0.062,1.364,0.289,2.106,0.481,2.6c0.254,0.653,0.558,1.12,1.047,1.61c0.49,0.49,0.957,0.793,1.61,1.047
  c0.494,0.191,1.234,0.42,2.6,0.482c1.477,0.066,1.92,0.08,5.657,0.08c3.738,0,4.182-0.014,5.657-0.08
  c1.364-0.063,2.106-0.291,2.6-0.482c0.653-0.254,1.12-0.559,1.61-1.047c0.49-0.49,0.793-0.957,1.047-1.61
  c0.191-0.493,0.42-1.235,0.482-2.6c0.066-1.476,0.08-1.919,0.08-5.657s-0.014-4.182-0.08-5.657c-0.063-1.365-0.291-2.106-0.482-2.6
  c-0.254-0.653-0.559-1.12-1.047-1.61c-0.49-0.49-0.957-0.793-1.61-1.047c-0.493-0.192-1.235-0.42-2.6-0.482
  C18.182,2.537,17.738,2.523,14,2.523z M14,6.811c3.971,0,7.189,3.218,7.189,7.189S17.971,21.189,14,21.189
  c-3.97,0-7.19-3.219-7.19-7.189S10.03,6.81,14,6.811L14,6.811z M14,18.667c2.577,0,4.667-2.09,4.667-4.667S16.577,9.333,14,9.333
  S9.333,11.423,9.333,14S11.423,18.667,14,18.667z M23.152,6.527c0,0.928-0.752,1.68-1.68,1.68s-1.68-0.752-1.68-1.68
  c0-0.928,0.752-1.68,1.68-1.68S23.152,5.599,23.152,6.527z"/>
</svg>'; 
  }

  if($tag=='icon_time'){
    $icon = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
   width="24px" height="24px" viewBox="0 0 24 24" enable-background="new 0 0 24 24" xml:space="preserve">
<path '.$class.' fill="'.$fill.'" d="M11.992,3.667c-4.6,0-8.325,3.733-8.325,8.333c0,4.6,3.725,8.333,8.325,8.333c4.607,0,8.341-3.733,8.341-8.333
  C20.333,7.4,16.6,3.667,11.992,3.667z M12,18.667c-3.683,0-6.667-2.983-6.667-6.667c0-3.683,2.984-6.667,6.667-6.667
  c3.684,0,6.667,2.984,6.667,6.667C18.667,15.684,15.684,18.667,12,18.667z"/>
<polygon '.$class.' fill="'.$fill.'" points="12.417,7.833 11.167,7.833 11.167,12.833 15.542,15.458 16.167,14.434 12.417,12.208 "/>
</svg>';
  }

  if($tag=='icon_porciones'){
    $icon = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
   width="24px" height="24px" viewBox="0 0 24 24" enable-background="new 0 0 24 24" xml:space="preserve">
<path '.$class.' fill="'.$fill.'" d="M8.49,12.549l2.37-2.37L4.98,4.306c-1.307,1.307-1.307,3.426,0,4.74L8.49,12.549L8.49,12.549z"/>
<path '.$class.' fill="'.$fill.'" d="M14.168,11.033c1.281,0.594,3.082,0.175,4.414-1.156c1.6-1.6,1.91-3.895,0.678-5.126c-1.223-1.223-3.518-0.921-5.126,0.678
  c-1.331,1.332-1.75,3.133-1.155,4.414l-8.174,8.175l1.181,1.181l5.77-5.753l5.763,5.762l1.182-1.18l-5.762-5.763L14.168,11.033
  L14.168,11.033z"/>
</svg>';
  }

  if($tag=='icon_arrow_next'){
    $icon = '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
   width="24px" height="24px" viewBox="0 0 24 24" enable-background="new 0 0 24 24" xml:space="preserve">
<path '.$class.' fill="'.$fill.'" d="M12,4l-1.41,1.41L16.17,11H4v2h12.17l-5.58,5.59L12,20l8-8L12,4z"/>
</svg>';
  }

  if($tag=='icon_walla'){
    $icon = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
   width="150px" height="53px" viewBox="0 0 150 53" enable-background="new 0 0 150 53" xml:space="preserve">
<path '.$class.' fill="'.$fill.'" d="M48.584,16.548L39.72,42.059h-0.135l-8.797-25.511h-6.496l-8.796,25.511H15.36L6.496,16.548H0l12.992,35.254
  h5.007l9.474-27.54h0.135l9.473,27.54h5.008l12.992-35.254H48.584z"/>
<path '.$class.' fill="'.$fill.'" d="M74.502,15.736c-3.181,0-7.376,0.474-12.722,2.707l2.639,5.075c3.316-1.624,6.429-2.436,9.744-2.436
  c4.735,0,10.556,1.285,10.556,7.105v3.653c-3.248-2.909-7.172-3.991-10.894-3.991c-9.812,0-15.292,5.684-15.292,12.111
  c0,7.85,6.766,12.654,15.36,12.654c4.667,0,8.119-1.354,11.232-4.602v3.789h5.684v-24.09C90.809,19.323,82.96,15.736,74.502,15.736z
   M74.975,47.27c-7.443,0-9.947-3.586-9.947-7.039c0-3.449,2.504-7.037,9.947-7.037s9.947,3.588,9.947,7.037
  C84.922,43.684,82.418,47.27,74.975,47.27z"/>
<path '.$class.' fill="'.$fill.'" d="M106.915,0.376v40.397c0,3.992,1.963,5.346,3.924,5.346h1.828v5.683h-2.504
  c-5.616,0-9.338-3.18-9.338-10.556V0.376H106.915z"/>
<polygon '.$class.' fill="'.$fill.'" points="136.958,2.136 145.146,2.136 145.146,2.676 136.282,11.068 131.477,11.068 "/>
<path '.$class.' fill="'.$fill.'" d="M133.643,15.737c-3.181,0-7.375,0.473-12.722,2.706l2.64,5.075c3.315-1.624,6.428-2.436,9.744-2.436
  c4.735,0,10.555,1.285,10.555,7.105v3.653c-3.248-2.909-7.172-3.991-10.894-3.991c-9.812,0-15.292,5.684-15.292,12.111
  c0,7.85,6.766,12.654,15.36,12.654c4.668,0,8.118-1.354,11.231-4.602v3.789h5.685V27.714
  C149.95,19.323,142.102,15.737,133.643,15.737z M134.116,47.27c-7.443,0-9.947-3.586-9.947-7.037s2.504-7.037,9.947-7.037
  c7.442,0,9.946,3.586,9.946,7.037S141.559,47.27,134.116,47.27z"/>
</svg>';
  }

  if($tag=='icon_money'){
    $icon = '<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0z" fill="none"/><path '.$class.' fill="'.$fill.'"  d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1.41 16.09V20h-2.67v-1.93c-1.71-.36-3.16-1.46-3.27-3.4h1.96c.1 1.05.82 1.87 2.65 1.87 1.96 0 2.4-.98 2.4-1.59 0-.83-.44-1.61-2.67-2.14-2.48-.6-4.18-1.62-4.18-3.67 0-1.72 1.39-2.84 3.11-3.21V4h2.67v1.95c1.86.45 2.79 1.86 2.85 3.39H14.3c-.05-1.11-.64-1.87-2.22-1.87-1.5 0-2.4.68-2.4 1.64 0 .84.65 1.39 2.67 1.91s4.18 1.39 4.18 3.91c-.01 1.83-1.38 2.83-3.12 3.16z"/></svg>';
  }

  if($tag=='icon_heladera'){
    $icon = '<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path '.$class.' fill="'.$fill.'" d="M18 2.01L6 2c-1.1 0-2 .89-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.11-.9-1.99-2-1.99zM18 20H6v-9.02h12V20zm0-11H6V4h12v5zM8 5h2v3H8zm0 7h2v5H8z"/></svg>';
  }

   if($tag=='icon_pasos'){
    $icon = '<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0z" fill="none"/><path '.$class.' fill="'.$fill.'" d="M20 4h-4l-4-4-4 4H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H4V6h4.52l3.52-3.5L15.52 6H20v14zM18 8H6v10h12"/></svg>';
  }

  return $icon;

}
add_shortcode('icon_walla','_get_icon_FX');
add_shortcode('icon_arrow_next','_get_icon_FX');
add_shortcode('icon_pasos','_get_icon_FX');
add_shortcode('icon_heladera','_get_icon_FX');
add_shortcode('icon_money','_get_icon_FX');
add_shortcode('icon_time','_get_icon_FX');
add_shortcode('icon_porciones','_get_icon_FX');
add_shortcode('social_facebook','_get_icon_FX');
add_shortcode('social_instagram','_get_icon_FX');

function _get_title_FX($args, $content=NULL, $tag){

	$defs = array();  
	if(empty($args)){
		$args = array();
	} 
  $args = array_merge($defs, $args);

  if($tag=='title_claim'){
  	$class = 'title_claim gmb-2';  
  	$content_x = preg_replace('/(<[\s\S]*?>)|([^\s-\<]+)/',"$1<span>$2</span>", $content); 
  }

  return '<h2 class="section-title '.$class.'">'.$content_x.'</h2>';

}

add_shortcode('title_claim','_get_title_FX');



function _get_btn_FX($args, $content=NULL, $tag){

	$defs = array();  
	if(empty($args)){
		$args = array();
	} 
  $args = array_merge($defs, $args);
  $class = str_replace('btn_', 'btn-', $tag);
  if(!empty($args['icon'])){
  	$class .= ' btn-icon'; 
    $content = '['.$args['icon'].']';
  }  

  return '<a data-btn="fx" href="'.$args['href'].'" class="btn '.$class.'">'.$content.'</a>';

}
add_shortcode('btn_dark','_get_btn_FX');
add_shortcode('btn_primary','_get_btn_FX');
add_shortcode('btn_violeta','_get_btn_FX');
add_shortcode('btn_naranja','_get_btn_FX');
add_shortcode('btn_verde-oscuro','_get_btn_FX');
add_shortcode('btn_verde','_get_btn_FX');
add_shortcode('btn_rojo','_get_btn_FX');
add_shortcode('btn_celeste','_get_btn_FX');
add_shortcode('btn_rosa','_get_btn_FX');
add_shortcode('btn_rosa-claro','_get_btn_FX');

function _get_ui_list_tip_FX($args, $content=NULL, $tag){

  $defs = array();  
  if(empty($args)){
    $args = array();
  } 
  $args = array_merge($defs, $args); 

  //$content = str_replace("\n", "AJAJA", $content);

  $tmp_arr1= explode("\n\n",$content);
  $final_arr=array();
  // now $tmp_arr1 has n number of sections;
  foreach($tmp_arr1 as $section){
      $final_arr[]= explode("\n",$section);
  }
  $content="";
  foreach($final_arr as $section){
      $content.="<ul class='ui-list-tip'><li>";
      $content.=implode("</li><li>",$section);
      $content.="</li></ul>";
  }

  return $content;
  //return nl2br($content,false);

}

add_shortcode('ui_list_tip','_get_ui_list_tip_FX'); 