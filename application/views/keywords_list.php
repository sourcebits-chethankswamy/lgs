<div class="main_content">
	<div class='content_settings' style='padding:3% 28%;'>
		<div class='red margin-bottom-12 error_block' style='display:none;'>Keyword already exist</div>
		<legend style='border:1px solid #c6c6c6;border-bottom:none;'>
           <h1>Search Keywords Setup</h1>
	       	<?php if(!isset($keyword_list) || empty($keyword_list)) { ?>
           		<div class='red'>No Keywords present</div>
           <?php }?>
           <?php if(isset($keyword_list)) {
           		foreach($keyword_list as $keyword) { ?>
			       	<div class='keywords_tab'>
			    		<input type='text' value='<?php echo $keyword['keyword'];?>' id='<?php echo $keyword['id'];?>' class='keywords' name='' />
			    		<button class="btn btn-danger right delete" data-type='keywords' data-id='<?php echo $keyword['id']?>' type="button">Delete</button>
		    			<button class="btn btn-success right edit" data-type='keywords' data-id='<?php echo $keyword['id']?>'  type="button">Save</button>
			    	</div>
	    	<?php }}?>
	    	<div class='keywords_tab last-child'>
				<input type='text' value='' class='keywords' id='add_keyword' name='' />
	    		<button class="btn btn-primary right edit" data-type='keywords' data-id='0' type="button">Add</button>
			</div>
	    </legend>
    </div>
</div>