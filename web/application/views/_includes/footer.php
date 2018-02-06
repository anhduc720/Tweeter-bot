<?php 

	$this->general_model->js('jquery.js', TRUE);
	$this->general_model->js('tether.js', TRUE);
	$this->general_model->js('bootstrap.js', TRUE);
	$this->general_model->js('main.js', TRUE);
 ?>
</div>
</div>
</div>
 <footer>
 	<p class="text-center">
 		&copy<?=  date('Y') . ' - ' . $this->config->item('platform') . ' | ' . $this->config->item('platform_description'); ?>
 	</p>
 </footer>

</body>
</html>