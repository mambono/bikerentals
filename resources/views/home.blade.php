@extends('layouts.app')
@section('content')

<script type="text/javascript">
	jQuery(document).ready(function()
	{
 
	update_vendor_bikes();  
	update_customer_bookings(); 
	update_bookingsdate(); 
	
	
});	
</script>	

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('ACME Bike Rentals') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
				<?PHP  
					if($usergroupname == 'Administrator')
					{
						?>
						
						<div class="col-md-12  row">
							<div class="col-md-4" style="border: 1px solid #ccc;">
									<div id="vendorbikes_count"></div>
							</div>
							<div class="col-md-4" style="border: 1px solid #ccc;">
								<div id="customerbookings"></div>
							</div>
							<div class="col-md-4" style="border: 1px solid #ccc; vertical-align: top;">
								<div style="margin-top:18px;" id="bikes-table-div"  class="data_holder"></div>
							</div>
						</div> 
						<?PHP
					}
					 
			  ?>
				
				
				
            </div>
        </div>
		
		 
    </div>
</div>


<script>

function update_vendor_bikes()
{ 
//colors: ['#314A68', '#AA4643', '#89A54E', '#5D10B7', '#3D96AE',    '#DB843D', '#92A8CD', '#A47D7C', '#B5CA92']
   
   
		Highcharts.setOptions({
 colors: ['#047704', '#FF0000', '#075099', '#314A68', '#5D10B7', '#EA5F09', '#9B8E04', '#207052']
});
		
		var options = {
			chart: {
				renderTo: 'vendorbikes_count',
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
				type: 'pie'
			}, 
			
			title: {
				text: 'Bike count by Vendor'
			},
			tooltip: {
					formatter: function() {
					return '<b>'+ this.point.name +'</b>: '+ this.y + ' ( '+ this.point.percent +'%)'; 
				}
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer', 
					showInLegend: true,
					dataLabels: {
						enabled: false 
				}
			}
			},
			legend: {
				itemStyle: {
					font: '14pt Trebuchet MS, Verdana, sans-serif',
					color: '#A0A0A0'
				}, 
				itemHiddenStyle: {
					color: '#444'
				},
				enabled: true, 
				labelFormatter: function() {
					return  this.name + ' ' + this.y + ' ( ' + this.percent + '%)';
				}
			},
			series: [{
				type: 'pie',
				name: 'Bike Share by Vendor',
				data: [], 
				point:{
				  events:{
					  click: function (event) 
					  { 
						 
					  }
				  }
			  } 
				
				
				
			}] 
		}
		 
		$.getJSON("<?= URL::to('/')?>/dashboard/vendorbikes", function(json) 
		{
			options.series[0].data = json;
			chart = new Highcharts.Chart(options);
		}); 
		 
}

function update_customer_bookings()
{ 
//colors: ['#314A68', '#AA4643', '#89A54E', '#5D10B7', '#3D96AE',    '#DB843D', '#92A8CD', '#A47D7C', '#B5CA92']
//colors: ['#047704', '#FF0000', '#075099', '#314A68', '#5D10B7', '#EA5F09', '#9B8E04', '#207052']   
   
		Highcharts.setOptions({
			colors: ['#314A68', '#AA4643', '#89A54E', '#5D10B7', '#3D96AE',    '#DB843D', '#92A8CD', '#A47D7C', '#B5CA92']
 
});
		
		var options = {
			chart: {
				renderTo: 'customerbookings',
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
				type: 'pie'
			}, 
			
			title: {
				text: 'Bookings share by Customer'
			},
			tooltip: {
					formatter: function() {
					return '<b>'+ this.point.name +'</b>: '+ this.y + ' ( '+ this.point.percent +'%)'; 
				}
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					showInLegend: true,
					dataLabels: {
						enabled: false 
				}
			}
			},
			legend: {
				itemStyle: {
					font: '14pt Trebuchet MS, Verdana, sans-serif',
					color: '#A0A0A0'
				}, 
				itemHiddenStyle: {
					color: '#444'
				},
				enabled: true, 
				labelFormatter: function() {
					return  this.name + ' ' + this.y + ' ( ' + this.percent + '%)';
				}
			},
			series: [{
				type: 'pie',
				name: 'Bookings share by Customer',
				data: [], 
				point:{
				  events:{
					  click: function (event) 
					  { 
						 
					  }
				  }
			  } 
				
				
				
			}] 
		}
		 
		$.getJSON("<?= URL::to('/')?>/dashboard/customerbookings", function(json) 
		{
			options.series[0].data = json;
			chart = new Highcharts.Chart(options);
		}); 
		 
}

 function update_bookingsdate()
{

    $("#bikes-table-div").html('Loading...');

    $.getJSON( "<?= URL::to('/') ?>/dashboard/bookingsdate", function( data ) {

        populate_bookingsdate(data);

    });

}
function populate_bookingsdate(data)
{
    var html  = '';
    if( data.code == 0 )
    {
        html = '<p class="text-center html-text-error ">' + data.text + '</p>';
        show_messages("error", data.text);
    }
    else
    {
         
 
		html  += '<h4>Bookings By Date</h4>';
		html  += '<table id="bikes-table" class="table-bordered datatable" width="100%" cellspacing="0" style="background-color:#ffffff;"> <thead> <tr> ';
        html += '<th width="40%">Date Booked </th>'; 
        html += '<th width="50%">Total Bookings </th>';  
        html += '</tr> <tbody>';
        


        $.each( data, function( key, val )
        {

            html += '<tr class="item" tabletype="bikes">'
			 
            html += '<td>' + val.booked_on + '</td>'; 
            html += '<td>' + val.response + '</td>';  
            html += '</tr>';
        });

        html += '</tbody></table> <br/>';
		 
		 

    }
    $("#bikes-table-div").html(html);   
}
	 
 
   
 
  
</script>
@endsection
