<?php
$footer_whatsapp = WPBC_get_theme_settings('footer_whatsapp');
if(!empty($footer_whatsapp)){
?>
<a href="https://api.whatsapp.com/send?phone=<?php echo $footer_whatsapp; ?>" target="_blank" id="whatsapp-web-link"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="84" height="84" viewBox="0 0 84 84">
    <defs>
        <filter id="wfedbw47ba" width="146.9%" height="146.9%" x="-23.4%" y="-23.4%" filterUnits="objectBoundingBox">
            <feOffset in="SourceAlpha" result="shadowOffsetOuter1"/>
            <feGaussianBlur in="shadowOffsetOuter1" result="shadowBlurOuter1" stdDeviation="5"/>
            <feColorMatrix in="shadowBlurOuter1" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.299818841 0"/>
        </filter>
        <circle id="d7ugbxxdtb" cx="32" cy="32" r="32"/>
    </defs>
    <g fill="none" fill-rule="evenodd">
        <g>
            <g>
                <g fill-rule="nonzero" transform="translate(-1398 -3988) translate(1408 3998)">
                    <use fill="#000" filter="url(#wfedbw47ba)" xlink:href="#d7ugbxxdtb"/>
                    <use class="svg-hover-primary" fill="#00F200" xlink:href="#d7ugbxxdtb"/>
                </g>
                <g fill="#FFF">
                    <path d="M22.5 41C33.27 41 42 31.822 42 20.5S33.27 0 22.5 0 3 9.178 3 20.5 11.73 41 22.5 41z" transform="translate(-1398 -3988) translate(1408 3998) translate(10 11)"/>
                    <path d="M6.828 31.796L12.055 39.397 1.055 39.397z" transform="translate(-1398 -3988) translate(1408 3998) translate(10 11) rotate(-134 6.555 35.597)"/>
                </g>
                <path class="svg-hover-primary" fill="#00F200" d="M28.77 23.386l1.525 4.184s.157 1.19-1.37 2.307c-1.528 1.118 5.324 7.35 6.722 6.833 1.397-.517 2.003-2.879 2.003-2.879l4.346 2.411s.306 5.087-4.258 4.741c-4.564-.345-8.404-3.586-8.404-3.586s-6.62-6.154-5.11-11.062c1.51-4.908 4.546-2.95 4.546-2.95z" transform="translate(-1398 -3988) translate(1408 3998)"/>
            </g>
        </g>
    </g>
</svg>
</a>
<?php } ?>