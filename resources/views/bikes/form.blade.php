<script type="text/javascript">
	jQuery(document).ready(function()
	{
		$('#frm_Bikes').validate({

				onkeyup: false,
				onfocusout: false,
				errorElement: "div",
				errorPlacement: function(error, element) {
					error.appendTo("div#errors2");
				},
				success: function (label, element) {
					$(element).parent().removeClass('has-error');
				},

			ignore: 'input[type=hidden]',
			rules:{ 

				short_name:{
					required:true,
				}, 
 
			},
			messages:{
		 
				short_name :"Please specify Name", 
			}
			,
			invalidHandler: function(form, validator) {
				//new $.flavr({ content: 'Please fill all required fields', buttons: false, autoclose: true, timeout: 3000 }); 
			},

			highlight: function (element) {
				$(element).closest('.form-group').addClass('has-error');
			},
			unhighlight: function (element) {
				$(element).closest('.form-group').removeClass('has-error');
			}
		});
		$("input[data-type='currency']").on({
    keyup: function() {
      formatCurrency($(this));
    },
    blur: function() { 
      formatCurrency($(this), "blur");
    }
});


function formatNumber(n) {
  // format number 1000000 to 1,234,567
  return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
}


function formatCurrency(input, blur) {
  //  validates decimal side
  // and puts cursor back in right position.
  
  // get input value
  var input_val = input.val();
  
  // don't validate empty input
  if (input_val === "") { return; }
  
  // original length
  var original_len = input_val.length;

  // initial caret position 
  var caret_pos = input.prop("selectionStart");
    
  // check for decimal
  if (input_val.indexOf(".") >= 0) {

    // get position of first decimal
    // this prevents multiple decimals from
    // being entered
    var decimal_pos = input_val.indexOf(".");

    // split number by decimal point
    var left_side = input_val.substring(0, decimal_pos);
    var right_side = input_val.substring(decimal_pos);

    // add commas to left side of number
    left_side = formatNumber(left_side);

    // validate right side
    right_side = formatNumber(right_side);
    
    // On blur make sure 2 numbers after decimal
    if (blur === "blur") {
      right_side += "00";
    }
    
    // Limit decimal to only 2 digits
    right_side = right_side.substring(0, 2);

    // join number by .
    input_val =  + left_side + "." + right_side;

  } else {
    // no decimal entered
    // add commas to number
    // remove all non-digits
    input_val = formatNumber(input_val);
    input_val =  + input_val;
    
    // final formatting
    if (blur === "blur") {
      input_val += ".00";
    }
  }
  
  // send updated string to input
  input.val(input_val);

  // put caret back in the right position
  var updated_len = input_val.length;
  caret_pos = updated_len - original_len + caret_pos;
  input[0].setSelectionRange(caret_pos, caret_pos);
}

	});
	
	
</script> 
<div style="margin-top:18px;" id="Bikes-table-div">
</div>
<br/>
<form class="form-horizontal ajax-submit" id="frm_Bikes" role="form" method="post" action="<?= URL::to('/') ?>/bikes/<?= $action ?>/<?= $id ?>" >
	@csrf
	<div style="color:Red" id="errors2"> </div> 
	<div class="form-group required row"> 
		<div class="col-md-3"><label class="control-label" for="short_name">Name:</label></div>
		<div class="col-md-8">
		 <input type="text" class="form-control" id="short_name" name="short_name" value="<?= (isset($form['short_name'])) ? $form['short_name'] : '';   ?>"  placeholder="Name">
		</div>
	</div> 
	<div class="form-group required row"> 
		<div class="col-md-3"><label class="control-label" for="short_name">Location:</label></div>
		<div class="col-md-8">{!! Form::select('city_id', $cities, $city_id, ['id' => 'city_id', 'class' => 'form-control', "placeholder" => 'Please select Location'])  !!}</div>
	</div>
	
	<div class="form-group required row"> 
		<div class="col-md-3"><label class="control-label" for="short_name">Vendor:</label></div> 
		<div class="col-md-8">{!! Form::select('vendor_id', $vendors, $vendor_id, ['id' => 'vendor_id', 'class' => 'form-control', "placeholder" => 'Please select Vendor'])  !!}</div>
	</div>
	
	<div class="form-group required row"> 
		<div class="col-md-3"><label class="control-label" for="short_name">Color:</label></div>
		<div class="col-md-8">
		 <input type="text" class="form-control" id="color" name="color" value="<?= (isset($form['color'])) ? $form['color'] : '';   ?>"  placeholder="Color">
		</div>
	</div>
	<div class="form-group required row"> 
		<div class="col-md-3"><label class="control-label" for="short_name">Hourly Cost(KES):</label></div>
		<div class="col-md-8">
		 <input type="text" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$"  data-type="currency" placeholder="KES 1,000.00" class="form-control" id="hourly_cost" name="hourly_cost" value="<?= (isset($form['hourly_cost'])) ? $form['hourly_cost'] : '';   ?>"  placeholder="Hourly Cost">
		</div>
	</div>
	<div class="form-group required row"> 
		<div class="col-md-3"><label class="control-label" for="short_name">Size:</label></div>
		<div class="col-md-8">
		 <input type="number" class="form-control" id="size" name="size"  min="1" max="30" value="<?= (isset($form['size'])) ? $form['size'] : '';   ?>"  placeholder="Size">
		</div>
	</div>
	<div class="form-group required row"> 
		<div class="col-md-3"><label class="control-label" for="short_name">Electric:</label></div>
		<div class="col-md-8">
		 <select id="electric" name="electric" class="form-control" >  
			<option value="0" <?php if($electric == '0'){echo 'selected';}  
			?>>NO</option>
			<option value="1" <?php if($electric == '1'){echo 'selected';}  
			?>>YES</option> 
	   </select>
			    
		</div>
	</div>
	<div class="form-group required row"> 
		<div class="col-md-3"><label class="control-label" for="short_name">Gear Speed:</label></div>
		<div class="col-md-8">
		 <input type="text" class="form-control" id="gear_speed" name="gear_speed" value="<?= (isset($form['gear_speed'])) ? $form['gear_speed'] : '';   ?>"  placeholder="Gear Speed">
		</div>
	</div>
	 
	
  <div class="form-group row">
    <div class="col-md-3"></div>
	<div class="col-md-8">
      <button type="submit" class="btn btn-default btn-primary ajax-submit"> <?= __($sbt_button)?></button>
    </div>
  </div> 
</form> 