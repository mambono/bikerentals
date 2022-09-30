@extends('layouts.app') 


@section('content') 

<script type="text/javascript">
function update_feedback_table()
{

    $("#feedback-table-div").html('Loading...');

    $.getJSON( "<?= URL::to('/') ?>/feedback", function( data ) {

        populate_feedback_table(data);

    });

}
function populate_feedback_table(data)
{
    var html  = '';
    if( data.code == 0 )
    {
        html = '<p class="text-center html-text-error ">' + data.text + '</p>';
        show_messages("error", data.text);
    }
    else
    {
         
 
		
		html  += '<table id="feedback-table" class="table-bordered datatable" width="100%" cellspacing="0" style="background-color:#ffffff;"> <thead> <tr> ';
        html += '<th width="1%">&nbsp; </th>';
        html += '<th width="79%">Comments </th>'; 
        html += '<th width="20%">Submitted On </th>'; 
        html += '</tr> <tbody>';
        


        $.each( data, function( key, val )
        {

            html += '<tr class="item" tabletype="feedback" recordid="' + val.id +'" id="' + val.id +'"><td>&nbsp;</td>'
            
            html += '<td>' + val.comments + '</td>';  
            html += '<td>' + val.created_on + ' ' + val.created_by + '</td>'; 
            
            html += '</tr>';
        });

        html += '</tbody></table> <br/>';
		
         html += '<a href="<?= URL::to('/') ?>/feedback/add/" id="feedback-add-feedback" class="btn btn-primary feedback-add-link btn" >Add</a>&nbsp;';
		 

    }
    $("#feedback-table-div").html(html);
    $('#feedback-table').dataTable({
        'aaSorting':[[1,'asc']],
        'aoColumnDefs': [{
            'bSortable': false,
            'aTargets': [0] /* 1st one, start by the right */
        }],
        "oLanguage": {
            "sSearch": "Search/Filter:"
        }
    });  
}

$(function() {

    $.ajaxSetup({ cache: false });

    update_feedback_table();

    $('body').on('click', '.feedback-add-link', function(event) {

        $.ajax( "<?= URL::to('/') ?>/feedback/add/form" )
            .done(function(resp) {
                body = resp ;
                if( resp.code == 0 )
                {
                    body = '<p class="text-center text-error">' + resp.text + '</p>';
                }
                show_popup('Add Comments ', body, '', 'modal-dialog');
            })
            .fail(function() {
                body = 'Error loading New Comments  form';
                show_popup('Add Comments ', body, '', 'modal-dialog');
            });
        event.preventDefault();
        return false;

        //show_popup(title, body, footer, modalsize)

    });
 


    $('body').on('click', '.feedback-edit-link', function(event) {

        var id = $(this).attr('feedback_editid');

        $.ajax( "<?= URL::to('/') ?>/feedback/edit/" + id )
            .done(function(resp) {
                body = resp ;
                if( resp.code == 0 )
                {
                    body = '<p class="text-center text-error">' + resp.text + '</p>';
                }
                show_popup('Edit Comments ', body, '', 'modal-dialog');
            })
            .fail(function() {
                body = 'Error loading Comments  Edit form';
                show_popup('Edit Comments ', body, '', 'modal-dialog');
            });

     
        event.preventDefault();
        return false;

    });

    $('body').on('click', '.feedback-delete-link', function(event) {
		
        var id = $(this).attr('feedback_editid'); 

        $.ajax( "<?= URL::to('/') ?>/feedback/delete/" + id )
            .done(function(resp) {
                body = resp ;
                if( resp.code == 0 )
                {
                    body = '<p class="text-center text-error">' + resp.text + '</p>';
                }
                show_popup('Delete Comments ', body, '', null);
            })
            .fail(function() {
                body = 'Error loading Comments  Delete form';
                show_popup('Delete Comments ', body, '', null);
            });

      
        event.preventDefault();
        return false;

    });

    $('body').on('submit', '.ajax-submit', function(event) {

        var options = {
            dataType: 'json',
            success:    function(resp) {

                if( resp.code == 1 )
                {
                    $('#default-modal .modal-footer').html('<p class="text-center text-success">' + resp.text + '</p>').fadeIn();
                        if(resp.action == 'add')
                        {
                            $(':input','#frm_feedback')
                            .not(':button, :submit, :reset, :hidden')
                            .val('');
                            
                            
                            $('#name').focus();

                            setTimeout(function(){
                                $( "p" ).empty();
                            }, 5000);
                        }
                        else
                        {
                            //new $.flavr({ content: resp.text, buttons: false, autoclose: true, timeout: 3000 }); 
                            $('#default-modal').modal('hide');
                        }

                    update_feedback_table();
                }
                else
                {
                    $('#default-modal .modal-footer').html('<p class="text-center text-danger">' + resp.text + '</p>').fadeIn();;
                }
            }
        };

        $(this).ajaxSubmit(options);
        // return false to prevent normal browser submit and page navigation 
        event.preventDefault();
        return false;

    });


});

</script>
<h2><?= __("Feedback") ?></h2>

<div style="margin-top:18px;" id="feedback-table-div"  class="data_holder">
</div>
 

@endsection