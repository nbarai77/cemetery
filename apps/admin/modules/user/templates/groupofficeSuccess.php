<div id="wapper">
	<div class="clearb">&nbsp;</div>
    <?php
		if($sf_user->isSuperAdmin()):
			$ssUsername = sfConfig::get('app_goffice_username');
			$ssPassword = base64_encode(sfConfig::get('app_goffice_password'));
		else:
			$ssUsername = $sf_user->getAttribute('username', '', 'sfGuardSecurityUser');
			$ssPassword = $sf_user->getAttribute('code');
		endif;
        echo '<div>';
            echo '<div style="width:100%;float:left;">';    	
               echo '<div id="contentlisting">';?>
                        <iframe src="<?php echo sfConfig::get('app_goffice_url')?>/index.php?uname=<?php echo $ssUsername; ?>&sname=<?php echo $ssPassword; ?>" name="gofficeifrm"></iframe> 
				<?php
                    echo "</div>";                    
            echo '</div>';           
            echo '<div class="clearb">&nbsp;</div>';
        echo '</div>';        
    ?>
</div>
<script type="text/javascript">
	// For other good browsers.
	$('iframe').load(function() {
	  this.height = $(window).height() + 'px';
	  this.width = $('#wapper').width() + 'px';
	});
</script>