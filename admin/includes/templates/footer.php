	
	    <div class="footer">
	
        </div>
		      <script src="<?php echo $js; ?>jquery-3.4.1.min.js"></script>
		      <script src="<?php echo $js; ?>jquery-ui.min.js"></script>
		      <script src="<?php echo $js; ?>bootstrap.min.js"></script>
		      <script src="<?php echo $js; ?>jquery.selectBoxIt.min.js"></script>
		      <script defer src="<?php echo $js; ?>brands.min.js"></script>
              <script defer src="<?php echo $js; ?>solid.min.js"></script>
              <script defer src="<?php echo $js; ?>fontawesome.min.js"></script>
		      <script src="<?php echo $js; ?>backend.js"></script>
       

		</body>
		<script>
	$(document).ready(function(){
		var date_input=$('input[name="date"]'); //our date input has the name "date"
		var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
		date_input.datepicker({
			format: 'mm/dd/yyyy',
			container: container,
			todayHighlight: true,
			autoclose: true,
		})
	})
</script>
  </html>