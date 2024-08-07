<?php if ( get_option( 'business_ads-5' ) != '' ) { ?>
    <div id="topbar">
        <a href="" onclick="closebar(); return false"><span><button>X</button></span></a>
        <div class="ads-5">
<?php if ( get_option( 'business_ads-5' ) <> '' ) { echo stripslashes ( stripslashes ( get_option( 'business_ads-5' ) ) ); } ?>
        </div>
    </div> 
<?php } ?>